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
use Carbon\Carbon;

class UserController extends Controller {
    public function __construct() {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login']]);
    }

    public function users_list(Request $request){
      $sidebar = 'users';
      $type = 'name';
      $name = '';
      if($request->type == 'name' && isset($request->name) && !empty($request->name)){
        $name = $request->name;
        $bindArr = explode(" ", $name);

        if(count($bindArr)==1) {
          $data = User::where('name',"like", $bindArr[0].'%')->orWhere('last_name',"like", $bindArr[0].'%')->whereIn('type',['Registerd','Invited','UserCreatedByAdmin']);
        } else if(count($bindArr)>1) {
          $data = User::where('name',"like", $bindArr[0].'%')->Where('last_name',"like", $bindArr[1].'%')->whereIn('type',['Registerd','Invited','UserCreatedByAdmin']);
        }
        
      } else if($request->type == 'company' && isset($request->name) && !empty($request->name)){
        $name = $request->name;
        $type = 'company';
        $bindArr = explode(" ", $name);
        $regex = ".*(".implode("|", $bindArr).").*"; 
        $campanies = Company::where('company_name',"regexp", $regex)->get();
        $comanyIds = [];
        if($campanies->count() > 0){;
          foreach ($campanies as $key => $value) {
             $comanyIds[] = $value->id;
          }
        }
         $data = User::where('role',3)->whereIn('company_id',$comanyIds)->whereIn('type',['Registerd','Invited','Referral','UserCreatedByAdmin',null]);
      } else {
           $data = User::where('role',3)->whereIn('type',['Registerd','Invited','Referral','UserCreatedByAdmin',null]);
      }
      $countData = $data->count();
      $data = $data->orderBy('id','DESC')->paginate(10);
      return view('admin.users.users_list',compact('data','sidebar','name','countData','type'));
    }
    
    public function add_users(Request $request) {
       $sidebar = 'users';
        if($request->isMethod('post'))
        {
           $postData = $request->all();
             $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users',
                //'phone' => 'required',
                'company_id' => 'required',
                'department_id' => 'required',
                'job_title' => 'required',
                'password' => 'required',
                'cpassword' => 'required|same:password',
                'profile' => 'file|mimes:jpg,png,gif,jpeg,svg,tiff',
            ]);
             $target_file = null;
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
            $data->linkedin_url = $request->linkedin_url;
            $data->department_id = $request->department_id;
            $data->job_title = $request->job_title;
            $data->password = Hash::make($request->password);
            $data->phone = $request->phone;
            $data->type = 'UserCreatedByAdmin';
            $ip_address = UserAgent::IPADDRESS();
            $data->ip_address = $ip_address;
            $data->location = UserAgent::LOCATION($ip_address);
            $data->device_type = UserAgent::DEVICETYPE();
            $data->created_by = Auth::guard('admin')->user()->id;
            $data->role = 3;
            if(isset($target_file) && !empty($target_file))
            {
               $data->profile = $target_file;
            }
            $data->save();
            toastr()->success('User Created successfully!'); 
            return redirect('admin/users/list');


       } else {
          $companys = Company::all();
          $departments = Departments::all();
           return view('admin.users.users_add',compact('sidebar','companys','departments'));
       }
    }

    public function banned_user(Request $request,$id) {
      $user = User::find($id);
      $user->banned = $request->banned;
      $banned_from = new Carbon($request->banned_from);
      $user->banned_from =$banned_from->startOfDay();
      $banned_to = new Carbon($request->banned_to);
      $user->banned_to = $banned_to->endOfDay();
      $user->save();
      if($request->banned == 'yes'){
        toastr()->success('User Banned successfully!'); 
      } else {
        toastr()->success('User Unban successfully!'); 
      }
      return back();
    }
    public function edit_user(Request $request,$id) {
        $sidebar = 'users';
        if($request->isMethod('post'))
        { 
                $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                //'email' => 'required|unique:users,email,'.$id,
                //'phone' => 'required',
                'company_id' => 'required',
                'department_id' => 'required',
                'job_title' => 'required',
                'profile' => 'file|mimes:jpg,jpeg,png,svg,tiff,gif',
                'cpassword' => 'same:password',
               
            ]);

            $data = User::find($id);
            $data->name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->company_id = $request->company_id;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->linkedin_url = $request->linkedin_url;
            $data->department_id = $request->department_id;

            $data->job_title = $request->job_title;
            if($request->hasFile('profile'))
            {
              if(!empty($data->profile))
              {
                  if(file_exists(public_path().'/images/users/'.$data->profile))
                  {
                     unlink(public_path().'/images/users/'.$data->profile);
                  }
              }    
                
                    $files = $request->file('profile');
                    $file_name = uniqid().'.'.$files->getClientOriginalExtension();
                    $destinationPath = public_path()."/images/users";
                    $files->move($destinationPath,$file_name);
                    $target_file = $file_name;
                    $data->profile = $target_file;
            }
            if(isset($request->old_password) && !empty($request->old_password) && !empty($request->password))
            {
               if(empty($request->password))
               {
                  toastr()->error('Please enter new password'); 
                  return back()->with('flash_mesaage_error','Please enter new password');
               }
               if(empty($request->cpassword))
               {
                  toastr()->error('Please enter confirm password');
                 return back()->with('flash_mesaage_error','Please enter confirm password');
               }
               if($request->password != $request->cpassword)
               {
                  toastr()->error('Password and Confirm password Not match'); 
                  return back()->with('flash_mesaage_error','Password and Confirm password Not match');
               }
               if (Hash::check($request->old_password, $data->password))
               {
                  $data->password = Hash::make($request->password);
               }
               else
               {
                  toastr()->error('Old Password Not Match'); 
                  return back()->with('flash_mesaage_error','Old Password Not Match');    
               }
            }
            $data->save();
            toastr()->success('User Update successfully!'); 
            return back();
        }
        else
        {
          $companys = Company::all();
          $data = User::where('id',$id)->where('role',3)->first();
           $departments = Departments::all();
          if(!empty($data))
          {
            return view('admin.users.users_edit',compact('sidebar','data','companys','departments'));

          }
          return back();
        }
    }

    public function delete_user(Request $request,$id) {
        if($id)
          {
             $User = User::find($id);
             $User->deleted = 'yes';
             $User->status = 1;
             $User->save();
             toastr()->success('User Deleted successfully!'); 
             return back();
          }
    }

    public function recover_user(Request $request,$id) {
        if($id)
          {
             $User = User::find($id);
             $User->deleted = 'no';
             //$User->status = 1;
             $User->save();
             toastr()->success('User Recover successfully!'); 
             return back();
          }
    }

    public function delete_profile(Request $request,$id) {
        if($id)
          {
             $User = User::find($id);
             $User->deleted = 'yes';
             $User->status = 1;
             $User->save();
             toastr()->success('Profile Deleted successfully!'); 
             return back();
          }
    }

    public function recover_profile(Request $request,$id) {
        if($id)
          {
             $User = User::find($id);
             $User->deleted = 'no';
             //$User->status = 1;
             $User->save();
             toastr()->success('Profile Recover successfully!'); 
             return back();
          }
    }

    public function users_detail(Request $request,$id, $as = null) {
      $type = 'customer_id';
      if($as != null){
        $type = $as;
      }
        if($id){
          $sidebar = 'users';
          $data1 = User::where('id',$id)->first();
          $data = Reviews::where([[$type,$id],['working_as','Manager'],['customer_id','!=',null],['fake','no']])->paginate(10);
          $peer = Reviews::where([[$type,$id],['working_as','Peer'],['customer_id','!=',null],['fake','no']])->paginate(10);
           return view('admin.users.users_detail',compact('type','data','data1','sidebar','peer'));
        }
   }
    public function import_data(Request $request)
    {
        $sidebar = 'users';
        if($request->isMethod('post'))
        {
            $file = request()->file('file');
            $customerArr = $this->csvToArray($file);

            for ($i = 0; $i < count($customerArr); $i ++)
            { 
               if($i<14){
                  continue;
               }
               print_r($customerArr[$i]);
               die; 
            }
            return back()->with('flash_message_success','Properties successfully imported');
        }
        return view('admin.users.import',compact('sidebar'));
        
    }
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
               //  if (!$header)
               //      $header = $row;
               //  else
                  //   $data[] = array_combine($header, $row);
                    $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }

    public function removeSingleReview(Request $req){
      $data = Reviews::where('id', $req->id);
      if($req->role == 'comment')
      $res = $data->update(['comment' => null]) ? ['success' => 'Comment removed successfully.'] : ['error' => 'Something went wrong.'];
      else
      $res =  $data->delete() ? ['success' => 'Review deleted successfully.'] : ['error' => 'Something went wrong.'];
      return response()->json($res);
   }

   public function hideReviewComment(Request $req){
      $data = Reviews::where('id', $req->id)->first();
      $data->hidden_comment = $data->hidden_comment == 0 ? 1 : 0;
      $res = $data->save() ? ['success' => $data->hidden_comment == 0 ? 'Comment shown successfully.' : 'Comment hidden successfully.', 'status' => $data->hidden_comment] : ['error' => 'Something went wrong.'];
      return response()->json($res);
   }
   public function hideReview(Request $req){
      $data = Reviews::where('id', $req->id)->first();
      $data->hidden_review = $data->hidden_review == 0 ? 1 : 0;
      $res = $data->save() ? ['success' => $data->hidden_review == 0 ? 'Review shown successfully.' : 'Review hidden successfully.', 'status' => $data->hidden_review] : ['error' => 'Something went wrong.'];
      return response()->json($res);
   }
}
