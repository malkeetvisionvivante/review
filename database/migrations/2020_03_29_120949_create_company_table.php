<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('logo')->nullable();

            $table->bigInteger('company_type')->unsigned()->nullable();
            $table->foreign('company_type')->references('id')->on('company_types')->onDelete('set null'); 

            $table->bigInteger('country_code')->unsigned()->nullable();
            $table->foreign('country_code')->references('id')->on('countries')->onDelete('set null'); 
            
            $table->bigInteger('state_code')->unsigned()->nullable();
            $table->foreign('state_code')->references('id')->on('states')->onDelete('set null');

            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('no_of_employee')->nullable();
            $table->longText('about')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('company');
    }
}
