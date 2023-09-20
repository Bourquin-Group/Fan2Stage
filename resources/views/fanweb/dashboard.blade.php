@extends('fanweb.layouts.main')
@section('content')

<section class="main_section"> 
        <div class="home-banner"><img src="{{asset('/assets/fan/images/homepage-bg.png')}}" alt="">
            <div class="home-fav">
                <p class="font-40">Enjoy Your Favorite
                    <span class="event-wrapper"><span class="event-inner">Events</span></span>
                </p>
            </div>
        </div>
        <div class="current-homepage custom_container">

            <div class="fav-arti">
                <div class="fav-head-wrapper">
                    <h3 class="font-22">Artists</h3>
                    <button class="btn font-16">Show all</button>
                </div>
                <div class="slick-slider">
                    @foreach($artist_profile as $aprofile)

                <div class="fav-artis-wrap">
                    <a href="{{url('/fan/artistprofile/'.base64_encode($aprofile['id']))}}">
                    <div class="fav-artis-wrap-inner">
                        <div class="fav-ar-img">
                            @if(file_exists(public_path('/artist_landingpage_images/'.$aprofile['profile_image'])) && isset($aprofile['profile_image']))
                                <img src="{{asset('/artist_profile_images/'.$aprofile['profile_image'])}}" alt="profile" />
                            @else
                                <img src="{{ asset('artist_profile_images/profile1.jpeg')}}" alt="profile" />
                            @endif
                            {{-- <img src="{{asset('/artist_profile_images/'.$aprofile['profile_image'])}}" alt=""> --}}
                        </div>
                        <h3 class="font-18">{{$aprofile['artist_name']}}</h3>
                        <p class="font-14">{{$aprofile['stagename']}}</p>
                    </div>
                    </a>
                </div>
                @endforeach
                </div>
                
            </div>
            <div class="fav-events liveevents">
               
                <div class="fav-head-wrapper">
                    <h3 class="font-22">Live Events</h3>
                    <button class="btn font-16"><a href="{{route('show-liveevent')}}">Show all</a></button>
                </div>
          
               <div class="event_tabe_section">
                @if(count($liveevent_data) > 0)
                @foreach($liveevent_data as $key => $ldata)
                @if($key < 4)
                
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
                            <p>{{date("g:i A", strtotime($ldata['event_time']." UTC"))}} - {{date("g:i A", strtotime($date->format('h:i A')." UTC"))}}</p>
                        </div>
                        <div class="event_card_bottom_right">
                            <a href="{{route('live-event',base64_encode($ldata['event_id']))}}">
                            <button>Join Now</button>
                            </a>
                        </div>
                        </div>
                    </div>
                 
                @endif
                @endforeach
                @else
                <p>"No Live Events Found"</p>
                @endif
               </div>
        
            </div>
            <div class="fav-events fav-schedule">
                <div class="fav-head-wrapper">
                    <h3 class="font-22">Scheduled Events</h3>
                    <button class="btn font-16"><a href="{{route('show-scheduleevent')}}">Show all</a></button>
                </div>
               <div class="event_tabe_section"> 
                @if(count($scheduleevent_data) > 0)
                @foreach($scheduleevent_data as $key => $sdata)
                @if($key < 4)
                
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
                            <p>{{date("g A", strtotime($sdata['event_time']." UTC"))}} - {{date("g:i A", strtotime($date->format('h:i A')." UTC"))}}</p>
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
                @endif
                @endforeach
                @else
                <p>"No Scheduled Events Found"</p>
                @endif
                 
               </div>
        
            </div>

        </div>

       
</section>

   
@endsection
@section('footer')

<script>
    const formatToPhone = (event) => {


        // I am lazy and don't like to type things more than once
        const target = event.target;
        const input = event.target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
        const zip = input.substring(0,4);
        const middle = input.substring(4,6);
        const last = input.substring(6,10);

        if(input.length > 6){target.value = `${zip} - ${middle} - ${last}`;}
        else if(input.length > 3){target.value = `${zip} - ${middle}`;}
        else if(input.length > 0){target.value = `${zip}`;}
    };
    const inputElement = document.getElementById('phoneNumber');
    inputElement.addEventListener('keyup',formatToPhone);
</script>
<script>
        $(document).ready(function () {

            $(".slick-slider").slick({
                slidesToShow: 10,
                infinite: false,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 2000,
                dots: false,
                prevArrow: "<button class='btn slick-prev'></button>",
                nextArrow: "<button class='btn slick-next'></button>",
                responsive: [
                    {
                        breakpoint: 1800,
                        settings: {
                            slidesToShow: 8,
                        }
                    },
                    {
                        breakpoint: 1400,
                        settings: {
                            slidesToShow: 6,
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 5,
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 374,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        });
    </script>
    @endsection