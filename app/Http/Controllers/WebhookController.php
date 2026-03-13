<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleRazorpayWebhook(Request $request)
    {
        // Retrieve the request's body and parse it as JSON
        $payload = $request->getContent();
        $webhookEvent = json_decode($payload, true);

        // Log the webhook for debugging (optional)
        Log::info('Razorpay webhook received', $webhookEvent);

        // Verify the webhook signature (see Step 3)
        if (!$this->verifyRazorpaySignature($payload, $request->header('X-Razorpay-Signature'))) {
            Log::warning('Invalid webhook signature');
            return response()->json(['status' => 'invalid signature'], 400);
        }

        // Handle the event based on its type
        $event = $webhookEvent['event'] ?? null;

        switch ($event) {
            case 'payment.captured':
                $this->handlePaymentCaptured($webhookEvent['payload']['payment']['entity']);
                break;

            case 'payment.failed':
                $this->handlePaymentFailed($webhookEvent['payload']['payment']['entity']);
                break;

            default:
                Log::info('Unhandled webhook event: ' . $event);
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Verify Razorpay webhook signature
     */
    private function verifyRazorpaySignature($payload, $signature)
    {
        $secret = env('RAZORPAY_WEBHOOK_SECRET');
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Handle payment.captured event
     */
    private function handlePaymentCaptured($payment)
    {
        $razorpayOrderId = $payment['order_id'];
        $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();

        if ($order && $order->status !== 'paid') {
            $order->status = 'paid';
            $order->save();

            Log::info("Order {$order->id} marked as paid via webhook.");
        }
    }

    /**
     * Handle payment.failed event (optional)
     */
    private function handlePaymentFailed($payment)
    {
        $razorpayOrderId = $payment['order_id'];
        $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();

        if ($order && $order->status !== 'failed') {
            $order->status = 'failed';
            $order->save();

            Log::info("Order {$order->id} marked as failed via webhook.");
        }
    }
}