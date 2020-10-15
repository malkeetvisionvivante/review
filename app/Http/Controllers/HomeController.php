<?php

namespace App\Http\Controllers;

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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login','get_state']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('home');
    }

    // public function change_status_comp(Request $request,$id) {
    //    if($id)
    //    {
    //       $data = User::where('id',$id)->first();
    //       if($data->status == 1)
    //       {
    //          $data = User::find($id);
    //          $data->status = 0;
    //          $data->save();
    //       }
    //       else
    //       {
    //          $data = User::find($id);
    //          $data->status = 1;
    //          $data->save();
    //       }
    //       return response()->json(['data'=>$data->status,'status'=>true]);

    //    }

    // }

    public function change_status_dept(Request $request,$id) {
        if($id) {  
          $data = Departments::where('id',$id)->first();
          if($data->status == 1)
          {
             $data = Departments::find($id);
             $data->status = 0;
             $data->save();
          }
          else
          {
             $data = Departments::find($id);
             $data->status = 1;
             $data->save();
          }

              return response()->json(['data'=> $data,'status'=>true]);
       }       
    }

    public function get_state(Request $request,$id) {
        $data = States::where('country_id',$id)->get();
        $html = '<option value="">Select state</option>';                                                   
        foreach($data as $datas) {
            $html.= '<option value='.$datas->id.'>'.$datas->name.'</option>';
        }
        echo $html; die;
    }

    public function view_login(Request $request) {
        return view('admin.admin_login');
    }

    
   
}
