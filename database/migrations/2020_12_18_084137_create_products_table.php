<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            
            $table->bigInteger('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->integer('tax');
            $table->string('unit');
            $table->integer('price');

            $table->bigInteger('product_category_id')->unsigned()->default(1);
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');

            $table->integer('sku')->nullable();
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
        Schema::dropIfExists('products');
    }
}
