<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 50)->nullable();
            $table->integer('role')->default(3);

            $table->enum('type',['Registerd','Imported','CreatedByUser','UserCreatedByAdmin', 'ProfileCreatedByAdmin','Invited','Referral'])->nullable();

            $table->bigInteger('created_by')->unsigned()->nullable();

            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade'); 

            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade'); 

            $table->string('job_title')->nullable();
            $table->string('profile')->nullable();
            $table->longText('description')->nullable();

            $table->integer('status')->default(0);
            
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable();

            $table->bigInteger('login_count')->default(0);

            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('linkedin_id')->nullable();

            $table->longText('linkedin_url')->nullable();

            $table->longText('mail_champ_id')->nullable();

            $table->bigInteger('referal_uid')->nullable();
            $table->bigInteger('invitation_id')->nullable();
            $table->string('ip_address')->nullable();

            $table->json('location')->nullable();
            $table->string('device_type')->nullable();
            
            $table->enum('mission_popup',['yes', 'no'])->default('no');

            $table->integer('mission_popup_step')->default(1);
            $table->string('account_origin')->nullable();

            $table->enum('banned',['yes', 'no'])->default('no');
            $table->timestamp('banned_from')->nullable();
            $table->timestamp('banned_to')->nullable();
            $table->enum('claimed',['yes', 'no'])->default('no');
            $table->enum('deleted',['yes', 'no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
