@extends('artistweb.layouts.main')
@section('body')
<style>
  .sender_logo1{
    border: 1px solid #A6C2E9;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    overflow: hidden;
  }
  #more {display: none;}
  #more1 {display: none;}
  </style>
<secction class="main_section custom_container">
      <div class="navgat_otherpage">
      <h1 class="task_titlt"><a href="{{route('eventHistory')}}"><span><img src="{{ asset('assets/images/arrow-left.svg')}}" alt="arrow"></span></a>Event History Details
            </h1>
   
      </div>
                <div class="row ">
                  <div class="col-lg-6 col-md-12 d-black">
                    <div class="event_bg">
                      <div class="imgsection">
                       @php  $image = explode(',',$eventHistory->event_image);  @endphp
                          <img src="{{ asset('/eventimages/'.$image[0])}}" alt="">
                      </div>
                      <div class="card_live event_history_fans">
                          <div class="live_fans">
                              <div class="live_fans_right">
                                  <img src="{{ asset('/assets/images/fans_live.svg')}}" alt="">
                              </div>
                              <div class="live_fans_left">
                                  <p class="tips_setion_content">Total Fans Booked</p>
                                  <h2 > {{ optional($eventHistory->eventBookingList)->count()}}</h2>
                              </div>
                              
                          </div>
                          <div class="live_fans">
                              <div class="live_fans_right">
                                  <img src="{{ asset('/assets/images/world_icon.svg')}}" alt="">
                              </div>
                              <div class="live_fans_left">
                                  <p class="tips_setion_content">Fan Participation</p>
                                  <h2 class="">{{ optional($eventHistory->eventBookingList->whereNotNull('exitEvent_Time'))->count()}}   </h2>
                              </div>

                          </div>
                          <div class="live_fans">
                              <div class="live_fans_right">
                                  <img src="{{ asset('/assets/images/emotion.svg')}}" alt="">
                              </div>
                              <div class="live_fans_left">
                                  <p class="tips_setion_content">Fans Action's Average </p>
                                  <h2> {{$action_average}}</h2>
                              </div>
                              
                          </div>
                          <div class="tips_setion">
                            <div class="tips_setion_icon"><img src="{{ asset('/assets/images/cards-with-dollar.svg')}}" alt=""><p class="tips_setion_content">Tips Amount Received So far </p> </div>
                            
                            <h3>$ {{$fantips->sum('amount')}}</h3>
                            <button data-bs-toggle="modal" href="#exampleModalToggle" role="button">View All</button>
                        </div>
                          
                      </div>

                
                    </div>

                  </div>
                  <div class="col-lg-6 col-md-12">
                    <div class="event_formsection">
                      <div class="review_rating_top">
                          <h2>  {{$eventHistory->event_title}}</h2>
                          <div class="review_rating_header">
                              <div class="review_rating_star">
                                  @for($i=0;$i<5;$i++)
                                              @if($eventHistory->eventJoinedByFans->avg('ratings') >$i)
                                              <span><img src="{{ asset('/assets/images/Rating star big.svg')}}" alt=""></span>
                                              @else
                                              <span><img src="{{ asset('/assets/images/Rating star big (Active).svg')}}" alt=""></span>
                                              @endif
                                  @endfor
                                   </div>
                              
                              <p>({{  round($eventHistory->eventJoinedByFans->avg('ratings'), 2)}})</p>
                              <P>{{$eventHistory->eventJoinedByFans->count()}} Reviews</P>
                          </div>
                      </div>
                      <div class="Latest_feld">
                          <div class="form-section">
                              <label for=""> Event Date</label>
                              <span> {{$eventHistory->event_date->format('d M Y')}}</span>
                            </div>
                            <div class="form-section">
                              <label for="">Event Duration</label>
                              <span> {{$eventHistory->event_duration}} mints</span>
                            </div>
                            <div class="form-section">
                              <label for="">Genre</label>
                              <span> {{$eventHistory->genre}} </span>
                            </div>
                      </div>
                      <div class="form-section">
                          <label for="">Description</label>
                          <span>
                            <p>{{substr($eventHistory->event_description,0,200)}}<?php if(strlen($eventHistory->event_description) > 200){ ?><span id="dots">...</span><span id="more">{{substr($eventHistory->event_description,200)}}</span>
                              <?php } ?>
                            </p>
                            <?php if(strlen($eventHistory->event_description) > 200){ ?>
                            <div style="color:aquamarine;cursor:pointer" onclick="myFunction()" id="myBtn">Read more</div>
                            <?php } ?>
                          {{-- {!! $eventHistory->event_description !!}  --}}
                         </span>
                      </div>
                    </div>
                    <div class="review_section">
                      <h3>Reviews </h3><button>({{  round($eventHistory->eventJoinedByFans->avg('ratings'), 2)}}) <img src="./assets/images/star 1.svg" alt=""></button><p>( {{$eventHistory->eventJoinedByFans->count()}} Reviews)</p>
                    </div>
                  
                    @foreach($eventHistory->eventJoinedByFans as $key=>$list)
                    <?php if($key <= 4){?>
                      
                          <div class="review_section_part">
                            <div class="review_section_part_header">
                                <div class="review_section_part_header_right">
                                  
                                    <div class="review_img">
                                      @if(file_exists(public_path('/fans_profile_images/'.$list->user->image)) && isset($list->user->image))
                                  <img src="{{ asset('fans_profile_images/'.$list->user->image) }}" >
                                  @else
                                      <img src="{{ asset('artist_profile_images/profile1.jpeg')}}" />
                                  @endif
                                    </div>
                                    <div class="review_rating">
                                        <h5>{{$list->user->name}}</h5>
                                        <div class="review_rating_star">
                                          @for($i=0;$i<5;$i++)
                                          @if($list->ratings >$i)
                                          <span><img src="{{ asset('/assets/images/Rating star big.svg')}}" alt=""></span> 
                                          @else
                                          <span><img src="{{ asset('/assets/images/Rating star big (Active).svg')}}" alt=""></span>
                                          @endif
                                          @endfor
                                          <p>({{$list->ratings}})</p>
                                         
                                        </div>
                                    </div>
                                </div>
                                <p class="review_time">{{$list->created_at->diffForHumans()}}</p>
                            </div>
                            <p>
                              {{$list->event_review}}</p>
                        </div>
                        <?php } ?>
                        <?php if($key > 4){?>
                          <div class="review_section_part">
                            <div class="review_section_part_header">
                                <div class="review_section_part_header_right">
                                    <div class="review_img"><img src="{{$list->user->image()}}" alt=""></div>
                                    <div class="review_rating">
                                        <h5>{{$list->user->name}}</h5>
                                        <div class="review_rating_star">
                                          @for($i=0;$i<5;$i++)
                                          @if($list->ratings >$i)
                                          <span><img src="{{ asset('/assets/images/Rating star big.svg')}}" alt=""></span> 
                                          @else
                                          <span><img src="{{ asset('/assets/images/Rating star big (Active).svg')}}" alt=""></span>
                                          @endif
                                          @endfor
                                          <p>({{$list->ratings}})</p>
                                         
                                        </div>
                                    </div>
                                </div>
                                <p class="review_time">{{$list->created_at->diffForHumans()}}</p>
                            </div>
                            <p> 
                              {{$list->event_review}}</p>
                        </div>
                        <?php } ?>
                        @endforeach
                        @if(count($eventHistory->eventJoinedByFans) > 5)
                        <div class="button_gorup">
                          <button  id="myBtn1">View More Comments</button>
                        </div>
                        @endif
          </div>

        </div>
      </div>


    </secction>

    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered tips_popup">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 " id="exampleModalToggleLabel" >List of Fans Tips</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="search_tips">
              <span><img src="{{ asset('/assets/images/popup_seach_icon.svg')}}" alt=""></span>
              <input type="text" id="searchTheKeys" placeholder="Search">
            </div>
            @foreach($eventHistory->eventJoinedByFans as $key=>$list)
            <div class="sender_profile_header_section" id="matchKey">

                  <div class="sender_profile_header"  >
                    <div class="sender_profile" id="subjectName">
                      <div class="sender_logo">
                        <img src="{{$list->user->image()}}" alt="">
                      </div>
                      <div class="sender_name">
                        <h4>{{optional($list->user)->name}}</h4>
                        <p>{{$list->created_at->format('d-m-Y')}} | {{$list->created_at->format('h:i A')}}</p>
                      </div>
                    </div>
                   
                    <div class="tips_amoumt">
                      <h6>${{$fantips->sum('amount')}}</h6>
                    </div>
                   
                  </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
</div>

@endsection
@section('script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $("#searchTheKeys").on('keyup', function(){
    
      var value = $(this).val().toLowerCase();
      $("#matchKey .sender_profile_header").each(function () {
         if ($(this).text().toLowerCase().search(value) > -1) {
            $(this).show();
            $(this).prev('.subjectName').last().show();
         } else {
            $(this).hide();
         }
      });
   });
   function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
var comm = document.querySelectorAll(".review_section_part");
var buttonSection = document.querySelector("#myBtn1")
 for(var i=0; i< 5 ; i++){
    comm[i].classList.toggle("show_item")
}
var moreBtn= true;
buttonSection.addEventListener("click" , function(){
  moreBtn=!moreBtn;
  moreBtn ? buttonSection.innerHTML="View More Comments" :buttonSection.innerHTML="View Less Comments";
  var comms = document.querySelectorAll(".review_section_part");
    for(var j = 5; j < comms.length; j++){
    comms[j].classList.toggle("show")
}
})



var comm = document.qu
  </script>
@endsection
