<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique(); // TRX-XXXXX
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total', 12, 2);
            $table->enum('payment_method', ['cash', 'card', 'e-wallet']);
            $table->decimal('cash_amount', 12, 2)->nullable();
            $table->decimal('change', 12, 2)->nullable();
            $table->timestamp('transaction_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
