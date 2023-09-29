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
@endsection
@section('content')
<section class="main_section">
    <div class="custom_container live-content">
            <div class="navgat_otherpage">
                <h1 class="task_titlt"><a href="{{ url()->previous() }}"><span><img src="{{ asset('assets/fan/images/arrow-left.svg') }}" alt="arrow"></span></a> {{ucfirst(trans($event['event_title']))}}</h1>
                <div class="button_gorup">
                <button data-bs-toggle="modal" data-bs-target="#exampleModal1">Exit Event</button>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-7 col-md-12 d-grid">
                  <div class="event_bg">
                    <div class="imgsection">
                        {{-- <video controls=""> --}}
                            {{-- <iframe src="https://player.twitch.tv/?channel=esl_dota2&parent=localhost" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe> --}}
                            
                            <iframe src="{{$event['link_to_event_stream']}}" frameborder="0" style="width:100%;height:100%" allowfullscreen></iframe>
                            
                          {{-- </video> --}}
                    </div>
                  </div>
        
                </div>
                <div class="col-lg-5 col-md-12">
                  <div class="event_formsection live-bar-heignt">
                    <div class="user-text">
                        <div class="user-img view-sec">
                            <input type="hidden" name="event_id" id="event_id" value="{{$event['event_id']}}">
                            <input type="hidden" name="user_id" id="user_id" value="{{isset(auth()->user()->id) ? auth()->user()->id : ''}}">
                            <img src="{{$event['artist_image']}}" alt="">
                            <div class="user-name">
                                <h4 class="font-20">{{$event['artist_name']}}</h4>
                                <p class="font-14">{{$event['artist_stagename']}}</p>
                            </div> 
                            <div class="live-view">
                                <img src="{{ asset('assets/fan/images/live-eye.svg') }}" alt=""><span class="font-15" id="livecount"></span><a class="font-15">Live</a>
                            </div>                               
                        </div>
                    </div>
                    <div class="slider_header height-calc">
        
                        <div class="main_live">
                            {{-- <audio id="crowd" src="{{ asset('assets/audio/RoomNoice_B1.mp3') }}"></audio> --}}
                            <div class="emog_section pos-icon"><div id="act1" style="display:none;">0</div><img src="{{ asset('assets/fan/images/clap-svg.svg') }}" alt=""></div>
                            <div id="act1c">0</div>
                        <div class="range-slider">
                            <input type="range" orient="vertical" min="0" max="100" value="0">
                            <div id="act11"></div>
                            <div class="range-slider__thumb" style="bottom: 0%;">0%</div>
                            {{-- <audio id="clap" src="{{ asset('assets/audio/Clap.mp3') }}"></audio> --}}
                            {{-- <audio id="clap1" src="{{ asset('assets/audio/Clap2.mp3') }}"></audio> --}}
                        </div>
                        <div class="emog_section" id="1" data-id="act1" onclick="buttonClicked(this)"><img src="{{ asset('assets/fan/images/clap-svg.svg') }}" alt=""></div></div>
                
                        <div class="main_live">
                        <div class="emog_section pos-icon"><div id="act2" style="display:none;">0</div><img src="{{ asset('assets/fan/images/boo-svg.svg') }}" alt=""></div>
                        <div id="act2c">0</div>
                        <div class="range-slider">
                            <input type="range" orient="vertical" min="0" max="100" value="0">
                            <div id="act21"></div>
                            <div class="range-slider__thumb" style="bottom: 0%;">0%</div>
                            {{-- <audio id="boo" src="{{ asset('assets/audio/Boo.mp3') }}"></audio> --}}
                        </div>
                        <div class="emog_section" id="2" data-id="act2" onclick="buttonClicked(this)"><img src="{{ asset('assets/fan/images/boo-svg.svg') }}" alt=""></div></div>
                
                        <div class="main_live">
                            <div class="emog_section pos-icon"><div id="act3" style="display:none;">0</div><img src="{{ asset('assets/fan/images/party-svg.svg') }}" alt=""></div>
                            <div id="act3c">0</div>
                        <div class="range-slider" >
                            <input type="range" orient="vertical" min="0" max="100" value="0" >
                            <div id="act31"></div>
                            <div class="range-slider__thumb" style="bottom: 0%;">0%</div>
                            {{-- <audio id="whistle" src="{{ asset('assets/audio/Whistle1.mp3') }}"></audio> --}}
                        </div>
                        <div class="emog_section" id="3" data-id="act3" onclick="buttonClicked(this)"><img src="{{ asset('assets/fan/images/party-svg.svg') }}" alt="" class="clean"></div></div>
                
                        <div class="main_live">
                        <div class="emog_section pos-icon"><div id="act4" style="display:none;">0</div><img src="{{ asset('assets/fan/images/music-svg.svg') }}" alt=""></div>
                        <div id="act4c">0</div>
                        <div class="range-slider">
                            <input type="range" orient="vertical" min="0" max="100" value="0">
                            <div id="act41"></div>
                            <div class="range-slider__thumb" style="bottom: 0%;">0%</div>
                            {{-- <audio id="aww" src="{{ asset('assets/audio/Aww.mp3') }}"></audio> --}}
                        </div>
                        <div class="emog_section" id="4" data-id="act4" onclick="buttonClicked(this)"><img src="{{ asset('assets/fan/images/music-svg.svg') }}" alt=""></div></div>
                        <div class="main_live">
                        <div class="emog_section pos-icon"><div id="act5" style="display:none;">0</div><img src="{{ asset('assets/fan/images/surprised-svg.svg') }}" alt=""></div>
                        <div id="act5c">0</div>
                        <div class="range-slider">
                            <input type="range" orient="vertical" min="0" max="100" value="0">
                            <div id="act51"></div>
                            <div class="range-slider__thumb" style="bottom: 0%;">0%</div>
                            {{-- <audio id="cheer" src="{{ asset('assets/audio/Cheer.mp3') }}"></audio> --}}
                        </div>
                        <div class="emog_section" id="5" data-id="act5" onclick="buttonClicked(this)"><img src="{{ asset('assets/fan/images/surprised-svg.svg') }}" alt=""></div></div>
                
                        <div class="main_live">
                        <div class="emog_section pos-icon"><div id="act6" style="display:none;">0</div><img src="{{ asset('assets/fan/images/smile-svg.svg') }}" alt=""></div>
                        <div id="act6c">0</div>
                        <div class="range-slider">
                            <input type="range" orient="vertical" min="0" max="100" value="0">
                            <div id="act61"></div>
                            <div class="range-slider__thumb" style="bottom: 0%;">0%</div>
                            {{-- <audio id="laugh" src="{{ asset('assets/audio/Laugh1.mp3') }}"></audio> --}}
                        </div>
                        <div class="emog_section" id="6" data-id="act6" onclick="buttonClicked(this)"><img src="{{ asset('assets/fan/images/smile-svg.svg') }}" alt=""></div></div>
                
                    </div>
                  </div>
        
                </div>
            </div>
        </div>
        
      

        <!-- onload Modal -->
      

        <!-- onload Modal -->
        <div class="modal fade rating-pop-up" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-22" id="exampleModalLabel">Your Rating</h5>
                  {{-- <form action="{{ route('exitliveevent') }}" method="POST" autocomplete="off">
                    @csrf --}}
                  <div class="rating-sec">
                    <div class="rate">
                        <input type="hidden" name="event_id" value="{{$event['event_id']}}">
                    <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                                                      <label for="star5" title="text">5 stars</label>
                                                      <input type="radio" id="star4" class="rate" name="rating" value="4"/>
                                                      <label for="star4" title="text">4 stars</label>
                                                      <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                                      <label for="star3" title="text">3 stars</label>
                                                      <input type="radio" id="star2" class="rate" name="rating" value="2">
                                                      <label for="star2" title="text">2 stars</label>
                                                      <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                                      <label for="star1" title="text">1 star</label>
                    </div>
                  </div>
                  <span class="error_msg" id="rating1"></span>
                  <h4 class="font-18">Share Your Thoughts</h4>
                  {{-- <div class="rat-content"> --}}
                    <textarea class="form-group" name="event_review" id="event_review" cols="30" rows="5"></textarea>
                    <span class="error_msg" id="event_review1"></span>
                  {{-- </div> --}}
                  <button type="button" class="btn-close top-pos" data-bs-dismiss="modal" aria-label="Close" id="exiteventcancel"></button>
                </div>
                <div class="modal-body">
                    <h4 class="font-18">Leave a Tip</h4> 
                    <div class="rat-content rat-btn-flex">
                        <div class="content-wrapper">
                            <input type="radio" name="tips" id="" value="1" style="display: block">
                            <button class="rat-con-btn">$1</button>
                        </div>
                        
                        <div class="content-wrapper">
                      <input type="radio" name="tips" id="" value="5" style="display: block">
                      <button class="rat-con-btn">$5</button>
                        </div>
                        <div class="content-wrapper">
                      <input type="radio" name="tips" id="" value="10" style="display: block">
                      <button class="rat-con-btn">$10</button>
                        </div>
                        <div class="content-wrapper">
                            <input type="radio" name="tips" id="" value="0" style="display: block">
                      <button class="rat-con-btn last-btn">Custom</button>
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer premium-footer">
                  <button type="button" class="btn go-btn ms-0" id="rate">Submit</button>
                  {{-- <a href="{{ url('fan/fanhome')}}"> --}}
                    <button type="button" class="btn go-btn ms-0" id="exiteventcancel">Cancel</button>
                {{-- </a> --}}
                </div> 
            {{-- </form> --}}
              </div>
            </div>
        </div>

       
</section>
<div class="modal fade onload-pop show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"style="display: block;">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
         <img src="{{ asset('assets/fan/images/premium-img.png') }}" alt="" srcset="">    
        <h5 class="modal-title font-24" id="exampleModalLabel">Fan2Stage Premium</h5>
        <button type="button" class="btn-close top-pos" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <p class="font-18">Wish watching your favorite Event streaming Ads free?</p>
         <span class="font-16">Subscribe at just $1 a month</span>
        </div>
        <div class="modal-footer premium-footer">
        <button type="button" class="btn skip-bth" id="skip" data-bs-dismiss="modal">Skip</button>
        <button type="button" class="btn go-btn" id="goaddsfree">Go Ads Free </button>
        </div>
    </div>
    </div>
</div>
@endsection
@section('footer')
<script>
$('.stars a').on('click', function(){
  $('.stars span, .stars a').removeClass('active');

  $(this).addClass('active');
  $('.stars span').addClass('active');
});
// ---------------------------------------------
    $(window).on('load', function() {
    $('#exampleModal').modal('show');
});
var crowd = document.getElementById('crowd');

    $(document).ready(function(){

       $(document).on("click", "#rate", function (e) {
          var event_id = $("input[name=event_id]").val();
          var rating = $('input[name="rating"]:checked').val();
          var event_review = $("#event_review").val();
          var tips = $('input[name="tips"]:checked').val();
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: "{{route('exitliveevent') }}",
             
                type: 'POST',
                data: {'event_id':event_id,'rating':rating,'event_review': event_review,'tips': tips}, // Setting the data attribute of ajax with form_data
                success: function (data) {
                 
                    console.log(data)
                  var error_msg1  = data['message'];
                  if(data['status'] == 0){
                if(error_msg1['rating'] && error_msg1['rating'].length > 0){
                    var rating_error  = error_msg1['rating'][0];
                  $('#rating1').html(rating_error);
                }else{
                  $('#rating1').html('');
                }
                if(error_msg1['event_review'] && error_msg1['event_review'].length > 0){
                  var event_review_error  = error_msg1['event_review'][0];
                  $('#event_review1').html(event_review_error);
                }else{
                  $('#event_review1').html('');
                }
            }else{
                if(data['tipflag'] == 1){
                    var event_id = Base64.encode(data['event_id']);
                    var tipamount = Base64.encode(data['tipamount']);
                    console.log(event_id,tipamount);
                    location.replace('/fan/tips/'+event_id+'/'+tipamount);
                }else{

                    location.replace('/fan/fanhome');
                }
            }
               
                
                },
                error:function(data){
                  console.log(data);
                  
                }
            });


        });
        $(document).on("click", "#exiteventcancel", function (e) {
          var event_id = $("input[name=event_id]").val();
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: "{{route('exitliveeventapi') }}",
             
                type: 'POST',
                data: {'eventid':event_id}, // Setting the data attribute of ajax with form_data
                success: function (data) {
                    console.log(data);
                    location.replace('/fan/fanhome');
                },
                error:function(data){
                  console.log(data);
                  
                }
            });

            
        });
        // var myInterval = setInterval(function(){/*...*/}, 2000);
        // var ajax_call = setInterval(function() {
        //     var id = $('#event_id').val();
        //     var url = "/fan/livecount/"+id;
        
        //     $.ajax({
        //         type: "GET",
        //         url: url,
        //         success: function (data) {
        //             // if(data['livecount'] && data['livecount'] != ''){
        //             //     $('#livecount').html(data['livecount']);
        //             // }
                    
        //             if(data['endlive'] == true){
        //                 clearInterval(ajax_call);
        //                 Swal.fire({
        //                     title: 'Event has been ended!',
        //                     confirmButtonText: 'OK',
        //                     }).then((result) => {
        //                     if (result.isConfirmed) {
        //                         $("#exampleModal1").modal('show');
        //                     }
        //                     })
        //             }
        //         },
        //         error: function (data) {
        //             console.log('Error:', data);
        //         }
        //     });
        //     },5000);

        // var interval = 5000; 
        // ajax_call();
        // setInterval(ajax_call, interval); 
    });
        // $.playCrowdAudio = function() {
        //     crowd.play();
        // }
        // $.enableLoop = function() { 
        //     crowd.loop = true;
        //     crowd.load();
        //     } 

        //     function disableLoop() { 
        //     crowd.loop = false;
        //     crowd.load();
        //     } 
    
</script>
<script>
// button press
$(document).keypress(function(e){
    if(e.key == 1){
        var key1 = document.getElementById(e.key);
        key1.click();
    }
    if(e.key == 2){
        var key2 = document.getElementById(e.key);
        key2.click();
    }
    if(e.key == 3){
        var key3 = document.getElementById(e.key);
        key3.click();
    }
    if(e.key == 0){
        var key0 = document.getElementById(e.key);
        key0.click();
    }
    if(e.key == 9){
        var key9 = document.getElementById(e.key);
        key9.click();
    }
    if(e.key == 8){
        var key8 = document.getElementById(e.key);
        key8.click();
    }
});
// button press
var testclass = 0;
    var initialflag1 = true;
    var initialflag2 = true;
    var initialflag3 = true;
    var initialflag4 = true;
    var initialflag5 = true;
    var initialflag6 = true;

    var a11;
    var a12;
    var a13;
    var a14;
    var a15;
    var a16;
    var b11 = 0;
    var b12 = 0;
    var b13 = 0;
    var b14 = 0;
    var b15 = 0;
    var b16 = 0;
   function someFunction(a1,a2,a3,a4,a5,a6){
            a11 = a1;
            a12 = a2;
            a13 = a3;
            a14 = a4;
            a15 = a5;
            a16 = a6;
        }
        
    
   function someFunction1(b1,b2,b3,b4,b5,b6){
           b11 =b1;
           b12 =b2;
           b13 =b3;
           b14 =b4;
           b15 =b5;
           b16 =b6;
        }
        // var clap = document.getElementById('clap');
        // var clap1 = document.getElementById('clap1');
        // var boo = document.getElementById('boo');
        // var whistle = document.getElementById('whistle');
        // var aww = document.getElementById('aww');
        // var  cheer= document.getElementById('cheer');
        // var  laugh= document.getElementById('laugh');
       function buttonClicked(btn) {
            var v = btn.getAttribute('data-id');

            btn.click_counter = (btn.click_counter || 1);
            btn.click_counter1 = (btn.click_counter1 || 0) + 1;
            btn.click_counter2 = (btn.click_counter2 || 0) + 1;
            

            
            // $.actionbutton_call1();
            if(`${btn.click_counter}`){


                // window.localStorage.setItem(v, btn.click_counter);

                if(v == 'act1'){
                    totalcountfunction = a11 + btn.click_counter2;
                }
                if(v == 'act2'){
                        totalcountfunction = a12 + btn.click_counter2; 
                        
                    }
                if(v == 'act3'){
                        totalcountfunction = a13 + btn.click_counter2;
                        
                    }
                if(v == 'act4'){

                        totalcountfunction = a14 + btn.click_counter2;
                        
                    }
                if(v == 'act5'){
                        totalcountfunction = a15 + btn.click_counter2;
                        
                    }
                if(v == 'act6'){
                        totalcountfunction = a16 + btn.click_counter2;
                        
                    }
                if(totalcountfunction > 0){
                    document.getElementById(v).textContent = totalcountfunction;
                }else{
                    document.getElementById(v).textContent = btn.click_counter2;

                }
                
                    }
            if(`${btn.click_counter}` <= 10){
                var r = btn.click_counter1 * 10;
                var ids = `${v}`+ 1;
                var ids1 = `${v}`+ 'c';


                if(ids == 'act11'){
                    if(initialflag1 == true){
                        btn.click_counter1 = 1;
                        initialflag1 = false;
                    }
                    totalcountfunction1 = ((b11 && b11 > 0) ? (b11 + btn.click_counter1) : btn.click_counter1);
                    // var clap = 'clap';
                    // if(totalcountfunction1 <= 5){
                    //     playAudio(clap);
                    // }else{
                    //     stopAudio(clap);
                    //     playAudio1(clap);
                    // }
                    // if(totalcountfunction1 > 5){
                    //     stopAudio(clap);
                    // }
                }
                if(ids == 'act21'){
                    if(initialflag2 == true){
                        btn.click_counter1 = 1;
                        initialflag2 = false;
                    }
                    totalcountfunction1 = ((b12 && b12 > 0) ? (b12 + btn.click_counter1) : btn.click_counter1);
                    // var boo = 'boo';
                    // if(totalcountfunction1 > 1){
                    //     playAudio(boo);
                    // }
                    // if(totalcountfunction1 > 5){
                    //     stopAudio(boo);
                    // }
                    }
                if(ids == 'act31'){
                    if(initialflag3 == true){
                        btn.click_counter1 = 1;
                        initialflag3 = false;
                    }
                    totalcountfunction1 = ((b13 && b13 > 0) ? (b13 + btn.click_counter1) : btn.click_counter1);
                    // var whistle = 'whistle';
                    // if(totalcountfunction1 > 1){
                    //     playAudio(whistle);
                    // }
                    // if(totalcountfunction1 > 5){
                    //     stopAudio(whistle);
                    // }
                    }
                if(ids == 'act41'){
                    if(initialflag4 == true){
                        btn.click_counter1 = 1;
                        initialflag4 = false;
                    }
                    totalcountfunction1 = ((b14 && b14 > 0) ? (b14 + btn.click_counter1) : btn.click_counter1);
                    // var aww = 'aww';
                    // if(totalcountfunction1 > 1){
                    //     playAudio(aww);
                    // }
                    // if(totalcountfunction1 > 5){
                    //     stopAudio(aww);
                    // }
                    }
                if(ids == 'act51'){
                    if(initialflag5 == true){
                        btn.click_counter1 = 1;
                        initialflag5 = false;
                    }
                    totalcountfunction1 = ((b15 && b15 > 0) ? (b15 + btn.click_counter1) : btn.click_counter1);
                    var cheer = 'cheer';
                    // if(totalcountfunction1 > 1){
                    //     playAudio(cheer);
                    // }
                    // if(totalcountfunction1 > 5){
                    //     stopAudio(cheer);
                    // }
                    }
                if(ids == 'act61'){
                    if(initialflag6 == true){
                        btn.click_counter1 = 1;
                        initialflag6 = false;
                    }
                    totalcountfunction1 = ((b16 && b16 > 0) ? (b16 + btn.click_counter1) : btn.click_counter1);
                    // var laugh = 'laugh';
                    // if(totalcountfunction1 > 1){
                    //     playAudio(laugh);
                    // }
                    // if(totalcountfunction1 > 5){
                    //     stopAudio(laugh);
                    // }
                    }
                if(totalcountfunction1 <= 10){
                    document.getElementById(ids).style.cssText = `height:${totalcountfunction1 * 10}%`;
                    document.getElementById(ids1).textContent = totalcountfunction1;
                }
                $.actionbutton_call(v, btn.click_counter);
                    testclass = 1;
                
            }
            
        }
        $.actionbutton_call = function(v,count) {
            console.log('test2');
            var id = $('#event_id').val();
            var url = "/fan/actioncount";
            if(v == 'act1'){
                var act1 = (count > 0) ? count : 0;
                var act2 = 0;
                var act3 = 0;
                var act4 = 0;
                var act5 = 0;
                var act6 = 0;
                
            }
            if(v == 'act2'){
                var act2 = (count > 0) ? count : 0;
                var act1 = 0;
                var act3 = 0;
                var act4 = 0;
                var act5 = 0;
                var act6 = 0;
                
            }
            if(v == 'act3'){
                var act3 = (count > 0) ? count : 0;
                var act1 = 0;
                var act2 = 0;
                var act4 = 0;
                var act5 = 0;
                var act6 = 0;
                
            }
            if(v == 'act4'){
                var act4 = (count > 0) ? count : 0;
                var act1 = 0;
                var act2 = 0;
                var act3 = 0;
                var act5 = 0;
                var act6 = 0;
                
            }
            if(v == 'act5'){
                var act5 = (count > 0) ? count : 0;
                var act1 = 0;
                var act2 = 0;
                var act3 = 0;
                var act4 = 0;
                var act6 = 0;
                
            }
            if(v == 'act6'){
                var act6 = (count > 0) ? count : 0;
                var act1 = 0;
                var act2 = 0;
                var act3 = 0;
                var act4 = 0;
                var act5 = 0;
                
            }
            // var act1 = (localStorage.getItem('act1') > 0)? localStorage.getItem('act1') : 0;
            // var act2 = (localStorage.getItem('act2') > 0)? localStorage.getItem('act2') : 0;
            // var act3 = (localStorage.getItem('act3') > 0)? localStorage.getItem('act3') : 0;
            // var act4 = (localStorage.getItem('act4') > 0)? localStorage.getItem('act4') : 0;
            // var act5 = (localStorage.getItem('act5') > 0)? localStorage.getItem('act5') : 0;
            // var act6 = (localStorage.getItem('act6') > 0)? localStorage.getItem('act6') : 0;
            // setTimeout(() => {
                action_graph_count1(act1,act2,act3,act4,act5,act6);
            // }, 1000);
                // setInterval( function() { action_graph_count1(act1,act2,act3,act4,act5,act6); }, 5000 );
            // action_graph_count1(act1,act2,act3,act4,act5,act6);
            // $.ajax({
            //     headers: {
            //         'X-CSRF-Token': '{{ csrf_token() }}',
            //     },
            //     type: "POST",
            //     url: url,
            //     data: {id:id,act1:act1,act2:act2,act3:act3,act4:act4,act5:act5,act6:act6},
            //     success: function (data) {
            //         if(data['success']){
            //             console.log(data['success']);
            //         }
            //     },
            //     error: function (data) {
            //         console.log('Error:', data);
            //     }
            // });
            
            };

            // socket script
                    var socket = io.connect("https://live-stream.f2s.live");
                    
                signIn();
                    
                function signIn() {
                    var event_id = $('#event_id').val();
                    var userid = $('#user_id').val();
                    // const event_id = 80;
                    // const userid = 20;

                    socket.emit('join-event', { event: event_id, user_id: userid });
                }
                
                function action_graph_count1(act1,act2,act3,act4,act5,act6) {
                // var userid = 20;
                // var event_id = 80;
                var userid = $('#user_id').val();
                var event_id = $('#event_id').val();
				// alert(userid);
                if(testclass == 1){
                        socket.emit('save-action', { event: event_id, user_id: userid, act1: act1, act2: act2, act3: act3, act4: act4, act5: act5, act6: act6 })
                        testclass = 0;
                }
                   
                    

                    
                }
               
                // event ending message 
                socket.on('ended-the-event', (msg) => {
                    // console.log('ended-the-event response: ', msg)
                    if(msg['success'] == true){
                        Swal.fire({
                            title: 'Event has been ended!',
                            confirmButtonText: 'OK',
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $("#exampleModal1").modal('show');
                            }
                            })
                    }
                    
                });
                // event ending message
                // 
                socket.on('joining-confirmation', (msg) => {
                    // will receive the socket idfor the user;
                    console.log('My Socket Id: ', msg)
                });

                socket.on('live_status', (msg) => {
                    console.log('live_status response: ', msg)
                });

                // socket.on('artist_end_live', (msg) => {
                //     console.log('artist_end_live response: ', msg)
                // });

                socket.on('live_fan_count', (msg) => {
                    // $('#livecount').html(msg['livecount']);
                    console.log('live_fan_count response: ', msg)
                });

                socket.on('action_graph_count', (msg) => {
                    // console.log()
                    if(msg['act1'] == null){
                        msg1 = 0;
                    }else{
                        msg1 = msg['act1'];
                    }
                    if(msg['act2'] == null){
                        msg2 = 0;
                    }else{
                        msg2 = msg['act2'];
                    }
                    if(msg['act3'] == null){
                        msg3 = 0;
                    }else{
                        msg3 = msg['act3'];
                    }
                    if(msg['act4'] == null){
                        msg4 = 0;
                    }else{
                        msg4 = msg['act4'];
                    }
                    if(msg['act5'] == null){
                        msg5 = 0;
                    }else{
                        msg5 = msg['act5'];
                    }
                    if(msg['act6'] == null){
                        msg6 = 0;
                    }else{
                        msg6 = msg['act6'];
                    }
                    someFunction1(msg1,msg2,msg3,msg4,msg5,msg6);
                    // if(msg['act1'] <= 10 ){
                    //     $('#act11').css('height', msg['act1'] * 10 +'%');
                    // }
                    // if(msg['act2'] <= 10 ){
                    //     $('#act21').css('height', msg['act2'] * 10 +'%');
                    // }
                    // if(msg['act3'] <= 10 ){
                    //     $('#act31').css('height', msg['act3'] * 10 +'%');
                    // }
                    // if(msg['act4'] <= 10 ){
                    //     $('#act41').css('height', msg['act4'] * 10 +'%');
                    // }
                    // if(msg['act5'] <= 10 ){
                    //     $('#act51').css('height', msg['act5'] * 10 +'%');
                    // }
                    // if(msg['act6'] <= 10 ){
                    //     $('#act61').css('height', msg['act6'] * 10 +'%');
                    // }
                                        // $('#act21').css('height', msg['act2'] * 10 +'%');
                                        // $('#act31').css('height', msg['act3'] * 10 +'%');
                                        // $('#act41').css('height', msg['act4'] * 10 +'%');
                                        // $('#act51').css('height', msg['act5'] * 10 +'%');
                                        // $('#act61').css('height', msg['act6'] * 10 +'%');
                                        
                                        initialflag1 =initialflag2=initialflag3=initialflag4=initialflag5=initialflag6= true;
                                        $('#livecount').html(msg['livecount']);
                    console.log('action_graph_count response: ', msg);
                });

                socket.on('total_action_count', (msg) => {
                    someFunction(msg['act1'],msg['act2'],msg['act3'],msg['act4'],msg['act5'],msg['act6']);
                        $('#act1').html(msg['act1']);
                        $('#act2').html(msg['act2']);
                        $('#act3').html(msg['act3']);
                        $('#act4').html(msg['act4']);
                        $('#act5').html(msg['act5']);
                        $('#act6').html(msg['act6']);
                    console.log('total_action_count response: ', msg)
                });

                // socket.on('artist_action_graph_count', (msg) => {
                //     console.log('artist_action_graph_count response: ', msg)
                // });
                setInterval(function () {
		document.getElementById("act11").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("act21").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("act31").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("act41").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("act51").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("act61").style.cssText = `height: calc(0% + 0px)`;
	}, 5000);
           // socket script
</script>
<script>
    let app = (() => {

        function updateSlider(element) {
            if (element) {
                let parent = element.parentElement,
                    lastValue = parent.getAttribute('data-slider-value');

                if (lastValue === element.value) {
                    return; // No value change, no need to update then
                }

                parent.setAttribute('data-slider-value', element.value);
                let $thumb = parent.querySelector('.range-slider__thumb'),
                    $bar = parent.querySelector('.range-slider__bar'),
                    pct = element.value * ((parent.clientHeight - $thumb.clientHeight) / parent.clientHeight);

                $thumb.style.bottom = `${pct}%`;
                $bar.style.height = `calc(${pct}% + ${$thumb.clientHeight / 2}px)`;
                $thumb.textContent = `${element.value}%`;
            }
        }
        return {
            updateSlider: updateSlider
        };

    })();

    (function initAndSetupTheSliders() {
        const inputs = [].slice.call(document.querySelectorAll('.range-slider input'));
        inputs.forEach(input => input.setAttribute('value', '0'));
        inputs.forEach(input => app.updateSlider(input));
        // Cross-browser support where value changes instantly as you drag the handle, therefore two event types.
        inputs.forEach(input => input.addEventListener('input', element => app.updateSlider(input)));
        inputs.forEach(input => input.addEventListener('change', element => app.updateSlider(input)));
    })();
   
</script>
@endsection