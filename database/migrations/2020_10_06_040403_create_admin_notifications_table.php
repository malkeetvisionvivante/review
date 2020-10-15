<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['commentReportLimit','reviewsByRevieweeLimit','newCompanyAdded','userCompanyChange','spamBehavior','lowScore','similarNamesMatch','newCompanyAddedThroughFooter'])->nullable();
            $table->enum('status',['open','escalated','resolved'])->nullable();
            
            $table->bigInteger('review_id')->unsigned()->nullable();
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade'); 

            $table->bigInteger('review_by')->unsigned()->nullable();
            $table->foreign('review_by')->references('id')->on('users')->onDelete('cascade'); 

            $table->bigInteger('review_to')->unsigned()->nullable();
            $table->foreign('review_to')->references('id')->on('users')->onDelete('cascade'); 

            $table->bigInteger('number_of_reports')->nullable();
            $table->bigInteger('number_of_reviews')->nullable();

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade'); 

            $table->text('company_name')->nullable();
            $table->json('match_users')->nullable();


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
        Schema::dropIfExists('admin_notifications');
    }
}
