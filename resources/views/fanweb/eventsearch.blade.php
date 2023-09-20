@extends('fanweb.layouts.main')
@section('header')
<style>
      
</style>
@endsection
@section('content')
<section class="main_section">

    <div class="inner_main_section event-search-result custom_container">
      <div class="navgat_otherpage">
        <h1 class="task_titlt">Search results for <span> “events”</span> 
        </h1>
        <div class="filter-doted" data-bs-toggle="modal" href="#exampleModalToggle1" role="button">
          <span>Filter</span>
            <div><img src="{{ asset('assets/fan/images/filter_svg.svg')}}" alt=""></div>
        </div>            
    </div>
    <div class="event_tabe_section">

            @if(count($advanceSearch) > 0 && $advanceSearch['events'])
                @foreach($advanceSearch['events'] as $ldata)
                <a href="{{route('live-event',base64_encode($ldata['id']))}}">
                    <div class="bg_layout event_card">
                        <img src="{{$ldata['image']}}" alt="card">
                        <div class="today_btn"> <button>live</button></div>
                        <div class="event_card_bottom">
                        <div class="event_card_bottom_left">
                            <h3>{{$ldata['title']}}</h3>
                            <?php
                                $date = DateTime::createFromFormat('H:i:s',$ldata['time']);
                                $date->modify('+'.$ldata['duration'].' minutes');
                            ?>
                            <p>{{date("g:i A", strtotime($ldata['time']." UTC"))}} - {{$date->format('h:i A')}}</p>
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
        {{-- <div class="bg_layout event_card">
            <img src="./assets/images/homepage-card1.png" alt="card" />
            <div class="today_btn"></div>
            <div class="event_card_bottom">
              <div class="event_card_bottom_left">
                <h3>The Right Wing Tree</h3>
                <p>11 Am - 2 Pm</p>
              </div>
              <div class="event_card_bottom_right">
                <button>Join Now</button>
              </div>
            </div>
          </div>
          <div class="bg_layout event_card">
            <img src="./assets/images/live_event_card1.png" alt="card" />
            <div class="today_btn"></div>
            <div class="event_card_bottom">
              <div class="event_card_bottom_left">
                <h3>The Right Wing Tree</h3>
                <p>11 Am - 2 Pm</p>
              </div>
              <div class="event_card_bottom_right">
                <button>Book Now</button>
              </div>
            </div>
          </div>
      </div> --}}
    
    </div>
  </section>
@endsection
@section('footer')

@endsection