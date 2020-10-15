<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 

            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade'); 

            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade'); 

            $table->integer('currently_working_in_company')->nullable();
            $table->integer('currently_working_with')->nullable();
            $table->integer('recommend_working_with')->nullable();
            $table->enum('working_as',['Manager','Peer'])->nullable();
            $table->enum('origination_source',['Company Page','Manager Page','Thank You Page','Department Page'])->nullable();

            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade'); 

            $table->json('review_value');

            $table->float('avg_review',8, 1)->nullable();
            $table->integer('user_role')->default(0);
            $table->integer('status')->default(0);
            $table->integer('ind_type')->nullable();
            
            $table->text('comment')->nullable();
            $table->integer('hidden_comment')->nullable();
            $table->integer('hidden_review')->nullable();
            $table->string('initiate_time')->nullable();

            $table->integer('hold')->default(0);
            $table->enum('fake',['yes', 'no'])->default('no');
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
        Schema::dropIfExists('reviews');
    }
}
