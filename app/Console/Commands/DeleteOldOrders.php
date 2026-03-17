<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeleteOldOrders extends Command
{
    protected $signature = 'orders:delete-old {--days=90 : Delete orders older than this many days} {--chunk=1000 : Number of orders to delete per batch}';
    protected $description = 'Delete orders older than specified days in batches';

    public function handle()
    {
        $days = $this->option('days');
        $chunkSize = $this->option('chunk');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Deleting orders older than {$cutoffDate->toDateString()}...");

        $total = Order::where('created_at', '<', $cutoffDate)->count();
        $this->info("Total orders to delete: {$total}");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $deleted = 0;
        Order::where('created_at', '<', $cutoffDate)
            ->chunkById($chunkSize, function ($orders) use ($bar, &$deleted) {
                $orderIds = $orders->pluck('id');

                OrderItem::whereIn('order_id', $orderIds)->delete();
                Order::whereIn('id', $orderIds)->delete();

                $deleted += $orders->count();
                $bar->advance($orders->count());
            });

        $bar->finish();
        $this->newLine();
        $this->info("Deleted {$deleted} orders successfully.");

        if ($this->confirm('Do you want to optimize the orders and order_items tables?')) {
            DB::statement('OPTIMIZE TABLE orders');
            DB::statement('OPTIMIZE TABLE order_items');
            $this->info('Tables optimized.');
        }
    }
}