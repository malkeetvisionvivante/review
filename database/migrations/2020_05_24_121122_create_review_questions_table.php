<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');

            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('review_category')->onDelete('cascade'); 

            $table->enum('question_for',['Manager', 'Peer'])->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('review_questions');
    }
}
