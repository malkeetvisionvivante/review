<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\States;
use App\Countries;
use App\Company;
use App\Managers;
use App\Departments;
use App\Reviews;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Company_dashboard extends Controller
{
    public function company_dashboard(Request $request)
    {
    	$sidebar = 'my_profile';
    	 $data = User::where('id',Auth::user()->id)->first();
    	 $states = States::where('country_id',$data->company['country_code'])->get();
         $countries = Countries::get();
    	 return view('company.company_dashboard',compact('sidebar','data','states','countries'));
    }
     public function update_company(Request $request) {
     	$id = Auth::user()->id;
        if($request->isMethod('post'))
        {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email,'.$id,
                'company_type' => 'required',
                'no_of_employee' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'zipcode' => 'required',
               
            ]);

            $data = User::find($id);
            $data->name = $request->name;
            $data->email = $request->email;
            if($request->hasFile('logo'))
            {
              if(!empty($data->profile))
              {
                  if(file_exists(public_path().'/images/company/'.$data->profile))
                  {
                     unlink(public_path().'/images/company/'.$data->profile);
                  }
              }    
                
                    $files = $request->file('logo');
                    $file_name = uniqid().'.'.$files->getClientOriginalExtension();
                    $destinationPath = "images/company";
                    $files->move($destinationPath,$file_name);
                    $target_file = $file_name;
                    $data->profile = $target_file;
            }
            if(isset($request->old_password) && !empty($request->old_password))
            {
               if(empty($request->password))
               {
                   toastr()->warning('Please enter new password!'); 
                  return back()->with('flash_mesaage_error','Please enter new password');
               }
               if(empty($request->cpassword))
               {
                toastr()->warning('Please enter confirm password!!'); 
                 return back()->with('flash_mesaage_error','Please enter confirm password');
               }
               if($request->password != $request->cpassword)
               {
                     toastr()->warning('Password and Confirm password Not match'); 
                  return back()->with('flash_mesaage_error','Password and Confirm password Not match');
               }
               if (Hash::check($request->old_password, $data->password))
               {
                  $data->password = Hash::make($request->password);
               }
               else
               {
                   toastr()->warning('Old Password Not Match'); 
                  return back()->with('flash_mesaage_error','Old Password Not Match');    
               }
            }
            $data->save();

            if($data)
            {
               $company = Company::where('company_id',$data->id)->update([
                'country_code' =>$request->country,
                'state_code' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'zipcode' => $request->zipcode,
                'company_type' => $request->company_type,
                'no_of_employee' => $request->no_of_employee
               ]);
            } 
            toastr()->success('Profile Updated Successfully!');
           return back()->with('flash_mesaage_success','Company Updated Successfully'); 
        }
    }
    public function manager_list(Request $request)
    {
    	 $sidebar = 'managers';
    	 $name = '';
    	  $data = Managers::where('company_id',Auth::user()->id);
           if(isset($request->name) && !empty($request->name))
           {
           	  $name = $request->name;
           	  $data = $data->where('first_name','like','%'.$request->name.'%');
           }
    	   $data  = $data->paginate(10);
         $departments_list = Departments::where('company_id',Auth::user()->id)->get();
    	  return view('company.manager_list',compact('data','sidebar','name','departments_list'));
    }
    public function manager_status_change(Request $request,$id)
    {
         if($id)
         {
            $data = Managers::find($id);
            if($data->status == 1)
            {
                $data->status = 0;
            }
            else{
              $data->status = 1;
            }
            $data->save();
           if($data->status == 1)
           {
             toastr()->success('Manager Inactiveted successfully!'); 
           }
           else{
            toastr()->success('Manager Activeted successfully!'); 
           }
          return response()->json(['data'=>$data,'states'=>true]);



         }
    }
    public function delete_manager(Request $request,$id)
    {
        if($id)
        {
            $data = Managers::where('id',$id)->first();
            if($data->company_id == Auth::user()->id)
            {
                $delete = Managers::where('id',$id)->delete();
                $review_delete = Reviews::where('user_id',$id)->delete();
                toastr()->success('Manager delete Successfully');
                return back();
            }
            else{
               toastr()->error('Something Went Wrong');
               return back();
            }
        }
    }
    public function company_add_manager(Request $request)
    {
        if($request->isMethod('post'))
        {
           $postData = $request->all();
           $validatedData = $request->validate([
                'lname' => 'required|max:255',
                'fname' => 'required|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|max:15',
               
            ]);

              if($request->hasFile('profile'))
              {
                $file = $request->file('profile');
                $file_name = 'Manager_'.uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
                 $destinationPath = "images/manager";
                $file->move($destinationPath,$file_name);
                $target_file = $file_name;
              }     
              $manager = new Managers;
              $manager->company_id = Auth::user()->id;
              $manager->first_name = $request->fname;
              $manager->last_name = $request->lname;
              $manager->department_id = $request->department;
              $manager->email = $request->email;
              if(isset($target_file) && !empty($target_file))
              {
                 $manager->profile = $target_file;
              }
              $manager->phone = $request->phone;
              $manager->save();
          
              toastr()->success('Manager Added Successfully!'); 
           return back()->with(['flash_mesaage_success' => 'Manager Added Successfully']);
        }
    }
    public function manager_data(Request $request,$id) {
      $data = Managers::where('id',$id)->first();
       //$departments_list = Departments::where('company_id',$data->company_id)->get();
       $departments_list = Departments::where('company_id',Auth::user()->id)->get();
       return view('admin.manager.manager_model',compact('data','departments_list'));
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
                'department' => 'required',
                
               
            ]);
             if($request->hasFile('profile'))
              {
                $file = $request->file('profile');
                $file_name = 'Manager_'.uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
                 $destinationPath = "images/manager";
                $file->move($destinationPath,$file_name);
                $target_file = $file_name;
              }  
             $data = Managers::find($id);
             $data->first_name = $request->first_name;
             $data->last_name = $request->last_name;
             $data->email = $request->email;
             $data->phone = $request->phone;
             $data->status = $request->status;
             if(isset($target_file) && !empty($target_file))
             {
                $data->profile = $target_file;
             }
             if(!empty($request->department))
             {
               $data->department_id =$request->department;

             }
             $data->save();
             toastr()->success('Manager Updated Successfully!'); 
             return back()->with(['flash_mesaage_success'=>'Update Successfully','department_tab'=>'yes']);
        }
     }
     public function department_list(Request $request)
     {
        $sidebar = 'departments';
        $name = '';
        $data = Departments::where('company_id',Auth::user()->id);
        if(isset($request->name) && !empty($request->name))
        {
            $name = $request->name;
            $data = $data->where('name','like','%'.$request->name.'%');
        }
        $data = $data->paginate(10);
        return view('company.department_list',compact('sidebar','name','data'));
     }
     public function add_newdepartment(Request $request) {
        if($request->isMethod('post'))
        {
            if($request->isMethod('post'))
            {
               $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
               
              ]);
             
             $data = new Departments;
             $data->name = $request->name;
             $data->description = $request->description;
             $data->company_id = Auth::user()->id;
             $data->save();
             toastr()->success('Department Add Successfully!'); 
           return back()->with(['flash_mesaage_success' => 'Department Add Successfully','department_tab'=>'yes']); 

          }
        }
     }
     public function get_data_department(Request $request,$id) {
        $data = Departments::where('id',$id)->first();
         return view('admin.department.department_model',compact('data'));
    }
    public function update_department(Request $request, $id) {
          if($request->isMethod('post'))
          {
             $validatedData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
               
            ]);
              $data = Departments::find($id);
              $data->name = $request->name;  
              $data->description = $request->description;
              $data->save();
              toastr()->success('Department Updated Successfully!'); 
              return back()->with('flash_mesaage_success','Department Updated');
          }
     }
     public function change_status_dep(Request $request,$id)
     {
         if($id)
         {
            $data = Departments::find($id);
            if($data->status == 1)
            {
                $data->status = 0;
            }
            else
            {
                $data->status = 1;
            }
            $data->save();
            if($data->status == 1)
            {

              toastr()->success('Department Inactiveted Successfully');
            }
            else{
                  toastr()->success('Department Activeted Successfully');
            }
            return response()->json(['data'=>$data,'status'=>true]);
         }
     }
     public function delete_dep(Request $request,$id)
     {
        if($id)
        {
             $data = Departments::where('id',$id)->first();
             if($data->company_id == Auth::user()->id)
             {
               $delete = Departments::where('id',$id)->delete();
               toastr()->success('Department delete successfully');
               return back();
             }
        }
     }
     public function company_reviews(Request $request)
     {
         $sidebar = 'reviews';
         $name = '';
         $manager_ids = Managers::where('company_id',Auth::user()->id)->pluck('id')->toArray();
         $data = Reviews::select('reviews.*','manager.id as manager_id','manager.first_name','manager.last_name')
          ->join('manager','manager.id','=','reviews.user_id');
          if(isset($request->name) && !empty($request->name))
          {
            $name = $request->name;
             $data = $data->where('manager.first_name','like','%'.$request->name.'%');
          }
         $data = $data->whereIn('reviews.user_id',$manager_ids)->paginate(10);
         return view('company.reviews_list',compact('data','sidebar','name')); 
     }
      public function show_review_model(Request $requestm,$id)
      {
          if($id)
          {

              $review_data = Reviews::where('id',$id)->first();
              if($review_data->user_role == 2)
              {
                  $company = User::find($review_data->user_id);
                  $review_data['name'] = $company->name;
              }
              if($review_data->user_role == 4)
              {
                 $manager = Managers::find($review_data->user_id);
                 $review_data['name'] = $manager->first_name.' '.$manager->last_name;
                 if(!empty($manager->department_id))
                 {
                    $dep = Departments::find($manager->department_id);
                    $review_data['department_name'] = $dep['name'];
                 }

              }
              return view('users.user_review_model',compact('review_data'));
          }
      }
}
