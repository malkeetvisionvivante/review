<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\UserAgent;
use App\Emails;
use App\Setting;
use App\AdminNotificationModel;
use App\User;
use Mail;
class NotificationController extends Controller {


    public function notification_detail(Request $request, $id){
      $notification = AdminNotificationModel::find($id);
      return view('admin.notification.notification_detail', compact('notification'));
    }
    public function change_status(Request $request){
      $AdminNotificationModel = AdminNotificationModel::find($request->id);
      $AdminNotificationModel->status = $request->status;
      $AdminNotificationModel->save();
      toastr()->success('User Created successfully!'); 
      return back();
    }

    public function reviewUserName(Request $request){
      $data = User::find($this->review_to);
         if(empty($data))
         {
            return '';
         }
         return $data->name.' '.$data->last_name;
    }
    public function reviewUserEmail(Request $request){
       $data = User::find($this->review_to); 
         if(empty($data))
         {
            return '';
         }
         return $data->email;
    }
    public function notification_list(Request $request){
      $status = ['open', 'escalated', 'resolved'];
      $statuValue = 'all';
      if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] !='all'){
        if($_GET['type'] =='all'){
          $status = ['open', 'escalated', 'resolved'];
        } else {
          $status = array($_GET['type']);
          $statuValue = $_GET['type'];
        }
      }

      $order_by = 'DESC';
      if(isset($_GET['order_by']) && !empty($_GET['order_by'])){
        $order_by = $_GET['order_by'];
      }
      $notifications = AdminNotificationModel::whereIn('status',$status)->orderBy('updated_at',$order_by)->paginate(10);
      $notificationsCount = $notifications->count();
      return view('admin.notification.notification_list', compact('notifications','notificationsCount','statuValue','order_by'));
    }

}
