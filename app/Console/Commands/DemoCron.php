<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Eventbooking;
use App\Models\User;
use App\Models\basic_setting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Mail;
class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

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
        $current_time = date("H:i:s");
        // $starttime = date("H:i:s", strtotime("+30 minutes", $current_time));
        $buffertime = basic_setting::where('funcode','FER')->first();
        $starttime = date("H:i:s", strtotime("+".$buffertime->funval1." minutes"));
        // $starttime = "05:56:00";

        // $event = Event::where('event_time',$starttime)->where('event_status',1)->pluck('id')->toArray();
        // $userid = Eventbooking::whereIn('event_id',$event)->pluck('user_id')->toArray();
        // $useremail = User::whereIn('id',$userid)->pluck('email')->toArray();
        
 $event = DB::table('events')
         ->select('events.id','events.event_title','events.event_date','events.event_time','users.name','users.email')
         ->leftJoin('eventbookings', 'eventbookings.event_id', '=', 'events.id')
         ->leftJoin('users', 'users.id', '=', 'eventbookings.user_id')
         ->where('events.event_time',$starttime)
         ->get()->toArray();
$values =$event;
// \Log::info($values);
foreach($values as $value){
    // \Log::info($value->id);
    $data = array(
                    'name' => $value->name,
                    'eventname' => $value->event_title,
                    'eventdate' => date('d F Y', strtotime($value->event_date)),
                    'eventtime' => date("H:i A", strtotime($value->event_time)),
                );
                // $email = Auth::user()->email;
                $useremail = $value->email;
                Mail::send('mail.eventremainder',$data,function($message) use($useremail){
                            // $message->to($email);
                            $message->cc($useremail);
                            $message->subject('Event Remainder');
                            });
        }

        // 
    }
}
