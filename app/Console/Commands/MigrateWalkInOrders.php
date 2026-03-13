<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WalkInOrder;
use App\Models\WalkInOrderItem;
use Illuminate\Console\Command;

class MigrateWalkInOrders extends Command
{
    protected $signature = 'migrate:walkin-orders';
    protected $description = 'Migrate all walk-in orders to the main orders table';

    public function handle()
    {
        $this->info('Starting migration of walk-in orders...');

        // Get all walk-in orders with their items
        $walkInOrders = WalkInOrder::with('items')->get();

        $bar = $this->output->createProgressBar($walkInOrders->count());
        $bar->start();

        foreach ($walkInOrders as $walkIn) {
            // Create a new order in the main orders table
            $order = Order::create([
                'order_type'      => 'walkin',
                'user_id'         => null, // walk-ins have no user
                'customer_name'   => $walkIn->customer_name,
                'phone'           => $walkIn->phone,
                'email'           => $walkIn->email,
                'address'         => $walkIn->address,
                'total_amount'    => $walkIn->subtotal,
                'status'          => $walkIn->payment_status == 'paid' ? 'delivered' : 'pending', // map as needed
                'payment_method'  => $walkIn->payment_method,
                'delivery_date'   => $walkIn->delivery_date,
                'delivery_slot'   => $walkIn->delivery_slot,
                'admin_note'      => $walkIn->admin_note,
                'created_at'      => $walkIn->created_at,
                'updated_at'      => $walkIn->updated_at,
            ]);

            // Transfer order items
            foreach ($walkIn->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All walk-in orders migrated successfully!');

        return Command::SUCCESS;
    }
}