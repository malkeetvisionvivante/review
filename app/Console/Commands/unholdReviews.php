<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\User;
use App\Reviews;
use Carbon\Carbon;
class unholdReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unhold:reviews'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Make user review unhold to hold';

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
        $reviews = Reviews::where('hold',1)->get();
        echo "Total Found = ".count($reviews)."\n";
        foreach ($reviews as $key => $review) {
            $currentData = Carbon::now();
            $reviewDate = new Carbon($review->created_at);
            $defference = $currentData->diffInHours($reviewDate);
            if($defference >=24){
                $reviewObj = Reviews::find($review->id);
                $reviewObj->hold = 0;
                $reviewObj->save();
                echo "Reviews Updated\n";
                echo "Reviews id = ".$review->id."\n";
            }
        }
        echo "Run Successfully\n\n\n\n";
    }
}
