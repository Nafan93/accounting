<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('invoice_id')->unsigned()->default(0);
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->bigInteger('product_id')->unsigned()->default(0);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->integer('product_no');
            $table->float('product_price', 8,2);
            $table->float('product_qty', 8,2);
            $table->float('product_tax', 8,2);
            $table->float('product_total', 8,2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_products');
    }
}
