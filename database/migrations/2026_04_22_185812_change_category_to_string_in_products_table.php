<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {

            $table->string('category', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
          
            $table->enum('category', ['Processor', 'Graphics Card', 'Motherboard', 'Memory', 'Case', 'Power Supply', 'Storage', 'Cooling'])->change();
        });
    }
};
