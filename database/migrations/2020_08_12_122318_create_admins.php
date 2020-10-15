<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) { 
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->integer('role')->default(3);

            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null'); 

            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null'); 

            $table->bigInteger('created_by')->unsigned()->nullable();
            //$table->foreign('created_by')->references('id')->on('users')->onDelete('set null'); 

            $table->enum('type',['Registerd','Imported','CreatedByUser','CreatedByAdmin'])->nullable();
            
            $table->string('profile')->nullable();
            $table->string('job_title')->nullable();
            $table->integer('status')->default(0);
            $table->longText('description')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->longText('mail_champ_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
