<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->string('full_name');
            $table->string('name');
            $table->string('director_name');
            $table->string('director_post');
            $table->string('inn');
            $table->string('kpp');
            $table->string('ogrn')->nullable();
            $table->string('okpo')->nullable();
            $table->string('oktmo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('taxion_system')->nullable();
            $table->string('legal_addres');
            $table->string('actual_addres')->nullable();
            $table->string('mailing_addres')->nullable();
            $table->string('bank')->nullable();
            $table->string('bic')->nullable();
            $table->string('ks')->nullable();
            $table->string('rs')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
