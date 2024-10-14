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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('rate_id');
            $table->string('name');
            $table->string('contact_number');
            $table->string('venue');
            $table->timestamp('date');
            $table->text('event_details')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', [
                'cancelled', 
                'pending', 
                'confirmed',
                'out_of_delivery',
                'delivered',
                'complete'
            ]);
            $table->enum('contract_payments', [
                'down_payment',
                'full_payment'
            ]);
            $table->string('payment_method');
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
