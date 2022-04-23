<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->integer('total_harga');
            $table->timestamps();

            $table->foreign('s_order_id')->references('id')->on('sales_orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_lines');
    }
}
