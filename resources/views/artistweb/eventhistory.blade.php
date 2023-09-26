@extends('artistweb.layouts.main')
@section('body')

<section class="main_section custom_container">
        <div class="navgat_otherpage">
            <h1 class="task_titlt"><a href="{{route('artisthome')}}"><span><img src="{{ asset('assets/images/arrow-left.svg')}}" alt="arrow"></span></a>Event History
            </h1>
        </div>
        <div class="event_tabe_section">
          @if(count($event_history) > 0)
          @foreach($event_history as $list)
            <a href="{{route('eventHistoryDetails',$list['event_id'])}}">
                <div class="bg_layout event_card">
                  <?php $v = explode(',',$list['event_image']);?>
                  <img src="{{ $v[0]}}" alt="card" />
                  <div class="today_btn"></div>
                  <div class="event_card_bottom">
                    <div class="event_card_bottom_left">
                      <h3>{{ $list['event_title']}}  </h3>
                      <?php
                                $date = DateTime::createFromFormat('H:i:s',$list['event_time']);
                                $date->modify('+'.$list['event_duration'].' minutes');
                          ?>
                          <p>{{date("g:i A", strtotime($list['event_time']." UTC"))}} - {{date("g:i A", strtotime($date->format('h:i A')." UTC"))}}</p>
                    </div>
                    <div class="event_card_bottom_right">
                      <button>View</button>
                    </div>
                  </div>
                </div>
              </a>
          @endforeach  
          @else
          <p>"No Event History For You"</p>
          @endif
        </div>

      <div class="inner_main_section custom_container">

        <div class="event_list_section">

        </div>
      </div>
    </section>

@endsection
