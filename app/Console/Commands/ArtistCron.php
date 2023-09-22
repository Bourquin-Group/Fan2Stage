<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Eventbooking;
use App\Models\User;
use App\Models\basic_setting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Mail;
use DB;

class ArtistCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artist:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        
       
        // $starttime = date("H:i:s", strtotime("+30 minutes", $current_time));
        $buffertime = basic_setting::where('funcode','AER')->first();

        $starttime = date("H:i:s", strtotime("+".$buffertime->funval1." minutes"));
        // \Log::info($starttime);
        // \Log::info($artistid);
        // $starttime = "05:56:00";
        // $artistid = Event::where('event_time',$starttime)->where('event_status',1)->pluck('user_id')->toArray();
        // $useremail = User::whereIn('id',$artistid)->pluck('email')->toArray();
        
        $event = DB::table('events')
         ->select('events.id','events.event_title','events.event_date','events.event_time','users.name','users.email')
         ->leftJoin('users', 'users.id', '=', 'events.user_id')
         ->where('events.event_time',$starttime)
         ->get()->toArray();
$values =$event;
foreach($values as $value){
    $data = array(
        'name' => $value->name,
        'eventname' => $value->event_title,
        'eventdate' => date('d F Y', strtotime($value->event_date)),
        'eventtime' => date("H:i A", strtotime($value->event_time)),
    );
    // $email = Auth::user()->email;
    $useremail = $value->email;
    Mail::send('mail.eventartistremainder',$data,function($message) use($useremail){
                // $message->to($email);
                $message->cc($useremail);
                $message->subject('Event Artist Remainder');
                });

}
        
    }
}
