@extends('fanweb.layouts.main')
@section('header')
<style>
      
</style>
@endsection
@section('content')
<section class="main_section">

    <div class="inner_main_section event-search-result custom_container">
        <div class="navgat_otherpage">
            <h1 class="task_titlt" style="display: flex"><a href="{{route('fanhome')}}"><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></a>Results For <span> “Live Events”</span> 
            </h1>    
        </div>
        <div class="event_tabe_section">
            @if(count($liveevent_data) > 0)
                    @foreach($liveevent_data as $ldata)
                    <a href="{{route('live-event',base64_encode($ldata['event_id']))}}">
                        <div class="bg_layout event_card">
                            <img src="{{$ldata['event_image']}}" alt="card">
                            <div class="today_btn"> <button>live</button></div>
                            <div class="event_card_bottom">
                            <div class="event_card_bottom_left">
                                <h3>{{$ldata['event_title']}}</h3>
                                <?php
                                $eventdate = date('Y-m-d',strtotime($ldata['event_date']));
                                $eventtime = $ldata['event_time'] ;
                                $eventdatetime = $eventdate.' '.$eventtime;       

                                $date = new DateTime($eventdatetime, new DateTimeZone($ldata['event_timezone']));

                                $date->setTimezone(new DateTimeZone($timezone_region->region));
                                $resultdatefrom = $date->format('h:i A');

                                $minutesToAdd = $ldata['event_duration']; // Change this to your desired duration

                                // Add the minutes to the DateTime object
                                $date->modify("+{$minutesToAdd} minutes");

                                // Format the modified DateTime to the desired output
                                $resultdateto = $date->format('h:i A');
                            ?>
                            <p>{{$resultdatefrom}} - {{$resultdateto}}</p>
                            </div>
                            <div class="event_card_bottom_right">
                                <button>Join Now</button>
                            </div>
                            </div>
                        </div>
                    </a> 
                    @endforeach
                    @else
                    <p>"No Live Events Found"</p>
                    @endif
        </div>
    
    </div>
</section>
@endsection
@section('footer')

@endsection