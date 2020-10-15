<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\UserAgent;
use App\Emails;
use App\Setting;
use Mail;
class EmailController extends Controller {
    public function __construct() {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login']]);
    }

    public function index(Request $request){
      $emails = Emails::get();
      return view('admin.email.index', compact('emails'));
    }

    public function edit(Request $request, $id){
      if($request->isMethod('post')){
        $validatedData = $request->validate([
          'subject' => 'required',
          'from' => 'required|email',
          'reply' => 'required|email',
          'content' => 'required'
        ]);
              $email =  Emails::find($id);
              $email->subject = $request->subject;
              $email->from = $request->from;
              $email->reply = $request->reply;
              $email->content = $request->content;
              $email->save();
              toastr()->success('Template Updated Successfully!'); 
              return back()->with(['flash_mesaage_success'=>'Update Successfully']);
      }else{
        $data = Emails::where('id',$id)->first();
        return view('admin.email.edit', compact('data'));
      }
    }

    public function upload(Request $request){
      $files = $request->file('upload');
      $file_name = uniqid().'.'.$files->getClientOriginalExtension();
      $destinationPath = "images/emailimages";
      $files->move($destinationPath,$file_name);

      $CKEditorFuncNum = $request->input('CKEditorFuncNum');
      $url = asset('images/emailimages/'.$file_name); 
      $msg = 'Image uploaded successfully'; 
      $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
         
      @header('Content-type: text/html; charset=utf-8'); 
      echo $response;
    }

    public function testemail(Request $request){
      $customer_email = $request->testemail;
      $admin_mail = Setting::value('email');
      $admin_name = 'Review System';
      $subjact = $request->testsubject; 
      $id = $request->testid; 
      // print_r([ $customer_email,$admin_mail,$admin_name,$subjact,$id ]);die;
      try
      {
        Mail::send(['html' => 'email/body'],[], function ($message) {
          $message->to($customer_email)
            ->subject($subjact)
            ->setBody('<h1>Hi, welcome user!</h1>', 'text/html'); 
        });
      } 
      catch(\Exception $ex)
      {
        print_r($ex);die;
         toastr()->warning('Mail Not Send !!!');
         return back();    
      }
      // return Redirect::route('edit', array($id));
    }
}
