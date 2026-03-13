<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('walk_in_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('order_date');
            $table->date('delivery_date');
            $table->enum('delivery_slot', ['morning', 'afternoon', 'evening'])->default('morning');
            $table->enum('order_type', ['pickup', 'delivery'])->default('pickup');
            $table->text('admin_note')->nullable();
            $table->enum('payment_method', ['cash', 'upi', 'card'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('walk_in_orders');
    }
};