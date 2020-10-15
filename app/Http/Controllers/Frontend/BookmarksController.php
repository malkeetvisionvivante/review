<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\UserAgent;
use App\Bookmarks;
use App\Setting;
use Mail;
class BookmarksController extends Controller {
    public function __construct() {
        $this->middleware(['is_admin'], ['except' => ['admin_login','user_login']]);
    }

    public function perform(Request $request, $mamnager_id){
        if(Auth::check()){
            $record = Bookmarks::where([['user_id', Auth::user()->id],['manager_id',$mamnager_id]])->first();
            if ($record === null) {
                $Bookmarks = new Bookmarks;
                $Bookmarks->user_id = Auth::user()->id;
                $Bookmarks->manager_id = $mamnager_id;
                $Bookmarks->save();
                return response()->json(['success' => 'Bookmark Successfully.']);
            } else{
                $record->delete();
                return response()->json(['success' => 'Bookmark removed Successfully.']);
            }
        } else {
            return response()->json(['error' => 'Login First!']);
        }
    }
}
