<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{

    /**
     * Store checkout (COD or Online)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'phone'         => 'required|string',
            'address'       => 'required|string',
            'delivery_date' => 'required|date|after:today',
            'payment_method'=> 'required|in:cod,online',
            'coupon_code'   => 'nullable|string|max:50',
        ]);

        if (session()->has('payment_in_progress')) {
            return response()->json([
                'success' => false,
                'message' => 'Payment already in progress'
            ],429);
        }

        $cartArray = $this->getCartItems();

        if(empty($cartArray)){
            return redirect()->route('home')
            ->with('error','Cart is empty');
        }

        $total = $this->calculateTotal($cartArray);

        if($request->payment_method === 'cod'){

            $order = $this->placeOrder($request,$cartArray,$total);

            return redirect()->route('order.success',$order->id)
            ->with('success','Order placed successfully');
        }

        try{

            session()->put('payment_in_progress',true);

            $api = new Api(env('RAZORPAY_KEY_ID'),env('RAZORPAY_KEY_SECRET'));

            $receipt = 'order_'.time().'_'.uniqid();

            $razorpayOrder = $api->order->create([
                'receipt'=>$receipt,
                'amount'=>$total*100,
                'currency'=>'INR',
                'payment_capture'=>1
            ]);

            session()->put('pending_order',[
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'delivery_date'=>$request->delivery_date,
                'payment_method'=>$request->payment_method,
                'coupon_code'=>$request->coupon_code,
                'cart'=>$cartArray,
                'total'=>$total,
                'razorpay_order_id'=>$razorpayOrder->id
            ]);

            return response()->json([
                'success'=>true,
                'razorpay_key'=>env('RAZORPAY_KEY_ID'),
                'amount'=>$total*100,
                'currency'=>'INR',
                'order_id'=>$razorpayOrder->id,
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone
            ]);

        }catch(\Exception $e){

            session()->forget('payment_in_progress');

            return response()->json([
                'success'=>false,
                'message'=>'Payment failed: '.$e->getMessage()
            ],500);
        }
    }


    /**
     * Verify Razorpay Payment
     */
    public function verifyPayment(Request $request)
    {
        $pendingOrder = session()->get('pending_order');

        if(!$pendingOrder){
            return response()->json([
                'success'=>false,
                'message'=>'No pending order'
            ],400);
        }

        try{

            $api = new Api(env('RAZORPAY_KEY_ID'),env('RAZORPAY_KEY_SECRET'));

            $attributes = [
                'razorpay_order_id'=>$request->razorpay_order_id,
                'razorpay_payment_id'=>$request->razorpay_payment_id,
                'razorpay_signature'=>$request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $order = $this->placeOrder(
                (object)$pendingOrder,
                $pendingOrder['cart'],
                $pendingOrder['total']
            );

            $order->razorpay_order_id = $request->razorpay_order_id;
            $order->save();

            session()->forget('pending_order');
            session()->forget('payment_in_progress');

            return response()->json([
                'success'=>true,
                'redirect_url'=>route('order.success',$order->id)
            ]);

        }catch(\Exception $e){

            session()->forget('payment_in_progress');

            return response()->json([
                'success'=>false,
                'message'=>'Verification failed'
            ],500);
        }
    }


    /**
     * Success Page
     */
    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order.success',compact('order'));
    }



    /**
     * Place Order
     */
    private function placeOrder($data,$cartArray,$total)
    {

        return DB::transaction(function() use ($data,$cartArray,$total){

            $order = Order::create([

                'user_id'=>auth()->id(),
                'name'=>$data->name,
                'email'=>$data->email,
                'phone'=>$data->phone,
                'address'=>$data->address,
                'delivery_date'=>$data->delivery_date,

                'total_amount'=>$total,

                'status'=>$data->payment_method==='cod'
                    ? 'pending'
                    : 'paid',

                'payment_method'=>$data->payment_method,

                'coupon_code'=>$data->coupon_code,

                'discount_amount'=>0,

                // ⭐ IMPORTANT
                'order_source'=>'online'

            ]);

            foreach($cartArray as $item){

                $product = $item['product']
                    ?? Product::findOrFail($item['product_id']);

                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$item['product_id'],
                    'quantity'=>$item['quantity'],
                    'weight'=>$item['weight'] ?? 1,
                    'price'=>$product->price
                ]);
            }

            $this->clearCart();

            return $order;
        });
    }



    private function getCartItems()
    {
        if(Auth::check()){

            $cart = Auth::user()->cart;

            if(!$cart) return [];

            $items = $cart->items()->with('product')->get();

            $cartArray = [];

            foreach($items as $item){

                $cartArray[]=[
                    'product_id'=>$item->product_id,
                    'quantity'=>$item->quantity,
                    'weight'=>$item->weight,
                    'product'=>$item->product
                ];
            }

            return $cartArray;
        }

        return session()->get('cart',[]);
    }



    private function calculateTotal($cartArray)
    {
        $total=0;

        foreach($cartArray as $item){

            $product = $item['product']
            ?? Product::findOrFail($item['product_id']);

            $total += $product->price
                * $item['weight']
                * $item['quantity'];
        }

        return $total;
    }



    private function clearCart()
    {
        if(Auth::check()){

            $cart = Auth::user()->cart;

            if($cart){
                $cart->items()->delete();
            }

        }else{

            session()->forget('cart');
        }
    }
}