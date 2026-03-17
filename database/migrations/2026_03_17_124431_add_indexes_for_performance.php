<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->index('status');
        $table->index('created_at');
        $table->index('user_id');
    });

    Schema::table('order_items', function (Blueprint $table) {
        $table->index('order_id');
        $table->index('product_id');
    });

    Schema::table('products', function (Blueprint $table) {
        $table->index('category_id');
        $table->index('is_active');
    });
}
};
