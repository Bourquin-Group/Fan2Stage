@extends('fanweb.layouts.main')
@section('header')
<style>
        .modal.right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 400px;
            max-width: 90%;
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .modal.right .modal-content {
            height: 100%;
            overflow-y: auto;
        }

        .modal.right .modal-body {
            padding: 15px 15px 80px;
        }



        /*Right*/
        .modal.right.fade .modal-dialog {
            right: -400px;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }

        .modal.right.fade.show .modal-dialog {
            right: 0;
        }
        #social-links ul li{
            display: inline-block;
        }
        #social-links ul li a{
            padding:7px;
            margin:2px;
            /* font-size: 25px; */
            /* color:rgb(46,41,144); */
            /* background-color: #ccc; */
        }
    </style>
    <style>
    #show-read-more .more-text{
        display: none;
    }
    .read-more
    {
        color:blue;
    }
</style>
@endsection
@section('content')
<section class="main_section">
        <div class="custom_container ">
            <div class="navgat_otherpage">   
                <h1 class="task_titlt"><a href="{{url()->previous()}}"><span><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></span></a>Event Details</h1>       
                @if(session()->has('paymentsuccess'))
                        <span class="text-success" id="bookedsuccessmsg" style="color:#14db7f;font-size:23px;margin-left:24%">{{session('paymentsuccess')}}</span>
                    @endif
            </div>
            <div class="row">
                <div class="col-lg-7 col-md-12 d-black">
                    <div class="event_bg fan-booked">
                        <div class="imgsection"> 
                            <img src="{{$event['event_image']}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="fan-event-detalis">
                        <div class="user-text">
                            <div class="user-img view-sec"> 
                                <img class ="profile-pic" src="{{($event['artist_image'])? $event['artist_image'] : asset('artist_profile_images/profile1.jpeg')}}" alt="">
                                <div class="user-name artists-detalis">
                                    @if($event['d_stagename'] == 'on')
                                        <p class="font-14">{{$event['artist_stagename']}}</p>
                                        <h4 class="font-20">{{$event['artist_name']}}</h4>
                                    @else
                                        <h4 class="font-20">{{$event['artist_name']}}</h4>
                                        <p class="font-14">{{$event['artist_stagename']}}</p>
                                    @endif
                                    <div class="f-rating">
                                        <p class="Followers_part">@if($event['followers'] != 0){{ $event['followers']}} Followers @else 0 Followers @endif</p>
                                        <span>{{$event['raiting']}} <img src="{{asset('/assets/fan/images/artists_card_star.svg')}}" alt="" srcset=""></span>
                                    </div>                                  
                                </div>
                                <a href="{{url('/fan/artistprofile/'.base64_encode($event['artist_id']))}}" class="font-16 view-btn"><button type="text" >View Profile</button></a>
                            </div>
                        </div>
                        <div class="right-tree">
                            <h1 class="font-24">{{$event['event_title']}} </h1>
                            <div class="first-column">
                                <div class="time-date form-section"> 
                                      <img src="{{asset('/assets/fan/images/fan-date.svg')}}" alt="" srcset="">
                                     <div class="label-del">
                                         <label for=""> Date</label>
                                         <span> {{date("d F Y", strtotime($event['event_date']." UTC"))}}</span>
                                     </div>
                                </div>
                                <div class="time-date form-section">
                                    <img src="{{asset('/assets/fan/images/fan-time.svg')}}" alt="" srcset="">
                                   <div class="label-del">
                                       <label for="">Time & Duration</label>
                                       <span>{{date("g:i A", strtotime($event['event_time']." UTC"))}} . {{$event['event_duration']}} mins     </span>
                                   </div>                                   
                              </div>
                            </div>
                        </div>
                        <div class="fan-about-text">
                            <h1 class="font-20">About This Event</h1>
                            <span>Genre : {{$event['event_genre']}}</span>
                            <p class="font-18">
                              <p id="show-read-more">{{$event['event_description']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
</section>

@endsection
@section('footer')
<script>

</script>


@endsection