<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invitation_by')->unsigned()->nullable();
            $table->foreign('invitation_by')->references('id')->on('invitation_by')->onDelete('cascade');
            $table->enum('account_origin',['Public Early Access','Public Contact Us','Public Join Us','Public Feedback','Add your company','Invite friend'])->nullable();
            
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_last_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_linkedin_profille')->nullable();
            $table->bigInteger('send_by')->unsigned()->nullable();
            $table->foreign('send_by')->references('id')->on('users')->onDelete('set null');
            $table->enum('mystery_invite',['0','1'])->nullable();
            $table->enum('visit',['0','1'])->default('0');

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
        Schema::dropIfExists('invitations');
    }
}
