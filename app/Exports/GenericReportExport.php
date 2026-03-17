<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class GenericReportExport implements FromArray, WithTitle
{
    protected $data;
    protected $reportType;

    public function __construct($data, $reportType)
    {
        $this->data = $data;
        $this->reportType = $reportType;
    }

    public function array(): array
    {
        $method = 'format' . str_replace('-', '', ucwords($this->reportType, '-'));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return $this->defaultFormat();
    }

    public function title(): string
    {
        return str_replace('-', ' ', ucwords($this->reportType, '-'));
    }

    /**
     * Safely get value from object or array
     */
    private function getValue($item, $key, $default = '')
    {
        if (is_object($item)) {
            return $item->$key ?? $default;
        }
        return $item[$key] ?? $default;
    }

    /* ==================== FORMATTERS ==================== */

    private function formatDailySales(): array
    {
        $rows = [];
        $rows[] = ['DAILY SALES REPORT'];
        $rows[] = ['Date:', $this->getValue($this->data['summary'] ?? [], 'date', now()->toDateString())];
        $rows[] = [];
        $rows[] = ['SUMMARY'];
        $rows[] = ['Total Orders', $this->getValue($this->data['summary'] ?? [], 'total_orders', 0)];
        $rows[] = ['Total Revenue', $this->getValue($this->data['summary'] ?? [], 'total_revenue', 0)];
        $rows[] = ['Average Order Value', $this->getValue($this->data['summary'] ?? [], 'average_order_value', 0)];
        $rows[] = [];

        $rows[] = ['PAYMENT METHOD BREAKDOWN'];
        $rows[] = ['Method', 'Orders', 'Revenue'];
        foreach ($this->data['payment_breakdown'] ?? [] as $item) {
            $rows[] = [
                $this->getValue($item, 'payment_method', 'N/A'),
                $this->getValue($item, 'order_count', 0),
                $this->getValue($item, 'revenue', 0),
            ];
        }
        $rows[] = [];

        $rows[] = ['ORDERS BY STATUS'];
        $rows[] = ['Status', 'Orders', 'Revenue'];
        foreach ($this->data['orders_by_status'] ?? [] as $item) {
            $rows[] = [
                $this->getValue($item, 'status', 'N/A'),
                $this->getValue($item, 'count', 0),
                $this->getValue($item, 'revenue', 0),
            ];
        }
        return $rows;
    }

    private function formatMonthlySales(): array
    {
        $rows = [];
        $rows[] = ['MONTHLY SALES OVERVIEW'];
        $rows[] = [];

        $rows[] = ['CURRENT MONTH SUMMARY'];
        $rows[] = ['Total Orders', $this->getValue($this->data['current_month'] ?? [], 'total_orders', 0)];
        $rows[] = ['Total Revenue', $this->getValue($this->data['current_month'] ?? [], 'total_revenue', 0)];
        $rows[] = ['Average Order', $this->getValue($this->data['current_month'] ?? [], 'average_order', 0)];
        $rows[] = ['Growth', ($this->getValue($this->data, 'growth_percentage', 0)) . '%'];
        $rows[] = [];

        $rows[] = ['DAILY TREND'];
        $rows[] = ['Date', 'Orders', 'Revenue'];
        foreach ($this->data['daily_trend'] ?? [] as $day) {
            $rows[] = [
                $this->getValue($day, 'date', ''),
                $this->getValue($day, 'orders', 0),
                $this->getValue($day, 'revenue', 0),
            ];
        }
        return $rows;
    }

    private function formatProductSales(): array
    {
        $rows = [['Product', 'Category', 'Quantity Sold', 'Revenue', 'Avg Price']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'product_name', 'N/A'),
                $this->getValue($item, 'category', 'N/A'),
                $this->getValue($item, 'quantity_sold', 0),
                $this->getValue($item, 'revenue', 0),
                $this->getValue($item, 'avg_price', 0),
            ];
        }
        return $rows;
    }

    private function formatCategorySales(): array
    {
        $rows = [['Category', 'Products', 'Total Quantity', 'Total Revenue']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'category_name', 'N/A'),
                $this->getValue($item, 'product_count', 0),
                $this->getValue($item, 'total_quantity', 0),
                $this->getValue($item, 'total_revenue', 0),
            ];
        }
        return $rows;
    }

    private function formatTopProducts(): array
    {
        $rows = [['Rank', 'Product', 'Category', 'Quantity Sold', 'Revenue']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'rank', 0),
                $this->getValue($item, 'product_name', 'N/A'),
                $this->getValue($item, 'category', 'N/A'),
                $this->getValue($item, 'quantity_sold', 0),
                $this->getValue($item, 'revenue', 0),
            ];
        }
        return $rows;
    }

    private function formatLowProducts(): array
    {
        $rows = [['Product', 'Category', 'Price', 'Quantity Sold', 'Status']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'product_name', 'N/A'),
                $this->getValue($item, 'category', 'N/A'),
                $this->getValue($item, 'price', 0),
                $this->getValue($item, 'quantity_sold', 0),
                $this->getValue($item, 'status', 'N/A'),
            ];
        }
        return $rows;
    }

    private function formatOrderSummary(): array
    {
        $rows = [];
        $rows[] = ['ORDER SUMMARY'];
        $rows[] = ['Total Orders:', $this->getValue($this->data['summary'] ?? [], 'total_orders', 0)];
        $rows[] = ['Total Value:', $this->getValue($this->data['summary'] ?? [], 'total_value', 0)];
        $rows[] = [];
        $rows[] = ['Status', 'Orders', 'Value', '%'];
        foreach ($this->data['data'] ?? [] as $item) {
            $totalValue = $this->getValue($this->data['summary'] ?? [], 'total_value', 1);
            $percentage = ($this->getValue($item, 'total_value', 0) / $totalValue) * 100;
            $rows[] = [
                $this->getValue($item, 'status', 'N/A'),
                $this->getValue($item, 'order_count', 0),
                $this->getValue($item, 'total_value', 0),
                round($percentage, 1) . '%',
            ];
        }
        return $rows;
    }

    private function formatCustomOrders(): array
    {
        $rows = [['Order #', 'Customer', 'Message', 'Instructions', 'Amount', 'Status']];
        foreach ($this->data as $order) {
            $rows[] = [
                $this->getValue($order, 'order_number', ''),
                $this->getValue($order, 'customer_name', ''),
                $this->getValue($order, 'cake_message', '-'),
                $this->getValue($order, 'special_instructions', '-'),
                $this->getValue($order, 'total_amount', 0),
                $this->getValue($order, 'status', ''),
            ];
        }
        return $rows;
    }

    private function formatOrderType(): array
    {
        $rows = [];
        $rows[] = ['PRE-ORDER VS WALK-IN'];
        $rows[] = ['Type', 'Orders', 'Revenue', 'Average'];
        $rows[] = [
            'Pre-orders',
            $this->getValue($this->data['pre_orders'] ?? [], 'count', 0),
            $this->getValue($this->data['pre_orders'] ?? [], 'revenue', 0),
            $this->getValue($this->data['pre_orders'] ?? [], 'average', 0),
        ];
        $rows[] = [
            'Walk-in',
            $this->getValue($this->data['walk_in'] ?? [], 'count', 0),
            $this->getValue($this->data['walk_in'] ?? [], 'revenue', 0),
            $this->getValue($this->data['walk_in'] ?? [], 'average', 0),
        ];
        return $rows;
    }

    private function formatDeliveryOrders(): array
    {
        $rows = [['Order ID', 'Customer', 'Address', 'Delivery Date', 'Slot', 'Status', 'Amount']];
        foreach ($this->data as $order) {
            $rows[] = [
                '#' . $this->getValue($order, 'id', ''),
                $this->getValue($order, 'name', ''),
                $this->getValue($order, 'address', ''),
                $this->getValue($order, 'delivery_date', ''),
                $this->getValue($order, 'delivery_slot', ''),
                $this->getValue($order, 'status', ''),
                $this->getValue($order, 'total_amount', 0),
            ];
        }
        return $rows;
    }

    private function formatPickupOrders(): array
    {
        $rows = [['Order ID', 'Customer', 'Pickup Date', 'Slot', 'Status', 'Amount']];
        foreach ($this->data as $order) {
            $rows[] = [
                '#' . $this->getValue($order, 'id', ''),
                $this->getValue($order, 'name', ''),
                $this->getValue($order, 'pickup_date', ''),
                $this->getValue($order, 'pickup_slot', ''),
                $this->getValue($order, 'status', ''),
                $this->getValue($order, 'total_amount', 0),
            ];
        }
        return $rows;
    }

    private function formatTopCustomers(): array
    {
        $rows = [['Rank', 'Name', 'Email', 'Orders', 'Total Spent', 'Avg Order']];
        foreach ($this->data as $c) {
            $rows[] = [
                '#' . $this->getValue($c, 'rank', 0),
                $this->getValue($c, 'name', ''),
                $this->getValue($c, 'email', ''),
                $this->getValue($c, 'total_orders', 0),
                $this->getValue($c, 'total_spent', 0),
                $this->getValue($c, 'average_order', 0),
            ];
        }
        return $rows;
    }

    private function formatCustomerHistory(): array
    {
        $rows = [];
        $rows[] = ['CUSTOMER HISTORY'];
        $rows[] = ['Name:', $this->getValue($this->data['customer'] ?? [], 'name', '')];
        $rows[] = ['Email:', $this->getValue($this->data['customer'] ?? [], 'email', '')];
        $rows[] = ['Phone:', $this->getValue($this->data['customer'] ?? [], 'phone', '')];
        $rows[] = ['Member Since:', $this->getValue($this->data['customer'] ?? [], 'member_since', '')];
        $rows[] = [];
        $rows[] = ['SUMMARY'];
        $rows[] = ['Total Orders', $this->getValue($this->data['summary'] ?? [], 'total_orders', 0)];
        $rows[] = ['Total Spent', $this->getValue($this->data['summary'] ?? [], 'total_spent', 0)];
        $rows[] = ['Average Order', $this->getValue($this->data['summary'] ?? [], 'average_order', 0)];
        $rows[] = [];
        $rows[] = ['ORDER HISTORY'];
        $rows[] = ['Order #', 'Date', 'Amount', 'Status', 'Payment'];
        foreach ($this->data['orders'] ?? [] as $order) {
            $rows[] = [
                $this->getValue($order, 'order_number', ''),
                $this->getValue($order, 'date', ''),
                $this->getValue($order, 'total', 0),
                $this->getValue($order, 'status', ''),
                $this->getValue($order, 'payment_method', ''),
            ];
        }
        return $rows;
    }

    private function formatNewReturning(): array
    {
        $rows = [['Type', 'Count', 'Revenue', 'Percentage']];
        $rows[] = [
            'New Customers',
            $this->getValue($this->data['new'] ?? [], 'customer_count', 0),
            $this->getValue($this->data['new'] ?? [], 'revenue', 0),
            ($this->getValue($this->data['new'] ?? [], 'percentage', 0)) . '%',
        ];
        $rows[] = [
            'Returning Customers',
            $this->getValue($this->data['returning'] ?? [], 'customer_count', 0),
            $this->getValue($this->data['returning'] ?? [], 'revenue', 0),
            ($this->getValue($this->data['returning'] ?? [], 'percentage', 0)) . '%',
        ];
        return $rows;
    }

    private function formatCustomerFrequency(): array
    {
        $rows = [['Frequency', 'Customers']];
        $rows[] = ['Weekly', $this->getValue($this->data, 'weekly', 0)];
        $rows[] = ['Monthly', $this->getValue($this->data, 'monthly', 0)];
        $rows[] = ['Quarterly', $this->getValue($this->data, 'quarterly', 0)];
        $rows[] = ['Yearly', $this->getValue($this->data, 'yearly', 0)];
        $rows[] = ['One-time', $this->getValue($this->data, 'one_time', 0)];
        return $rows;
    }

    private function formatMaterialUsage(): array
    {
        $rows = [['Ingredient', 'Used']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'name', ''),
                $this->getValue($item, 'used', 0),
            ];
        }
        return $rows;
    }

    private function formatLowStock(): array
    {
        if (empty($this->data)) {
            return [['No low stock items found.']];
        }
        $rows = [['Product', 'Stock']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'name', $this->getValue($item, 'product_name', 'Unknown')),
                $this->getValue($item, 'current_stock', $this->getValue($item, 'stock', 0)),
            ];
        }
        return $rows;
    }

    private function formatStockMovement(): array
    {
        $rows = [['Ingredient', 'Added', 'Used', 'Waste']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'name', ''),
                $this->getValue($item, 'added', 0),
                $this->getValue($item, 'used', 0),
                $this->getValue($item, 'waste', 0),
            ];
        }
        return $rows;
    }

    private function formatProfitMargin(): array
    {
        if (empty($this->data)) {
            return [['No profit margin data available.']];
        }
        $rows = [['Product', 'Price', 'Cost', 'Qty', 'Revenue', 'Profit', 'Margin %']];
        foreach ($this->data as $item) {
            $quantity = $this->getValue($item, 'quantity', 1);
            $cost = $this->getValue($item, 'cost_total', 0) / max($quantity, 1);
            $rows[] = [
                $this->getValue($item, 'product_name', ''),
                $this->getValue($item, 'price', 0),
                round($cost, 2),
                $quantity,
                $this->getValue($item, 'revenue', 0),
                $this->getValue($item, 'profit', 0),
                ($this->getValue($item, 'margin', 0)) . '%',
            ];
        }
        return $rows;
    }

    private function formatDiscountReport(): array
    {
        $rows = [];
        $rows[] = ['DISCOUNT IMPACT REPORT'];
        $rows[] = ['Total Orders', $this->getValue($this->data, 'total_orders', 0)];
        $rows[] = ['Discounted Orders', $this->getValue($this->data, 'discounted_orders', 0)];
        $rows[] = ['Total Discount Given', $this->getValue($this->data, 'total_discount_given', 0)];
        $rows[] = ['Average Discount', $this->getValue($this->data, 'average_discount', 0)];
        $rows[] = ['Revenue Impact', ($this->getValue($this->data, 'revenue_impact', 0)) . '%'];
        return $rows;
    }

    private function formatPaymentMethods(): array
    {
        $rows = [['Payment Method', 'Orders', 'Revenue', 'Percentage']];
        foreach ($this->data as $item) {
            $rows[] = [
                $this->getValue($item, 'payment_method', ''),
                $this->getValue($item, 'order_count', 0),
                $this->getValue($item, 'revenue', 0),
                ($this->getValue($item, 'percentage', 0)) . '%',
            ];
        }
        return $rows;
    }

    private function defaultFormat(): array
    {
        if (is_array($this->data) || is_object($this->data)) {
            return json_decode(json_encode($this->data), true);
        }
        return [];
    }
}