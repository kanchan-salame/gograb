<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('restaurant_id');
            $table->integer('restaurant_menu_id');
            $table->integer('restaurant_menu_item_id');
            $table->string('status')->nullable();
            $table->string('status_reason')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price')->nullable();
            $table->string('delivery_charge')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->double('tax')->nullable();
            $table->double('instructions')->nullable();
            $table->double('discount')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_orders');
    }
};
