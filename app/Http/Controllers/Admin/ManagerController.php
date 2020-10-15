<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Countries;
use App\States;
use App\User;
use App\Company;
use App\Managers;
use App\Departments;
use App\Reviews;
use Illuminate\Support\Facades\Hash;
use File;
use App\UserAgent;

class ManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function checkEmail(Request $request) {
      $user = User::where('email',$request->email)->first();
      if($user){
        return true;
      }
      return false;
    }
    public function add_manager(Request $request) {

        $postData = $request->all();
             $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users',
                'phone' => 'required',
                'company_id' => 'required',
                'department_id' => 'required',
                'job_title' => 'required',
                'password' => 'required',
                'cpassword' => 'required|same:password',
                'profile' => 'required|file|mimes:jpg,png,gif,jpeg,svg,tiff',
            ]);
              if($request->hasFile('profile'))
              {
                $file = $request->file('profile');
                $file_name = 'user_'.uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
                 $destinationPath = public_path()."/images/users";
                $file->move($destinationPath,$file_name);
                $target_file = $file_name;
              }  
            $data = new User;
            $data->name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->email = $request->email;
            $data->company_id = $request->company_id;
            $data->department_id = $request->department_id;
            $data->job_title = $request->job_title;
            $data->password = Hash::make($request->password);
            $data->phone = $request->phone;
            $data->role = 3;
            $data->type = 'UserCreatedByAdmin';
            $ip_address = UserAgent::IPADDRESS();
            $data->ip_address = $ip_address;
            $data->location = UserAgent::LOCATION($ip_address);
            $data->device_type = UserAgent::DEVICETYPE();
            $data->created_by = Auth::guard('admin')->user()->id;
            if(isset($target_file) && !empty($target_file))
            {
               $data->profile = $target_file;
            }
            $data->save();
              toastr()->success('Manager Added Successfully!'); 
           return back()->with(['flash_mesaage_success' => 'Manager Added Successfully','department_tab'=>'yes']);
     }

     public function update_manager(Request $request,$id) {
        if($request->isMethod('post'))
        {
            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'status' => 'required',
                'department_id' => 'required',
                'job_title' => 'required',
            ]);
              if($request->hasFile('profile'))
              {
                $file = $request->file('profile');
                $file_name = 'user_'.uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
                 $destinationPath = public_path()."/images/users";
                $file->move($destinationPath,$file_name);
                $target_file = $file_name;
              }  
              $data =  User::find($id);
              $data->name = $request->first_name;
              $data->last_name = $request->last_name;
              $data->email = $request->email;
              $data->department_id = $request->department_id;
              $data->job_title = $request->job_title;
              $data->phone = $request->phone;
              $data->status = $request->status;
              if($request->hasFile('profile')){
                $data->profile = $target_file;
              }
              $data->save();
              toastr()->success('Manager Updated Successfully!'); 
              return back()->with(['flash_mesaage_success'=>'Update Successfully','department_tab'=>'yes']);
        }
     }
     public function delete_manager(Request $request,$id) {
        if($id)
        {
            $User = User::find($id);
            $User->deleted = 'yes';
            $User->status = 1;
            $User->save();
           toastr()->success('Manager delete Successfully!'); 
           return back()->with(['flash_mesaage_success'=>'delete Successfully','department_tab'=>'yes']);
        }
     }

     public function recover_manager(Request $request,$id) {
        if($id)
        {
            $User = User::find($id);
            $User->deleted = 'no';
           //$User->status = 1;
            $User->save();
           toastr()->success('Manager recover Successfully!'); 
           return back()->with(['flash_mesaage_success'=>'recover Successfully','department_tab'=>'yes']);
        }
     }

     public function manager_data(Request $request,$id) {
      $data = User::where('id',$id)->first();
       $departments_list = Departments::all();
       return view('admin.manager.manager_model',compact('data','departments_list'));
    }
    public function manager_list_by_dep(Request $request,$id)
    {
        $data = User::where('department_id',$id)->where('status',0)->get();
        $html = '<option value="">Select Manager</option>';
        foreach ($data as $key => $value) {
           $html .= '<option value='.$value->id.'>'.$value->name.' '.$value->last_name.'</option>';
        }
          echo $html; die;
    }
    public function manager_list_by_company_dep(Request $request,$id,$company_id)
    {
        $data = User::where(['department_id'=>$id,'company_id'=>$company_id])->where('status',0)->get();
        $html = '<option value="">Select Manager</option>';
        foreach ($data as $key => $value) {
           $html .= '<option value='.$value->id.'>'.$value->name.' '.$value->last_name.'</option>';
        }
          echo $html; die;
    }
    public function review_data(Request $request,$id)
    {
        $manager = User::find($id);
        $data = Reviews::where('user_id',$id)->paginate(10);
        $view = view("admin.company.manager_review",compact('data','manager'))->render();
        return $view;
    }
}
