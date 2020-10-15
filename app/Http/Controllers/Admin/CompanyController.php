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
use App\company_types;
use Illuminate\Support\Facades\Hash;
use File;

class CompanyController extends Controller
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

    public function company_list(Request $request) {
       $sidebar = 'company_list';
       $name = '';
       $data = Company::orderBy('company.id','DESC')->paginate(10);
       //->where('users.role',2);
       if(isset($request->company_name) && !empty($request->company_name))
       {
          $name = $request->company_name;
          $data = Company::where('company.company_name','like','%'.$request->company_name.'%')->orderBy('company.id','DESC')->paginate(10);
       }
       $countData = $data->count();
      return view('admin.company.companies_list',compact('data','sidebar','name','countData'));
    }

    public function add_company(Request $request){
        $sidebar = 'company_list';
        if($request->isMethod('post')) {
           $postData = $request->all();
             $validatedData = $request->validate([
                'name' => 'required',
                'company_type' => 'required',
                'no_of_employee' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                //'zipcode' => 'required',
                //'address' => 'required',
                'logo' => 'file|mimes:jpg,png,gif,jpeg,svg,tiff',
            ]);
              $target_file = null;
              if($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = 'Comp_'.uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
                 $destinationPath = public_path()."/images/company";
                $file->move($destinationPath,$file_name);
                $target_file = $file_name;
              }             
              $company_info = new company;
              $company_info->logo = $target_file;
              $company_info->company_name = $request->name;
              $company_info->country_code = $request->country;
              //$company_info->company_id = $data->id;
              $company_info->state_code = $request->state;
              $company_info->city = $request->city;
              $company_info->address = $request->address;
              $company_info->zipcode = $request->zipcode;
              $company_info->company_type = $request->company_type;
              $company_info->no_of_employee = $request->no_of_employee;
              $company_info->save();
              toastr()->success('Company Created successfully!'); 
              return redirect('admin/edit/company/'.$company_info->id)->with('department_tab','hello');
        } else  {
           $countries = Countries::get();
           $company_types = company_types::orderBy('name','ASC')->get();
           return view('admin.company.add_company',compact('countries','sidebar','company_types'));
        }
    }
    public function edit_company(Request $request,$id) {
        $sidebar = 'company_list';
         $data = company::find($id);
         $company_types = company_types::orderBy('name','ASC')->get();
         $states = States::where('country_id',$data->country_code)->get();
         $countries = Countries::get();
         $departments_list = Departments::orderBy('id','DESC')->get();
         $managers = User::where('company_id',$id)->orderBy('id','DESC')->get();
         // $all_departments_list = Departments::orderBy('id','DESC')->get();
         return view('admin.company.edit_company',compact('data','states','countries','sidebar','departments_list','all_departments_list','company_types','managers'));
    }
   
    public function update_company(Request $request ,$id) {
        if($request->isMethod('post'))
        {
            $validatedData = $request->validate([
                'name' => 'required',
                //'email' => 'required|unique:users,email,'.$id,
                'company_type' => 'required',
                'no_of_employee' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                //'zipcode' => 'required',
               
            ]);

            //$data = User::find($id);
           // $data->name = $request->name;
            //$data->email = $request->email;
            if($request->hasFile('logo')) {
              try{  
                if(!empty($data->profile)) {
                    if(file_exists(public_path().'/images/company/'.$data->profile)) {
                       unlink(public_path().'/images/company/'.$data->profile);
                    }
                }    
                $files = $request->file('logo');
                $file_name = uniqid().'.'.$files->getClientOriginalExtension();
                $destinationPath = public_path()."/images/company";
                $files->move($destinationPath,$file_name);
                $target_file = $file_name;
                $company = Company::where('id',$id)->update([ 'logo' =>$target_file ]);
              } catch(\Exceptions $e) {
                 toastr()->error('files error');
                 return back();
              }        
            }
            $company = Company::where('id',$id)->update([
              'country_code' =>$request->country,
              'company_name' =>$request->name,
              'state_code' => $request->state,
              'city' => $request->city,
              'address' => $request->address,
              'zipcode' => $request->zipcode,
              'company_type' => $request->company_type,
              'no_of_employee' => $request->no_of_employee
            ]);
            toastr()->success('Company Updated Successfully!'); 
            return back()->with('flash_mesaage_success','Company Updated Successfully'); 
        }
    } 

    public function delete_company(Request $request,$id) {
       if($id)
       {
          $del_comp = Company::where('id',$id)->delete();
          toastr()->success('Successfully Deleted!'); 
          return redirect('admin/company/list')->with('flash_mesaage_success','Successfully Deleted');
       }
    }

    public function company_detail(Request $request,$id) {
        $sidebar = 'company_list';
        $data = Company::find($id);
       
       $department_list = Departments::where('status', 0)->orderBy('id','DESC')->get();
       $review_data = Reviews::where('user_id',$id)->paginate(10);
         return view('admin.company.company_detail',compact('data','sidebar','department_list','review_data'));
    }

    public function change_status_comp(Request $request,$id) {
      $data = Company::find($id);
      if($data->status == 1) {
         $data->status = 0;
      }  else {
         $data->status = 1;
      }
      $data->save();
      return response()->json(['data'=>$data->status,'status'=>true]);

    }
    public function change_status_user_comp(Request $request,$id) {
      $data = User::find($id);
      if($data->status == 1) {
         $data->status = 0;
      }  else {
         $data->status = 1;
      }
      $data->save();
      return response()->json(['data'=>$data->status,'status'=>true]);

    }
}
