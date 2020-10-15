<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cookie;
use App\Invitations;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('frontend.layouts.header', function ($view) {

            $headerData = null;
            if(Cookie::get('invitation_id')){
                $invi = Invitations::find(Cookie::get('invitation_id'));
                if($invi){
                    // print_r(User::find($invi->send_by));die("099working"); 
                   // if($invi->send_by){
                      $invityData = User::find($invi->send_by);
                      $headerData = [$invi, $invityData];
                  //  }
                  }
            }
            $view->headerData = $headerData;

            //Upade user movemant time
            if( Auth::check() ) {
                $userData = User::find(Auth::user()->id);
                $userData->last_login_at = Carbon::now();
                $userData->save();
                if(Auth::user()->banned == 'yes'){
                    $banned_from = Auth::user()->banned_from;
                    $banned_to = Auth::user()->banned_to;
                    if(Carbon::now()->between($banned_from, $banned_to)){
                        Auth::logout();
                    }
                }
                if(Auth::user()->deleted == 'yes'){
                   Auth::logout();
                }
            }
        });
    }
}
