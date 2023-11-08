@extends('fanweb.layouts.main')
@section('header')
<style>
      
</style>
@endsection
@section('content')
<section class="main_section">

    <div class="inner_main_section event-search-result custom_container">
        <div class="navgat_otherpage">
            <h1 class="task_titlt" style="display: flex"><a href="{{route('fanhome')}}"><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></a>Results For <span> “Scheduled Events”</span> 
            </h1>   
        </div>
        <div class="event_tabe_section">
            @if(count($scheduleevent_data) > 0)
                @foreach($scheduleevent_data as $sdata)
                <a href="{{route('scheduled-event',base64_encode($sdata['event_id']))}}">
                      <div class="bg_layout event_card">
                        <img src="{{$sdata['event_image']}}" alt="card">
                        <div class="today_btn"></div>
                        <div class="event_card_bottom">
                          <div class="event_card_bottom_left">
                            <h3>{{$sdata['event_title']}}</h3>
                            <?php
                                $eventdate = date('Y-m-d',strtotime($sdata['event_date']));
                                $eventtime = $sdata['event_time'] ;
                                $eventdatetime = $eventdate.' '.$eventtime;       

                                $date = new DateTime($eventdatetime, new DateTimeZone($sdata['event_timezone']));

                                $date->setTimezone(new DateTimeZone($timezone_region->region));
                                $resultdatefrom = $date->format('h:i A');

                                $minutesToAdd = $sdata['event_duration']; // Change this to your desired duration

                                // Add the minutes to the DateTime object
                                $date->modify("+{$minutesToAdd} minutes");

                                // Format the modified DateTime to the desired output
                                $resultdateto = $date->format('h:i A');
                            ?>
                            <p>{{$resultdatefrom}} - {{$resultdateto}}</p>
                          </div>
                          <div class="event_card_bottom_right">
                            @if($sdata['booking_status'] == 'true')
                                
                                <a href="{{route('scheduled-event',base64_encode($sdata['event_id']))}}"><button>Booked</button></a>
                                
                                @else
                                
                                <a href="{{route('scheduled-event',base64_encode($sdata['event_id']))}}"><button> Book Now</button></a> 
                                
                                @endif
                          </div>
                        </div>
                      </div>
                </a> 
                @endforeach
                @else
                <p>"No Scheduled Events Found"</p>
                @endif
        </div>
    
    </div>
  </section>
@endsection
@section('footer')

@endsection