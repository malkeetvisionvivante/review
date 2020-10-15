<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\User;
use App\Reviews;
use Carbon\Carbon;
class visibleUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visible:user'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Make user unvisible to visible';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        echo "Date Time: ".Carbon::now()."\n";
        $users = User::where(['status'=> 1,'deleted' =>'no'])->get();
        foreach ($users as $key => $user) {

            //According to department
            if($user->department_id && $user->company_id){
                $count = Reviews::where(['company_id' => $user->company_id, 'department_id' => $user->department_id ])->count();
                if($count >= 5){
                    $userObject = User::find($user->id);
                    $userObject->status = 0;
                    $userObject->save();
                    echo "Updated due to department\n";
                    echo "user id= ".$user->id."\n";
                    echo "Department id= ".$user->department_id."\n";
                    echo "Reviews count= ".$count."\n\n\n\n";
                    continue;
                }
            }

            //According to department reviewee review count
            if($user->department_id && $user->company_id){
                $reviews = Reviews::where(['customer_id' => $user->id])->get();
                if($reviews){
                    foreach ($reviews as $key => $review) {
                        $count = Reviews::where(['user_id' => $review->user_id ])->count();
                        if($count >= 3){
                            $userObject = User::find($user->id);
                            $userObject->status = 0;
                            $userObject->save();
                            echo "Updated due to reviewee review\n";
                            echo "user id= ".$user->id."\n";
                            echo "reviewee id= ".$review->user_id."\n";
                            echo "Reviews count= ".$count."\n\n\n\n";
                            break;
                        }
                    }                   
                }
            }
            
        }
        echo "Run Successfully\n\n\n\n";
    }
}
