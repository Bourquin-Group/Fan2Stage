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
                                $date = DateTime::createFromFormat('H:i:s',$sdata['event_time']);
                                $date->modify('+'.$sdata['event_duration'].' minutes');
                            ?>
                            <p>{{date("g A", strtotime($sdata['event_time']." UTC"))}} - {{$date->format('h:i A')}}</p>
                          </div>
                          <div class="event_card_bottom_right">
                            <button>Book Now</button>
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