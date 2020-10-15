<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Countries;
use App\States;
use App\User;
use App\Admin;
use App\Company;
use App\Setting;
use App\Managers;
use App\Departments;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller {
    public function __construct() {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login']]);
    }

    public function view(Request $request) {
        $data = Setting::all();
        return view('admin.profile.index',compact('data'));
    }

    public function update(Request $request) {
        if($request->isMethod('post'))
      {
          $postData = $request->all();
          $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:admins,email,'.Auth::guard('admin')->user()->id,
            ]);
          $user = Admin::find(Auth::guard('admin')->user()->id);
        if(!empty($request->password))
        {
             $validate_password = $request->validate([
                'old_password' => 'required',
                'password' => 'required|min:8',
                'cpassword' => 'required|same:password',
            ]);
            if(Hash::check($request->old_password, $user->password))
            {
              $user->password = Hash::make($request->password);
            }
            else
            {
             toastr()->error('Old password doest Match!!');
             return back();
            }
        }
       $user->name = $request->first_name;
       $user->last_name = $request->last_name;
       $user->phone = $request->phone;
       $user->email = $request->email;

           if($request->hasFile('profile'))
           {
              $validate_profile = $request->validate([
                'profile' => 'required|mimes:jpg,jpeg,png,svg,giff,tiff',
              ]);
               if(!empty($user->profile))
              {
                try
                {
                  if(file_exists(public_path().'/images/users/'.$user->profile))
                  {
                     unlink(public_path().'/images/users/'.$user->profile);
                  }
                }
                catch(\Exceptions $e)
                {
                   //error
                }  
              }    
                
                    $files = $request->file('profile');
                    $file_name = uniqid().'.'.$files->getClientOriginalExtension();
                    $destinationPath = public_path()."/images/users";
                    $files->move($destinationPath,$file_name);
                    $target_file = $file_name;
                    $user->profile = $target_file;
           }
        $user->save();
        toastr()->success('Profile Updated Successfully');
        return back();
      }
    }
      
}
