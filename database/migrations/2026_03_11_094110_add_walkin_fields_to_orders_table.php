<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add order_type only if it doesn't exist
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->string('order_type')->default('online')->after('id');
            }

            // Add customer_name only if it doesn't exist
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('user_id');
            }

            // Add phone only if it doesn't exist
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->nullable()->after('customer_name');
            }

            // Add address only if it doesn't exist
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }

            // Add delivery_slot only if it doesn't exist
            if (!Schema::hasColumn('orders', 'delivery_slot')) {
                $table->enum('delivery_slot', ['morning', 'afternoon', 'evening'])->nullable()->after('delivery_date');
            }

            // Add admin_note only if it doesn't exist
            if (!Schema::hasColumn('orders', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('delivery_slot');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop columns only if they exist
            $columns = ['order_type', 'customer_name', 'phone', 'address', 'delivery_slot', 'admin_note'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};