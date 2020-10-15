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
use Illuminate\Support\Facades\Hash;
use File;

class DepartmentController extends Controller
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

     public function department_list(Request $request) {
       $sidebar = 'departments_list';
       $name = '';
       $data = Departments::orderBy('id','DESC');
        if(isset($request->name) && !empty($request->name))
        {
          $name = $request->name;
          $data = $data->where('name','like','%'.$request->name.'%');
        }
        $countData = $data->count();
        $data = $data->paginate(10);
        return view('admin.department.departments_list',compact('data','sidebar','name','countData'));
    }

     public function department_detail(Request $request,$id) {
       $sidebar = 'departments_list';
       $name = '';
       $data = Departments::find($id);
       return view('admin.department.department_detail ',compact('data','sidebar','name'));
     }
     public function get_deparment(Request $request,$id) {
        $data = Departments::where('id',$id)->first();
         return view('admin.department.department_model',compact('data'));
    }

    public function add_department(Request $request) {
        if($request->isMethod('post'))
        {
            if($request->isMethod('post'))
            {
               $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'company_id' => 'required',
               
              ]);
             
             $data = new Departments;
             $data->name = $request->name;
             $data->description = $request->description;
             //$data->company_id = $request->company_id;
             $data->save();
             toastr()->success('Department Add Successfully!'); 
           return back()->with(['flash_mesaage_success' => 'Department Add Successfully','department_tab'=>'yes']); 

          }
        }
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
             $data->save();
             toastr()->success('Department Add Successfully!'); 
           return back()->with(['flash_mesaage_success' => 'Department Add Successfully','department_tab'=>'yes']); 

          }
        }
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
    
    public function delete_department(Request $request,$id) {
       if($id)
       {
           $delete = Departments::where('id',$id)->delete();
           toastr()->success('Delete Department Successfully!'); 
           return redirect('admin/department/list')->with('flash_mesaage_success','Delete Department Successfully');
       }
    }

}
