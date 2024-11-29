<?php

use App\Models\Order;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('rate_id');
            $table->string('name');
            $table->string('contact_number');
            $table->string('venue');
            $table->dateTime('event_date');
            $table->string('event_type');
            $table->decimal('total_amount')->nullable();
            $table->decimal('reservation_fee')->defaul(3000);
            $table->text('message')->nullable();
            $table->enum('status', [
                Order::STATUS_CANCELLED, 
                Order::STATUS_PENDING, 
                Order::STATUS_RESERVATION_FEE_PAID,
                Order::STATUS_DOWN_PAYMENT_PAID,
                Order::STATUS_FULLY_PAID,
                Order::STATUS_COMPLETE,
                Order::STATUS_DOWN_PAYMENT_PENDING,
                Order::STATUS_RESERVATION_FEE_PENDING,
                Order::STATUS_FULLY_PAID_PENDING
            ])->default(Order::STATUS_PENDING);
            $table->enum('payment_type', [
                'down_payment',
                'full_payment',
                'reservation_fee'
            ])->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
