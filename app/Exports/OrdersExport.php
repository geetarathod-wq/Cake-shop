<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $start;
    protected $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        return Order::with('user', 'items.product')
            ->when($this->start, fn($q) => $q->whereDate('created_at', '>=', $this->start))
            ->when($this->end,   fn($q) => $q->whereDate('created_at', '<=', $this->end))
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer',
            'Email',
            'Total',
            'Payment Method',
            'Payment Status',
            'Order Type',
            'Status',
            'Order Date',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->name,
            $order->email,
            $order->total_amount,
            $order->payment_method,
            $order->payment_status,
            $order->order_type,
            $order->status,
            $order->created_at->format('Y-m-d H:i'),
        ];
    }
}