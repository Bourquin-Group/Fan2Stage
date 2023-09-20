@extends('artistweb.layouts.main')
@section('body')
<section class="main_section custom_container">
    <div class="navgat_otherpage">
      <h1 class="task_titlt"><a href="{{url()->previous()}}"><span><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></span></a> {{ucfirst(trans($sc_event['event_title']))}}</h1>
      <div class="button_gorup">
          {{-- <button onclick="endLive('{{$sc_event['event_id']}}')">End Live</button>  --}}
          {{-- <button onclick="myFunction()">Click me</button> --}}
         <a class="endlive"> <button>End Live</button></a> 
         {{-- <a href="{{url('web/endlive/'.Crypt::encryptString($sc_event['event_id']))}}" class="endlive"> <button>End Live</button></a>  --}}
      </div>
  </div>
    <div class="row ">
      <div class="col-lg-7 col-md-12 d-grid">
        <div class="event_bg">
          <div class="imgsection">
            <iframe src="{{$sc_event['link_to_event_stream']}}" frameborder="0" style="width:100%;height:100%" allowfullscreen></iframe>
          </div>
          <div class="card_live">
              <div class="live_fans">
                  <div class="live_fans_left">
                      <p class="font-18">Total Fans Booked</p>
                      <h2><span id="bookedcount"></span></h2>
                  </div>
                  <div class="live_fans_right">
                      <img src="{{asset('/assets/web/images/fans_live.svg')}}" alt="">
                  </div>
              </div>
              <div class="live_fans">
                  <div class="live_fans_left">
                      <p class="font-18">Total Fans Online</p>
                      <h2><a href="{{ url('web/userscount/'.base64_encode($sc_event['event_id'])) }}"><span id="livecount"></span></a></h2>
                  </div>
                  <div class="live_fans_right">
                      <img src="{{asset('/assets/web/images/world_icon.svg')}}" alt="">
                  </div>
              </div>
          </div>
    
        </div>

      </div>
      <div class="col-lg-5 col-md-12">
        <div class="event_formsection h-100">
          <div class="slider_header h-100">

              <div class="main_live">
                <div id="actt1">0</div>
              <div class="range-slider">
                <audio id="crowd" src="{{ asset('assets/audio/RoomNoice_B1.mp3') }}"></audio>
                <audio id="crowd1" src="{{ asset('assets/audio/RoomNoice_B1.mp3') }}"></audio>
                <input type="hidden" name="event_id" id="event_id" value="{{$sc_event['event_id']}}">
                <input type="hidden" name="user_id" id="user_id" value="{{isset(auth()->user()->id) ? auth()->user()->id : ''}}">
                  <input type="range" orient="vertical" min="0" max="100" />
                  <audio id="clap" src="{{ asset('assets/images/audio/'.$audio_value['Clap']) }}"></audio>
                  <audio id="clap1" src="{{ asset('assets/images/audio/'.$audio_value['Huge Clap']) }}"></audio>
                  <div id="aact1"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/clap-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt2">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  <audio id="boo" src="{{ asset('assets/images/audio/'.$audio_value['Boo']) }}"></audio>
                  <div id="aact2"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/boo-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt3">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  <audio id="whistle" src="{{ asset('assets/images/audio/'.$audio_value['Whistle']) }}"></audio>
                  <audio id="whistle1" src="{{ asset('assets/images/audio/'.$audio_value['Huge Whistle']) }}"></audio>
                  <div id="aact3"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/party-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt4">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" value="0" />
                  <audio id="aww" src="{{ asset('assets/images/audio/'.$audio_value['Aww']) }}"></audio>
                  <div id="aact4"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/music-svg.svg')}}" alt=""></div></div>
              <div class="main_live">
                <div id="actt5">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  <audio id="cheer" src="{{ asset('assets/images/audio/'.$audio_value['Cheer']) }}"></audio>
                  <div id="aact5"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/surprised-svg .svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt6">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" value="0" />
                  <audio id="laugh" src="{{ asset('assets/images/audio/'.$audio_value['Laugh']) }}"></audio>
                  <audio id="laugh1" src="{{ asset('assets/images/audio/'.$audio_value['Huge Laugh']) }}"></audio>
                  <div id="aact6"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/smile-svg.svg')}}" alt=""></div></div>
      
          </div>
        </div>

      </div>
    </div>


  </section>
@endsection

@section('golive')

<script>
    $(document).ready(function(){
      $(document).on("click", ".endlive", function (e) {
        var event_id = 80;
        // var event_id = $("input[name=event_id]").val();
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to end the event?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                }).then((result) => {
                if (result.isConfirmed) {
                    endLive(event_id );
            //         $.ajax({
            //     headers: {
            //         'X-CSRF-Token': '{{ csrf_token() }}',
            //     },
            //     url: "{{route('endlive') }}",
             
            //     type: 'POST',
            //     data: {'event_id':event_id},
            //     success: function (data) {
            //         if (data.success === true) {
            //             window.location.href = "{{ url('/web/artisthome') }}";
            //         }else{
            //                 swal.fire(data.message,"error");
            //             }
            //     }
            // });
                }
                })
            
        });

    });
  </script>

<script>
    var crowd = document.getElementById('crowd');
    var crowd1 = document.getElementById('crowd1');
     $(document).ready(function(){
        var ajax_call = function() {
            var id = $('#event_id').val();
            var url = "/web/livefancount/"+id;
        
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    if(data['livecount'] && data['livecount'] != ''){
                        // $('#livecount').html(data['livecount']);
                        if(data['livecount'] >= 2){
                            // $.playCrowdAudio();
                        }
                    }
                    if(data['bookedcount'] && data['bookedcount'] != ''){
                        $('#bookedcount').html(data['bookedcount']);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            };

        var interval = 8000; 
        ajax_call();
        setInterval(ajax_call, interval); 
        



        // var crowdd1 = function() {
        //     // crowd1.play();
        //     // crowd.pause();
        //     crowd.loop = true;
        //     crowd.load();
        // };
        // var interval1 = 40000; 
        // crowdd1();
        // setInterval(crowdd1, interval1); 
       
        
    });
    // playCrowdAudio(){
    //         // crowd.play();
    //         alert('hi');
    //     }
    // var crowd = document.getElementById('crowd');
    // $.playCrowdAudio = function() {
    //         crowd.play();
    //         // crowd.loop = true;
    //         // crowd.load();
    //     }

        window.onload = function() {
            playSound();
            };

            function playSound()
            {
                crowd.play();
            // var myAudio = new Audio('http://ithmbwp.com/feedback/SoundsTest/sounds/tank_driven.wav'); 

            // myAudio.volume = 0.3 ;

            var tank_driven_sound = setInterval(function()
            {
                crowd.currentTime = 0;
                crowd.play();
            }, 40000);

            }
</script>
{{-- <script>
    $(document).ready(function(){
    // call action count
    var actionajax_call = function() {
            var id = $('#event_id').val();
            var url = "/web/livefanactioncount/"+id;
        
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    console.log(data['message']);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            };

        var actioninterval = 1000 * 60 * 1; 
        actionajax_call();
        setInterval(actionajax_call, actioninterval); 
        // call action count
    });
</script> --}}
<script>
    var clap = document.getElementById('clap');
    var boo = document.getElementById('boo');
        var whistle = document.getElementById('whistle');
        var aww = document.getElementById('aww');
        var  cheer= document.getElementById('cheer');
        var  laugh= document.getElementById('laugh');
   
        

    // $(document).ready(function(){

        // socket script
    //  var socket = io.connect("http://127.0.0.1:7002");
     var socket = io.connect("https://live-stream.f2s.live");
    //  var socket = io.connect("https://fan2stage-live.colanapps.in");

  
                    
                    signIn();
                        
                    function endLive(eventId) {
                        // console.log('hello vimal');
                        // alert(eventId);
                        socket.emit('end-event', { event: eventId });
                        
                    }
                    
                    


                    function signIn() {
                        var event_id = $('#event_id').val();
                        var userid = $('#user_id').val();
                        // const event_id = 80;
                        // const userid = 202;

                        socket.emit('join-event', { event: event_id, user_id: userid });
                    }
    
                    socket.on('joining-confirmation', (msg) => {
                        // will receive the socket idfor the user;
                        console.log('My Socket Id: ', msg)
                    });

                    // event ending message
                socket.on('ended-the-event', (msg) => {
                    // console.log('ended-the-event response: ', msg)
                    if(msg['success'] == true){
                        Swal.fire({
                            title: 'Event has been ended!',
                            confirmButtonText: 'OK',
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ url('/web/artisthome') }}";
                            }
                            })
                    }
                    
                });
                // event ending message
    
                    socket.on('live_fan_count', (msg) => {
                        $('#livecount').html(msg['livecount']);
                        $('#bookedcount').html(msg['bookedcount']);
                        console.log('live_fan_count response: ', msg)
                    });

                    socket.on('artist_action_graph_count', (msg) => {
                        if(msg['act1'] <= 10){
                            var clap = 'clap';
                            if(msg['act1'] <= 5 && msg['act1'] != 0){
                            $.playAudio(clap);
                        }
                        if(msg['act1'] > 5 && msg['act1'] != 0){
                            $.stopAudio(clap);
                            $.playAudio1(clap);
                        }
                        document.getElementById("aact1").style.cssText = `height: calc(${msg['act1'] * 10}% + 0px)`;
                    }else{
                        document.getElementById("aact1").style.cssText = `height: calc(0% + 0px)`;

                    }
                    if(msg['act2'] <= 10){
                        if(msg['act2'] > 1){
                            var boo = 'boo';
                            $.playAudio(boo);
                        }
                        document.getElementById("aact2").style.cssText = `height: calc(${msg['act2'] * 10}% + 0px)`;
                    }else{
                        document.getElementById("aact2").style.cssText = `height: calc(0% + 0px)`;
                    }
                    if(msg['act3'] <= 10){
                        var whistle = 'whistle';
                        if(msg['act3'] > 1){
                            $.playAudio(whistle);
                        }
                        if(msg['act3'] > 5 && msg['act3'] != 0){
                            $.stopAudio(whistle);
                            $.playAudio1(whistle);
                        }
                        document.getElementById("aact3").style.cssText = `height: calc(${msg['act3'] * 10}% + 0px)`;
                    }else{
                        document.getElementById("aact3").style.cssText = `height: calc(0% + 0px)`;

                    }
                    if(msg['act4'] <= 10){
                        if(msg['act4'] > 1){
                            var aww = 'aww';
                            $.playAudio(aww);
                        }
                        document.getElementById("aact4").style.cssText = `height: calc(${msg['act4'] * 10}% + 0px)`;
                    }else{
                        document.getElementById("aact4").style.cssText = `height: calc(0% + 0px)`;

                    }
                    if(msg['act5'] <= 10){
                        if(msg['act5'] > 1){
                            var cheer = 'cheer';
                            $.playAudio(cheer);
                        }
                        document.getElementById("aact5").style.cssText = `height: calc(${msg['act5'] * 10}% + 0px)`;
                    }else{
                        document.getElementById("aact5").style.cssText = `height: calc(0% + 0px)`;

                    }
                    if(msg['act6'] <= 10){
                        var laugh = 'laugh';
                        if(msg['act6'] > 1){
                            $.playAudio(laugh);
                        }
                        if(msg['act6'] > 5 && msg['act6'] != 0){
                            $.stopAudio(laugh);
                            $.playAudio1(laugh);
                        }
                        document.getElementById("aact6").style.cssText = `height: calc(${msg['act6'] * 10}% + 0px)`;
                    }else{
                        document.getElementById("aact6").style.cssText = `height: calc(0% + 0px)`;

                    }
                        $('#actt1').html(msg['actt1']);
                        $('#actt2').html(msg['actt2']);
                        $('#actt3').html(msg['actt3']);
                        $('#actt4').html(msg['actt4']);
                        $('#actt5').html(msg['actt5']);
                        $('#actt6').html(msg['actt6']);
                        console.log('artist_action_graph_count response: ', msg)
                    });
                    // socket.on('action_graph_count', (msg) => {
                    //     // console.log()
                    //     $('#livecount').html(msg['livecount']);
                    //     console.log('action_graph_count response: ', msg);
                    // });

                    setInterval(function () {
		document.getElementById("aact1").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("aact2").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("aact3").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("aact4").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("aact5").style.cssText = `height: calc(0% + 0px)`;
		document.getElementById("aact6").style.cssText = `height: calc(0% + 0px)`;
	}, 8000);
    
                   
               // socket script
    // call actionsummary count
    // var actionajax_calls = function() {
    //         var id = $('#event_id').val();
    //         var url = "/web/actiongraphcount1/"+id;
    //         var clap = $("#clap");
        
    //         $.ajax({
    //             type: "GET",
    //             url: url,
    //             success: function (data) {
    //                 if(data['act1'] <= 10){
    //                     var clap = 'clap';
    //                     if(data['act1'] <= 5 && data['act1'] != 0){
    //                         $.playAudio(clap);
    //                     }
    //                     if(data['act1'] > 5 && data['act1'] != 0){
    //                         $.stopAudio(clap);
    //                         $.playAudio1(clap);
    //                     }
    //                     document.getElementById("aact1").style.cssText = `height: calc(${data['act1'] * 10}% + 0px)`;
    //                 }else{
    //                     document.getElementById("aact1").style.cssText = `height: calc(0% + 0px)`;

    //                 }
    //                 if(data['act2'] <= 10){
    //                     if(data['act2'] > 1){
    //                         var boo = 'boo';
    //                         $.playAudio(boo);
    //                     }
    //                     document.getElementById("aact2").style.cssText = `height: calc(${data['act2'] * 10}% + 0px)`;
    //                 }else{
    //                     document.getElementById("aact2").style.cssText = `height: calc(0% + 0px)`;
    //                 }
    //                 if(data['act3'] <= 10){
    //                     var whistle = 'whistle';
    //                     if(data['act3'] > 1){
    //                         $.playAudio(whistle);
    //                     }
    //                     if(data['act3'] > 5 && data['act3'] != 0){
    //                         $.stopAudio(whistle);
    //                         $.playAudio1(whistle);
    //                     }
    //                     document.getElementById("aact3").style.cssText = `height: calc(${data['act3'] * 10}% + 0px)`;
    //                 }else{
    //                     document.getElementById("aact3").style.cssText = `height: calc(0% + 0px)`;

    //                 }
    //                 if(data['act4'] <= 10){
    //                     if(data['act4'] > 1){
    //                         var aww = 'aww';
    //                         $.playAudio(aww);
    //                     }
    //                     document.getElementById("aact4").style.cssText = `height: calc(${data['act4'] * 10}% + 0px)`;
    //                 }else{
    //                     document.getElementById("aact4").style.cssText = `height: calc(0% + 0px)`;

    //                 }
    //                 if(data['act5'] <= 10){
    //                     if(data['act5'] > 1){
    //                         var cheer = 'cheer';
    //                         $.playAudio(cheer);
    //                     }
    //                     document.getElementById("aact5").style.cssText = `height: calc(${data['act5'] * 10}% + 0px)`;
    //                 }else{
    //                     document.getElementById("aact5").style.cssText = `height: calc(0% + 0px)`;

    //                 }
    //                 if(data['act6'] <= 10){
    //                     var laugh = 'laugh';
    //                     if(data['act6'] > 1){
    //                         $.playAudio(laugh);
    //                     }
    //                     if(data['act6'] > 5 && data['act6'] != 0){
    //                         $.stopAudio(laugh);
    //                         $.playAudio1(laugh);
    //                     }
    //                     document.getElementById("aact6").style.cssText = `height: calc(${data['act6'] * 10}% + 0px)`;
    //                 }else{
    //                     document.getElementById("aact6").style.cssText = `height: calc(0% + 0px)`;

    //                 }
    //                     $('#actt1').html(data['actt1']);
    //                     $('#actt2').html(data['actt2']);
    //                     $('#actt3').html(data['actt3']);
    //                     $('#actt4').html(data['actt4']);
    //                     $('#actt5').html(data['actt5']);
    //                     $('#actt6').html(data['actt6']);
    //                     console.log(data['actt1']);
    //             },
    //             error: function (data) {
    //                 console.log('Error:', data);
    //             }
    //         });
    //         };

    //     var actionintervals = 1000; 
    //     actionajax_calls();
    //     setInterval(actionajax_calls, actionintervals); 
    //     // call actionsummary count
    // });
    $.playAudio = function(audiotype) {
            if(audiotype == 'clap'){
                clap.play();
            }
            if(audiotype == 'boo'){
                boo.play();
            }
            if(audiotype == 'whistle'){
                whistle.play();
            }
            if(audiotype == 'aww'){
                aww.play();
            }
            if(audiotype == 'cheer'){
                cheer.play();
            }
            if(audiotype == 'laugh'){
                laugh.play();
            }
        }
        $.playAudio1 = function(audiotype) {
            if(audiotype == 'clap'){
                clap1.play();
            }
            if(audiotype == 'whistle'){
                whistle1.play();
            }
            if(audiotype == 'laugh'){
                laugh1.play();
            }
        }
        $.stopAudio = function(audiotype) {
            if(audiotype == 'clap'){
                clap.pause();
            }
            if(audiotype == 'whistle'){
                whistle.pause();
            }
            if(audiotype == 'laugh'){
                laugh.pause();
            }
        }
</script>

@endsection