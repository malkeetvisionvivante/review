<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Company;
use App\Reviews;
use App\Departments;
use App\company_types;
use App\ReferalUser;
use App\Invitations;
use App\Bookmarks;
use Auth;

class UsersLog extends Model {

  protected $table = 'users_log';
  public function company($id){

  }
}
