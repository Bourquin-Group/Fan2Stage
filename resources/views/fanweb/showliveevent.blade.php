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
                                    $date = DateTime::createFromFormat('H:i:s',$ldata['event_time']);
                                    $date->modify('+'.$ldata['event_duration'].' minutes');
                                ?>
                                <p>{{date("g:i A", strtotime($ldata['event_time']." UTC"))}} - {{$date->format('h:i A')}}</p>
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