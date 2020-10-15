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
use App\review_questions;
use App\ReviewCategory;
use Illuminate\Support\Facades\Hash;
use File;

class ReviewQuestionController extends Controller
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

    public function list_view() {
      $data = review_questions::get();
      $ReviewCategorys = ReviewCategory::get();
      $countData = $data->count();
      $data = review_questions::orderBy('id','DESC')->paginate(10);
      return view('admin.review_question.list', compact('data','countData','ReviewCategorys'));
     }

     public function create(Request $request) {
        $validatedData = $request->validate([
            'question' => 'required',
            'category_id' => 'required',
        ]);

        $data = new review_questions;
        $data->question = $request->question;
        $data->category_id = $request->category_id;
        $data->question_for = $request->question_for;
        $data->save();
        toastr()->success('Question Create Successfully!'); 
        return back();
     }
     public function update(Request $request) {
        $validatedData = $request->validate([
            'question' => 'required',
            'category_id' => 'required',
        ]);

        $data = review_questions::find($request->id);
        $data->question = $request->question;
        $data->category_id = $request->category_id;
        $data->question_for = $request->question_for;
        $data->save();
        toastr()->success('Question Update Successfully!'); 
        return back();
     }
     public function delete(Request $request,$id) {
        if($id) {
           $data = review_questions::where('id',$id)->delete();
           toastr()->success('Question delete Successfully!'); 
           return back();
        }
     }

    public function change_status(Request $request) {
      $data = review_questions::find($request->id);
      $data->status = !$data->status;
      $data->save();
      toastr()->success('Status Change Successfully!'); 
      return back();
    }

    public function getData(Request $request) {
      $data = review_questions::find($request->id);
      return response()->json($data);
    }
}
