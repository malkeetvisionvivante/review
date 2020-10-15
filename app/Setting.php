<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $table = 'setting';
    
    static function value($key){
    	$data = DB::table('setting')->where('u_code',$key)->first();
    	return $data->info;
    }
   
}
