<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Countries;
use App\States;
use App\User;
use App\Company;
use App\Setting;
use App\Managers;
use App\Departments;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller {
    public function __construct() {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login']]);
    }

    public function view(Request $request) {
        $data = Setting::all();
        return view('admin.setting.index',compact('data'));
    }

    public function update(Request $request) {
        foreach ($request->all() as $key => $value) {
          if($key != '_token'){
            $data = DB::table('setting')->where('u_code',$key)->first();
            if($data){
              $data = Setting::find($data->id);
              $data->info  = $value;
              $data->save();
            } else {
              $data = new Setting;
              $data->u_code = $key;
              $data->info  = $value;
              $data->save();
            }
          }
        }
        toastr()->success('Updated successfully!'); 
        return back();
    }
      
}
