<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use App\User;
use Mail;
use App\Setting;
use App\Company;
use App\UsersLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AddedProfiles extends Model {
  	protected $table = 'added_profiles';
 
  	public function profileName(){
     	$data = User::find($this->profile_id);
        if(empty($data)) {
            return '';
        }
        return $data->name.' '.$data->last_name;
  	}

  	public function profileEmail(){
   		$data = User::find($this->profile_id); 
       if(empty($data))
       {
          return '';
       }
       return $data->email;
  }
}
