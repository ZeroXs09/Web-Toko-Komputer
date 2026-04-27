<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        // TAMBAHKAN user_id agar transaksi antar user tidak tertukar
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

        $table->string('transaction_id')->unique();
        $table->string('customer_name');
        $table->string('customer_phone');

        // TAMBAHKAN KOLOM INI (Penyebab error kamu)
        $table->text('customer_address');

        $table->decimal('subtotal', 15, 2);
        $table->decimal('tax', 15, 2);
        $table->decimal('total', 15, 2);
        $table->string('payment_method');
        $table->decimal('cash_amount', 15, 2)->nullable();
        $table->decimal('change', 15, 2)->default(0);
        $table->timestamp('transaction_date');
        $table->timestamps();
    });
}
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
