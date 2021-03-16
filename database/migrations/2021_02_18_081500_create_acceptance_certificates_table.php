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
            $table->string('basis');
            
            $table->bigInteger('invoice_id')->unsigned()->default(0);
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->bigInteger('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->bigInteger('customer_id')->unsigned()->default(0);
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->float('subtotal', 8,2);
            $table->float('tax', 8,2);
            $table->float('total', 8,2);

            
            
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
