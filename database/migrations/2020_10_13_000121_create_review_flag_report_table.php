<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewFlagReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_flag_report', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('review_id')->unsigned()->nullable();
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade'); 

            $table->bigInteger('manager_id')->unsigned()->nullable();
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade'); 

            $table->bigInteger('flagger_id')->unsigned()->nullable();
            $table->foreign('flagger_id')->references('id')->on('users')->onDelete('cascade'); 
            
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
        Schema::dropIfExists('review_flag_report');
    }
}
