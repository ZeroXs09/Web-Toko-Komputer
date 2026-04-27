<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Processor', 'Graphics Card', 'Motherboard', 'Memory', 'Case', 'Power Supply', 'Storage', 'Cooling']);
            $table->decimal('price', 12, 2);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
