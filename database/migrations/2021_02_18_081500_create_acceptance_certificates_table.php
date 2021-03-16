<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcceptanceCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceptance_certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('date');
            
            $table->integer('company_id')->references('id')->on('companies')->nullable();
            $table->integer('customer_id')->references('id')->on('customers')->nullable();

            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->float('subtotal', 8,2);
            $table->float('tax', 8,2);
            $table->float('total', 8,2);

            $table->integer('invoice_id')->references('id')->on('invoices')->nullable();
            
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
        Schema::dropIfExists('acceptance_certificates');
    }
}
