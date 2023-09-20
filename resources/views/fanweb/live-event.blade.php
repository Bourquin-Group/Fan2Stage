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
        <div class="custom_container event-details-fan">
            <div class="navgat_otherpage">   
                <h1 class="task_titlt"><a href="{{route('fanhome')}}"><span><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></span></a>Event Details</h1>       
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
                                <img src="{{$event['artist_image']}}" alt="">
                                <div class="user-name">
                                    <h4 class="font-20">{{$event['artist_name']}}</h4>
                                    <p class="font-14">{{$event['artist_stagename']}}</p>
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
                                        <span> {{date("d F Y", strtotime($event['event_date']." UTC"))}}   </span>
                                     </div>
                                </div>
                                <div class="time-date form-section">
                                    <img src="{{asset('/assets/fan/images/fan-time.svg')}}" alt="" srcset="">
                                   <div class="label-del">
                                       <label for="">Time & Duration</label>
                                       <span>{{date("g:i A", strtotime($event['event_time']." UTC"))}} . {{$event['event_duration']}} mins   </span>
                                   </div>                                   
                              </div>
                            </div>
                        </div>
                        <div class="fan-about-text">
                            <h1 class="font-20">About This Event</h1>
                            <div class="amount row">
                                <span class="">Genre : {{$event['event_genre']}}</span>
                                <span class="">Amount : ${{$event['eventamount']}}</span>
                            </div>
                            <p class="font-18">
                                <p id="show-read-more">{{$event['event_description']}}</p>
                            </p>
                            <div class="join-event">
                                <input type="hidden" name="event_id" value="{{$event['event_id']}}">
                                <?php
                                if($event['booking_status'] == true || $event['eventamount'] == 0){ ?>
                                    <a class="font-16 join-btn" id="joinevent"><button>Join event</button></a>
                                    {{-- <a href="{{route('golive',base64_encode($event['event_id']))}}" class="font-16 join-btn" id="joinevent"><button>Join event</button></a> --}}
                                {{-- <?php /*}elseif($event['eventamount'] == 0){ */?>
                                    <a href="{{route('freebookevent',base64_encode($event['event_id']))}}" class="font-16 join-btn"><button>Book event</button></a> --}}
                                
                                <?php }else{
                                ?>
                                <a href="{{route('bookevent',base64_encode($event['event_id']))}}" class="font-16 join-btn"><button>Book event</button></a>
                                <span>Please book the event before join</span><?php } ?>
                                
                                <a class="font-18"><img src="{{asset('/assets/fan/images/share-svg.svg')}}" alt="" srcset="">Share</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@section('footer')
<script>
$(document).ready(function(){
	var maxLength = 300;
	$("#show-read-more").each(function(){
		var myStr = $(this).text();
		if($.trim(myStr).length > maxLength){
			var newStr = myStr.substring(0, maxLength);
			var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
			$(this).empty().html(newStr);
			$(this).append(' <a href="javascript:void(0);" class="read-more"> More...</a>');
			$(this).append('<span class="more-text">' + removedStr + '</span>');
		}
	});
	$(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
		$(this).remove();
	});

// check fan to join event
$(document).on("click", "#joinevent", function (e) {
        var event_id = $("input[name=event_id]").val();
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: "{{route('checkjoinevent') }}",
             
                type: 'POST',
                data: {'event_id':event_id},
                success: function (data) {
                  if (data.success === false) {
                    swal.fire(data.message,"error");
                        }else{
                          window.location.href = "{{ url('/fan/golive/') }}"+"/"+data.event_id;
                        }
                }
            });
        });

        // check fan to join event

});
</script>
@endsection