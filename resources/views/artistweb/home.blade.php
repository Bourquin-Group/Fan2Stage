@extends('artistweb.layouts.main')
@section('body')  
<section class="main_section">
  <div class="home_banner">
    <img src="{{ $a_profile['landing_page_image'] }}" alt="bg" />
    @if($scheduleEvent)
    @if(isset($liveEvent[0]))
      <div class="banner_part_text">
        <input type="hidden" name="eventtime" id="event_time" value="{{strtotime(date('F d, Y H:i:s', strtotime($liveEvent[0]['event_time'])))}}">
        
        <p class="sub_header">
          Your Upcoming {{$liveEvent[0]['event_title']}} Starts <span id="demo"></span>
        </p>
        <p><button class="re_btn"><a href="{{ url('web/eventDetail/'.Crypt::encryptString($liveEvent[0]['id'])) }}">Start Event Now</a></button></p>
        <p class="border_under"><a href="{{ url('web/fanslist/'.base64_encode($liveEvent[0]['id'])) }}">View Fans List</a></p>
      </div>
      @endif
      @endif
    </div>
    <div class="inner_main_section custom_container">
      <div class="profile_card">
        <input type="text" id="timemsg" value="{{Session::get('timezonechange')}}">
        <div class="profile_img_section">
          <img
            class="profile_img"
            src="{{(isset($a_profile['profile_image'])) ? $a_profile['profile_image']: ''}}"
            alt="profile"
          />
          @if(isset($a_profile) && $a_profile)
          @if($a_profile['d_stagename'] == 'on')
              <p><h2>{{ucfirst($a_profile['stage_name'])}}</h2></p>
              <a>{{ ucfirst($a_profile['name']) }}</a>
              @else
              <a><h2>{{ ucfirst($a_profile['name']) }}</h2></a>
              <p>{{ucfirst($a_profile['stage_name'])}}</p>
              @endif
          <p class="Followers_part">@if($a_profile['followers'] != 0)<a href="{{ url('web/followers') }}">{{ $a_profile['followers']}} Followers <span>(view)</span> </a>@else <span>You are yet to have a Fan Follower</span> @endif</p>
        </div>
        <div class="profile_section_inner">
          <div class="profilr_part_section">
            <h6 class="sub_header">Bio:</h6>
            <p>
              {{ ucfirst(substr($a_profile['bio'], 0, 100)) }} 
              <a class="readmore" data-bs-toggle="modal" href="#exampleModalToggle" role="button">read more</a>
            </p>
          </div>
          <div class="profilr_part_section">
            <h6 class="sub_header">Genre:</h6>
            <p>{{ ucfirst($a_profile['genre']) }}</p>
          </div>
          <div class="profilr_part_section">
            <h6 class="sub_header">Social Linksss :</h6>

            <div class="social_icon">
              @if($a_profile['facebook_link'])
              <a href="{{ $a_profile['facebook_link'] }}" target="_blank"><span class="face_book"></span></a>
              @else
              <a><span class="face_book"></span></a>
              @endif
              @if($a_profile['instagram_link'])
              <a href="{{ $a_profile['instagram_link']}}" target="_blank"><span class="instagram"></span></a>
              @else
              <a><span class="instagram"></span></a>
              @endif
              @if($a_profile['itunes_link'])
              <a href="{{ $a_profile['itunes_link']}}" target="_blank"><span class="itnes"></span></a>
              @else
              <a><span class="itnes"></span></a>
              @endif
              @if($a_profile['youtube_link'])
              <a href="{{ $a_profile['youtube_link']}}" target="_blank"><span class="youtube"></span></a>
              @else
              <a><span class="youtube"></span></a>
              @endif
              @if($a_profile['website_link'])
              <a href="{{ $a_profile['website_link']}}" target="_blank"><span class="world"></span></a>
              @else
              <a><span class="world"></span></a>
              @endif
            </div>
          </div>
          @endif

          <div class="profilr_part_section">
           <a href="{{route('subscription')}}"><button class="gray_btn">Upgrade plan</button></a> 
          </div>
        </div>
      </div>
      <div class="event_list_section">

          <div class="event_list_section_tab">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="false"
                    >
                    Scheduled  Events
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="true"
                    >
                    Past Events
                    </button>
                  </li>
                </ul>
          </div>
        <div class="tab-content" id="pills-tabContent">
          <div
            class="tab-pane fade show active"
            id="pills-home"
            role="tabpanel"
            aria-labelledby="pills-home-tab"
            tabindex="0"
          >
            <div class="event_tabe_section">
              @if(count($scheduleEvent)> 0)
                @foreach ($scheduleEvent as $scevent)
                <div class="bg_layout event_card">
                  <?php
                  $v = explode(',',$scevent['image'])
                  ?>
                    <img src="{{ url('').'/eventimages/'.$v[0] }}" alt="card" />
                    <div class="today_btn">
                      <button>
                        <?php 
                        $current = strtotime(date("Y-m-d"));
                            $date    = strtotime($scevent['date']);

                            $datediff = $date - $current;
                            $difference = floor($datediff/(60*60*24));
                            if($difference==0)
                            {
                                echo 'Today';
                            }
                            else if($difference > 1)
                            {
                                echo 'Future';
                            }
                            else if($difference > 0)
                            {
                                echo 'Tomorrow';
                            }
                            else if($difference < -1)
                            {
                                echo 'Long Back';
                            }
                            else
                            {
                                echo 'Yesterday';
                            }  
                          ?>
                      </button>
                    </div>
                    <div class="event_card_bottom">
                      <div class="event_card_bottom_left">
                        <h3>{{$scevent['event_title']}}</h3>
                        <?php
                                $date = DateTime::createFromFormat('H:i:s',$scevent['event_time']);
                                $date->modify('+'.$scevent['duration'].' minutes');
                          ?>
                          <p>{{date("g:i A", strtotime($scevent['event_time']." UTC"))}} - {{date("g:i A", strtotime($date->format('h:i A')." UTC"))}}</p>
                      </div>
                      <div class="event_card_bottom_right">
                       <a href="{{ url('web/eventDetail/'.Crypt::encryptString($scevent['id'])) }}"><button>View</button></a> 
                      </div>
                    </div>
                  </div>
                @endforeach
                @else
                <p>"No Scheduled Events For You"</p>
              @endif
            </div>
          </div>
          <div
            class="tab-pane fade"
            id="pills-profile"
            role="tabpanel"
            aria-labelledby="pills-profile-tab"
            tabindex="0"
          >
          <div class="event_tabe_section">
            @if(count($pastEvent)> 0)
            @foreach ($pastEvent as $psevent)
                <div class="bg_layout event_card">
                  <?php
                  $v = explode(',',$psevent['image'])
                  ?>
                    <img src="{{ url('').'/eventimages/'.$v[0] }}" alt="card" />
                    <div class="today_btn"></div>
                    <div class="event_card_bottom">
                      <div class="event_card_bottom_left">
                        <h3>{{$psevent['event_title']}}</h3>
                        <?php
                                $date = DateTime::createFromFormat('H:i:s',$psevent['event_time']);
                                $date->modify('+'.$psevent['duration'].' minutes');
                          ?>
                          <p>{{date("g:i A", strtotime($psevent['event_time']." UTC"))}} - {{date("g:i A", strtotime($date->format('h:i A')." UTC"))}}</p>
                      </div>
                      <div class="event_card_bottom_right">
                       <a href="{{ route('eventHistoryDetails',$psevent['id']) }}"><button>View</button></a> 
                      </div>
                    </div>
                </div>
            @endforeach
            @else
                <p>"No Past Events For You"</p>
              @endif
          </div>
        </div>
        </div>
      </div>
    </div>
</section>
  <!-- popup section  -->
  <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered home_popup">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="profile_card popup_home">

          <div class="profile_section_inner">
            <div class="profile_img_section">
              @if(isset(auth()->user()->artistProfile->profile_image))
              <img class="profile_img" src="{{ asset('artist_profile_images/'.optional(auth()->user()->artistProfile)->profile_image)}}" alt="profile" />
              @else
              <img class="profile_img" src="{{ asset('artist_profile_images/profile1.jpeg')}}" alt="profile" />
              @endif
              {{-- <img
                class="profile_img"
                src="{{ asset('assets/web/images/homepage-cart-user.png') }}"
                alt="profile"
              /> --}}
              @if(isset($a_profile) && $a_profile)
             <div class="">
              @if($a_profile['d_stagename'] == 'on')
              <p>{{ucfirst($a_profile['stage_name'])}}</p>
              <a><h2>{{ ucfirst($a_profile['name']) }}</h2></a>
              @else
              <a><h2>{{ ucfirst($a_profile['name']) }}</h2></a>
              <p>{{ucfirst($a_profile['stage_name'])}}</p>
              @endif
             </div>
            </div>

            <div class="profilr_part_section">
              <h6 class="sub_header">Genre:</h6>
              <p>{{ucfirst($a_profile['genre'])}}</p>
            </div>
            <div class="profilr_part_section">
              <h6 class="sub_header">Social Links :</h6>

              <div class="social_icon">
                @if($a_profile['facebook_link'])
              <a href="{{ $a_profile['facebook_link'] }}" target="_blank"><span class="face_book"></span></a>
              @else
              <a><span class="face_book"></span></a>
              @endif
              @if($a_profile['instagram_link'])
              <a href="{{ $a_profile['instagram_link']}}" target="_blank"><span class="instagram"></span></a>
              @else
              <a><span class="instagram"></span></a>
              @endif
              @if($a_profile['itunes_link'])
              <a href="{{ $a_profile['itunes_link']}}" target="_blank"><span class="itnes"></span></a>
              @else
              <a><span class="itnes"></span></a>
              @endif
              @if($a_profile['youtube_link'])
              <a href="{{ $a_profile['youtube_link']}}" target="_blank"><span class="youtube"></span></a>
              @else
              <a><span class="youtube"></span></a>
              @endif
              @if($a_profile['website_link'])
              <a href="{{ $a_profile['website_link']}}" target="_blank"><span class="world"></span></a>
              @else
              <a><span class="world"></span></a>
              @endif
              </div>
            </div>
           

            <div class="profilr_part_section">
             <a href="{{route('subscription')}}"><button class="gray_btn">Upgrade plan</button></a> 
            </div>
          </div>

        </div>
        <div class="bio_header">
          <h4 class="font-18">
            Bio
          </h4>
          <p class="font-20">{{ ucfirst($a_profile['bio']) }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="modal fade rating-pop-up" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-22" id="exampleModalLabel">Time Zone Change</h5>
          <button type="button" class="btn-close top-pos" data-bs-dismiss="modal" aria-label="Close" id="timezone_no"></button>
        </div>
        <div class="modal-footer premium-footer">
            <a href="{{ url('web/profile')}}">
                <button type="button" class="btn go-btn ms-0" id="rate">Yes</button>
            </a>
            <button type="button" class="btn go-btn ms-0" data-bs-dismiss="modal" id="timezone_no">No</button>
        </div>
      </div>
    </div>
</div>


@endsection
@section('homeblade')
<script>
  var val = document.getElementById("timemsg").value;

  window.onload = function() {
      // alert(val);
      // Check the session variable and display the modal if set
      if(val == "no"){
          $("#exampleModal2").modal('show');
      }
      
  }

  $(document).on("click", "#timezone_no", function (e) {
   e.preventDefault();
   $.ajax({
       headers: {
           'X-CSRF-Token': '{{ csrf_token() }}',
       },
       url: "{{route('timezone_no') }}",
    
       type: 'POST',
       success: function (data) {
        console.log(data);
       },
       error:function(data){
       }
   });
});
</script>
<script>
  $(document).ready(function(){
    toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };
      if(localStorage.getItem("eventupdate"))
    {
      toastr.success("Event update Successfully");
        localStorage.clear();
    }
  });
  // Set the date we're counting down to
  var time = document.getElementById('event_time').value;
  // var c = Date.parse(time) / 1000 ;
  var countDownDate = time * 1000;
  // 1.php
  var now = '<?php echo time() ?>' * 1000;

  // var cu_time = '<?php echo date("h:i:s a"); ?>';
  // console.log(countDownDate,cu_time);

  // 2.script
  // var countDownDate = new Date(time).getTime();
  
  // Update the count down every 1 second
  var x = setInterval(function() {
  
    // Get today's date and time
    // var now = date();
   
    // 1.script
    // var now = new Date().getTime();

    // 2.php
    now = now + 1000;

    // Find the distance between now and the count down date
    var distance = countDownDate - now;
      
    // Time calculations for days, hours, minutes and seconds
    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = hours + ":"
    + minutes+":"+seconds+ " min";
      
    // If the count down is over, write some text 
    if (distance < 0) {
      clearInterval(x);
      document.getElementById("demo").innerHTML = "EXPIRED";
    }
  }, 1000);
  </script>
  @endsection