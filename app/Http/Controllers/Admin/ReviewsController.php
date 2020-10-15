<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Reviews;

class ReviewsController extends Controller
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

    public function index() {
      $reviews = Reviews::get();
      $countData = $reviews->count();
      $reviews = Reviews::orderBy('id','DESC')->paginate(10);
      return view('admin.reviews.index', compact('reviews', 'countData'));
     }
}
