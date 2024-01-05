@extends('fanweb.layouts.main')
@section('content')

<section class="main_section"> 
        <div class="home-banner"><img src="{{asset('/assets/fan/images/homepage-bg.png')}}" alt="">
            <div class="home-fav">
                <p class="font-40">Enjoy Your Favorite
                    <span class="event-wrapper"><span class="event-inner">Events</span></span>
                    <input type="hidden" id="timemsg" value="{{Session::get('timezonechange')}}">
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
                            $eventdate = date('Y-m-d',strtotime($ldata['event_time']));
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
                            @if($ldata['event_amount'] == 0)
                                
                            <button class="checklive" data-id="{{$ldata['event_id']}}">Join Now</button>
                            
                            @else
                            
                            <a href="{{route('live-event',base64_encode($ldata['event_id']))}}">
                                <button>Join Now</button>
                                </a>
                            
                            @endif
                            
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
                                {{-- <input type="hidden" name="event_id" value="{{$sdata['event_id']}}"> --}}
                                
                                <button class="bookingevent" data-id="{{$sdata['event_id']}}"> Book Now</button>
                                {{-- <a href="{{route('scheduled-event',base64_encode($sdata['event_id']))}}"><button> Book Now</button></a>  --}}
                                
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
        <div class="modal fade rating-pop-up" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-22" id="exampleModalLabel">Time Zone Change</h5>
                  <button type="button" class="btn-close top-pos" data-bs-dismiss="modal" aria-label="Close" id="timezone_no"></button>
                </div>
                <div class="modal-footer premium-footer">
                    <a href="{{ url('fan/edit-profile')}}">
                        <button type="button" class="btn go-btn ms-0" id="rate">Yes</button>
                    </a>
                    <button type="button" class="btn go-btn ms-0" data-bs-dismiss="modal" id="timezone_no">No</button>
                </div>
              </div>
            </div>
        </div>
        

       
</section>

   
@endsection
@section('footer')
<script>
     $(document).ready(function(){
      $(document).on("click", ".bookingevent", function (e) {
        var event_id = $(this).data('id');
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: "{{route('checkprebooking') }}",
             
                type: 'POST',
                data: {'id':event_id},
                success: function (data) {
                    console.log(data);
                  if (data.success === false) {
                    if(data.flag == 0){
                        swal.fire(data.message);
                    }
                  }else{
                    window.location.href = "{{ url('/fan/scheduled-event/') }}"+"/"+data.event_id;
                  }
                }
            });
        });
        $(document).on("click", ".checklive", function (e) {
        var event_id = $(this).data('id');
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url:"{{ route('checklive') }}",
             
                type: 'POST',
            	data: {'id':event_id},
                success: function (data) {
                    console.log(data);
                  if (data.success === false) {
                    if(data.flag == 0){
                        swal.fire({
            				text: "Event has been ended",
            				type: "error",
                        customClass: {
                popup: 'error-text-color' // Add a custom class for text color
            }
        				}).then(function () {
            // When the alert is dismissed (by clicking anywhere), reload the page
            				location.reload();
        				});
                    
                    }
                  }else{
                    window.location.href = "{{ url('/fan/golive/') }}"+"/"+data.event_id;
                  }
                }
            });
        });

    });
</script>
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