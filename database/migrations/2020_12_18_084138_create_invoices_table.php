<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            //$table->integer('number_id')->references('id')->on('numbers');
            $table->string('date');

            $table->bigInteger('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            
            $table->bigInteger('customer_id')->unsigned()->default(0);
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->float('invoice_subtotal', 8,2);
            $table->float('invoice_tax', 8,2);
            $table->float('invoice_total', 8,2);
            $table->boolean('paid_status')->default(0);
            $table->string('paid_date')->nullable();

            $table->integer('packing_list_id')->references('id')->on('packing_lists')->nullable();
            $table->integer('vat_invoce_id')->references('id')->on('vat_invoces')->nullable();
            $table->integer('utd_id')->references('id')->on('utds')->nullable();

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
        Schema::dropIfExists('invoices');
    }
}
