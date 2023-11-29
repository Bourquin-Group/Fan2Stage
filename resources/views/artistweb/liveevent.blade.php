@extends('artistweb.layouts.main')
@section('body')
<section class="main_section custom_container">
    <div class="navgat_otherpage">
      <h1 class="task_titlt"><a href="{{url()->previous()}}"><span><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></span></a> {{ucfirst(trans($sc_event['event_title']))}}</h1>
      <div class="button_gorup">
          {{-- <button onclick="endLive('{{$sc_event['event_id']}}')">End Live</button>  --}}
          {{-- <button onclick="myFunction()">Click me</button> --}}
          <span id="audioToggle" style="display: inline-block;margin-right:12px;font-size:27px;"><i class="fas fa-volume-off"></i></span>
            <audio id="myAudio" src="{{ asset('assets/graph/audio/Crowd_1_100.mp3') }}" preload="auto" muted></audio>

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
                <!-- Button that triggers the audio play -->
                
                
                <input type="hidden" name="event_id" id="event_id" value="{{$sc_event['event_id']}}">
                <input type="hidden" name="user_id" id="user_id" value="{{isset(auth()->user()->id) ? auth()->user()->id : ''}}">
                  <input type="range" orient="vertical" min="0" max="100" />
                  @foreach($audio as $value)
                  <audio id="{{$value->audio_name."_".$value->block}}" src="{{ asset('assets/graph/audio/'.$value->audio_file) }}"></audio>
                  {{-- <audio id="clap2" src="{{ asset('assets/graph/audio/'.$audio_value['Clap2']) }}"></audio>
                  <audio id="clap3" src="{{ asset('assets/graph/audio/'.$audio_value['Clap3']) }}"></audio>
                  <audio id="clap4" src="{{ asset('assets/graph/audio/'.$audio_value['Clap4']) }}"></audio>
                  <audio id="clap5" src="{{ asset('assets/graph/audio/'.$audio_value['Clap5']) }}"></audio> --}}
                    @endforeach
                  <div id="aact1"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/clap-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt2">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  {{-- <audio id="boo" src="{{ asset('assets/images/audio/'.$audio_value['Boo']) }}"></audio> --}}
                  {{-- <audio id="boo1" src="{{ asset('assets/images/audio/'.$audio_value['Boo1']) }}"></audio>
                  <audio id="boo2" src="{{ asset('assets/images/audio/'.$audio_value['Boo2']) }}"></audio>
                  <audio id="boo3" src="{{ asset('assets/images/audio/'.$audio_value['Boo3']) }}"></audio>
                  <audio id="boo4" src="{{ asset('assets/images/audio/'.$audio_value['Boo4']) }}"></audio>
                  <audio id="boo5" src="{{ asset('assets/images/audio/'.$audio_value['Boo5']) }}"></audio> --}}
                  <div id="aact2"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/boo-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt3">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  {{-- <audio id="aww1" src="{{ asset('assets/images/audio/'.$audio_value['Aww1']) }}"></audio> --}}
                  {{-- <audio id="whistle" src="{{ asset('assets/images/audio/'.$audio_value['Whistle']) }}"></audio> --}}
                  {{-- <audio id="whistle1" src="{{ asset('assets/images/audio/'.$audio_value['Huge Whistle']) }}"></audio> --}}
                  <div id="aact3"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/party-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt4">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" value="0" />
                  {{-- <audio id="whistle1" src="{{ asset('assets/images/audio/'.$audio_value['Whistle1']) }}"></audio>
                  <audio id="whistle2" src="{{ asset('assets/images/audio/'.$audio_value['Whistle2']) }}"></audio>
                  <audio id="whistle3" src="{{ asset('assets/images/audio/'.$audio_value['Whistle3']) }}"></audio>
                  <audio id="whistle4" src="{{ asset('assets/images/audio/'.$audio_value['Whistle4']) }}"></audio>
                  <audio id="whistle5" src="{{ asset('assets/images/audio/'.$audio_value['Whistle5']) }}"></audio>
                   --}}
                  {{-- <audio id="aww" src="{{ asset('assets/images/audio/'.$audio_value['Aww']) }}"></audio> --}}
                  <div id="aact4"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/music-svg.svg')}}" alt=""></div></div>
              <div class="main_live">
                <div id="actt5">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  {{-- <audio id="cheer1" src="{{ asset('assets/images/audio/'.$audio_value['Cheer1']) }}"></audio> --}}
                  {{-- <audio id="cheer2" src="{{ asset('assets/images/audio/'.$audio_value['Cheer2']) }}"></audio>
                  <audio id="cheer3" src="{{ asset('assets/images/audio/'.$audio_value['Cheer3']) }}"></audio>
                  <audio id="cheer4" src="{{ asset('assets/images/audio/'.$audio_value['Cheer4']) }}"></audio>
                  <audio id="cheer5" src="{{ asset('assets/images/audio/'.$audio_value['Cheer5']) }}"></audio> --}}
                  {{-- <audio id="cheer" src="{{ asset('assets/images/audio/'.$audio_value['Cheer']) }}"></audio> --}}
                  <div id="aact5"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/surprised-svg .svg')}}" alt=""></div></div>
      
              <div class="main_live">
                <div id="actt6">0</div>
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" value="0" />
                  {{-- <audio id="laugh1" src="{{ asset('assets/images/audio/'.$audio_value['Laugh1']) }}"></audio>
                  <audio id="laugh2" src="{{ asset('assets/images/audio/'.$audio_value['Laugh2']) }}"></audio>
                  <audio id="laugh3" src="{{ asset('assets/images/audio/'.$audio_value['Laugh3']) }}"></audio>
                  <audio id="laugh4" src="{{ asset('assets/images/audio/'.$audio_value['Laugh4']) }}"></audio>
                  <audio id="laugh5" src="{{ asset('assets/images/audio/'.$audio_value['Laugh5']) }}"></audio> --}}
                  {{-- <audio id="laugh" src="{{ asset('assets/images/audio/'.$audio_value['Laugh']) }}"></audio> --}}
                  {{-- <audio id="laugh1" src="{{ asset('assets/images/audio/'.$audio_value['Huge Laugh']) }}"></audio> --}}
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
        // var event_id = 1;
        var event_id = $("input[name=event_id]").val();
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to end the event?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                }).then((result) => {
                if (result.isConfirmed) {
                    endLive(event_id );
                }
                })
            
        });

    });
  </script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('myAudio');
    const audioToggle = document.getElementById('audioToggle');

    // Check if the audio was playing before
    const isAudioPlaying = localStorage.getItem('audioPlaying') === 'true';

    if (isAudioPlaying) {
        audio.play()
            .then(() => {
                console.log('Audio started playing');
                audioToggle.style.display = 'none'; // Hide the button
            })
            .catch(error => {
                console.error('Error playing audio:', error);
            });
    }

    audioToggle.addEventListener('click', function() {
        if (audio.paused) {
            audio.play()
                .then(() => {
                    console.log('Audio started playing');
                    audioToggle.style.display = 'none'; // Hide the button
                    localStorage.setItem('audioPlaying', 'true'); // Store state
                })
                .catch(error => {
                    console.error('Error playing audio:', error);
                });
        }
    });
});




</script>
<script>
    // var clap = document.getElementById('clap');
    // var boo = document.getElementById('boo');
    //     var whistle = document.getElementById('whistle');
    //     var aww = document.getElementById('aww');
    //     var  cheer= document.getElementById('cheer');
    //     var  laugh= document.getElementById('laugh');
   
        

    // $(document).ready(function(){

        // socket script
     var socket = io.connect("https://live-stream.f2s.live");
    //  var socket = io.connect("https://fan2stage-live.colanapps.in");
    //  console.log(socket);

  
                    
                    signIn();
                        
                    function endLive(eventId) {
                        // console.log('hello vimal');
                        socket.emit('end-event', { event: eventId });
                        
                    }
                    
                    


                    function signIn() {
                        var event_id = $('#event_id').val();
                        var userid = $('#user_id').val();

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
                    const livecount = msg['livecount'];
                    $('#livecount').html(livecount);

                    const audioElements = {
                        1: Crowd1_1,
                        2: Crowd2_2,
                        3: Crowd3_3,
                        4: Crowd4_4
                    };

                    let currentAudio = audioElements[livecount];

                    if (!currentAudio) {
                        // No audio should play if livecount doesn't match any defined condition
                        Object.values(audioElements).forEach(audio => audio.pause());
                        $('#bookedcount').html(msg['bookedcount']);
                        $.clapsss(livecount);
                        console.log('live_fan_count response:', msg);
                        return;
                    }

                    $('#bookedcount').html(msg['bookedcount']);
                    $.clapsss(livecount);
                    console.log('live_fan_count response:', msg);

                    currentAudio.loop = true; // Enable loop for current audio
                    currentAudio.play();
                    
                    // Pause all other audio elements except the current one
                    Object.values(audioElements).forEach(audio => {
                        if (audio !== currentAudio) {
                            audio.pause();
                        }
                    });
                });



                    socket.on('artist_action_graph_count', (msg) => {
                        $.clapsss = function(count) {
                            if (msg['act1'] > 0) {
                                let act1 = Math.min(msg['act1'], 10);
                                let GraphCount1 = (((act1 / 10) * 1.2) * (msg['c11'] / count)) * 100;
                                let GraphCount = Math.min(GraphCount1, 100);

                                document.getElementById("aact1").style.cssText = 'height:' + GraphCount + '%';

                                const stopAllClaps = [
                                    Clap1_1, Clap2_1, Clap3_1, Clap4_1, Clap5_1,
                                    Clap1_2, Clap2_2, Clap3_2
                                ];

                                stopAllClaps.forEach(clap => $.stopAudio(clap));

                                const clapRanges = [
                                    { countRange: [1, 2], actRanges: [[1, 2, Clap1_1], [3, 4, Clap2_1], [5, 6, Clap3_1], [7, 8, Clap4_1], [9, 10, Clap5_1]] },
                                    { countRange: [3, 6], actRanges: [[1, 3, Clap1_2], [4, 7, Clap2_2], [8, 10, Clap3_2]] }
                                ];

                                for (const range of clapRanges) {
                                    const [startCount, endCount] = range.countRange;
                                    const [startAct, endAct, clap] = range.actRanges.find(([start, end]) => msg['c11'] >= startCount && msg['c11'] <= endCount && act1 >= start && act1 <= end) || [];

                                    if (clap) {
                                        $.playAudio(clap);
                                        break;
                                    }
                                }
                            } else {
                                document.getElementById("aact1").style.cssText = `height:0%`;
                            }

                        if(msg['act2'] > 0){
                        	if(msg['act2'] > 10){
                        		act2 = 10;
                        	}else{
                        		act2 = msg['act2'];
                        	}
                        	GraphCount2=(((act2/10)*1.2)*(msg['c12']/count))*100;
                        console.log(GraphCount2);
                        if(GraphCount2 > 100){
                        		GraphCount = 100;
                        	}else{
                        		GraphCount = GraphCount2;
                        	}
                            document.getElementById("aact2").style.cssText = 'height:' + GraphCount +'%';
                        }else{
                            document.getElementById("aact2").style.cssText = `height:0%`;

                    }
                        if(msg['act3'] > 0){
                        	if(msg['act3'] > 10){
                        		act3 = 10;
                        	}else{
                        		act3 = msg['act3'];
                        	}
                        	GraphCount3=(((act3/10)*1.2)*(msg['c13']/count))*100;
                        console.log(GraphCount3);
                        if(GraphCount3 > 100){
                        		GraphCount = 100;
                        	}else{
                        		GraphCount = GraphCount3;
                        	}
                            document.getElementById("aact3").style.cssText = 'height:' + GraphCount +'%';
                        }else{
                            document.getElementById("aact3").style.cssText = `height:0%`;

                    }
                        if(msg['act4'] > 0){
                        	if(msg['act4'] > 10){
                        		act4 = 10;
                        	}else{
                        		act4 = msg['act4'];
                        	}
                        	GraphCount4=(((act4/10)*1.2)*(msg['c14']/count))*100;
                        console.log(GraphCount4);
                        if(GraphCount4 > 100){
                        		GraphCount = 100;
                        	}else{
                        		GraphCount = GraphCount4;
                        	}
                            document.getElementById("aact4").style.cssText = 'height:' + GraphCount +'%';
                        }else{
                            document.getElementById("aact4").style.cssText = `height:0%`;

                    }
                        if(msg['act5'] > 0){
                        	if(msg['act5'] > 10){
                        		act5 = 10;
                        	}else{
                        		act5 = msg['act5'];
                        	}
                        	GraphCount5=(((act5/10)*1.2)*(msg['c15']/count))*100;
                        console.log(GraphCount5);
                        if(GraphCount5 > 100){
                        		GraphCount = 100;
                        	}else{
                        		GraphCount = GraphCount5;
                        	}
                            document.getElementById("aact5").style.cssText = 'height:' + GraphCount +'%';
                        }else{
                            document.getElementById("aact5").style.cssText = `height:0%`;

                    }
                        if(msg['act6'] > 0){
                        	if(msg['act6'] > 10){
                        		act6 = 10;
                        	}else{
                        		act6 = msg['act6'];
                        	}
                        	GraphCount6=(((act6/10)*1.2)*(msg['c16']/count))*100;
                        console.log(GraphCount6);
                        if(GraphCount6 > 100){
                        		GraphCount = 100;
                        	}else{
                        		GraphCount = GraphCount6;
                        	}
                            document.getElementById("aact6").style.cssText = 'height:' + GraphCount +'%';
                        }else{
                            document.getElementById("aact6").style.cssText = `height:0%`;

                    }
                    
                    if(msg['act2'] <= 10 && msg['act2'] > 0){
                                if(count >= 1 && count <= 2 && msg['act2'] >= 1 && msg['act2'] <= 5){
                                    $.stopAudio(boo2);
                                    $.stopAudio(boo3);
                                    $.stopAudio(boo4);
                                    $.stopAudio(boo5);
                                    // var boo = 'boo1';
                                    $.playAudio(boo1);
                                }else if(count >= 1 && count <= 2 && msg['act2'] >= 6 && msg['act2'] <= 10){
                                    $.stopAudio(boo1);
                                    $.stopAudio(boo3);
                                    $.stopAudio(boo4);
                                    $.stopAudio(boo5);
                                    $.playAudio(boo2);
                                }else if(count >= 3 && count <= 6 && msg['act2'] >= 1 && msg['act2'] <= 5){
                                    $.stopAudio(boo2);
                                    $.stopAudio(boo1);
                                    $.stopAudio(boo4);
                                    $.stopAudio(boo5);
                                    $.playAudio(boo3);
                                }else if(count >= 3 && count <= 6 && msg['act2'] >= 6 && msg['act2'] <= 10){
                                    $.stopAudio(boo2);
                                    $.stopAudio(boo3);
                                    $.stopAudio(boo1);
                                    $.stopAudio(boo5);
                                    $.playAudio(boo4);
                                }else{
                                    $.stopAudio(boo2);
                                    $.stopAudio(boo3);
                                    $.stopAudio(boo4);
                                    $.stopAudio(boo1);
                                    $.playAudio(boo5);
                                }
                                // document.getElementById("aact2").style.cssText = `height: calc(${msg['act2'] * 10}% + 0px)`;
                    }
                    if(msg['act3'] <= 10 && msg['act3'] > 0){
                                if(count >= 1 && count <= 2 && msg['act3'] >= 1 && msg['act3'] <= 5){
                                    $.stopAudio(whistle2);
                                    $.stopAudio(whistle3);
                                    $.stopAudio(whistle4);
                                    $.stopAudio(whistle5);
                                    // var whistle = 'whistle1';
                                    $.playAudio(whistle1);
                                }else if(count >= 1 && count <= 2 && msg['act3'] >= 6 && msg['act3'] <= 10){
                                    $.stopAudio(whistle1);
                                    $.stopAudio(whistle3);
                                    $.stopAudio(whistle4);
                                    $.stopAudio(whistle5);
                                    $.playAudio(whistle2);
                                }else if(count >= 3 && count <= 6 && msg['act3'] >= 1 && msg['act3'] <= 5){
                                    $.stopAudio(whistle2);
                                    $.stopAudio(whistle1);
                                    $.stopAudio(whistle4);
                                    $.stopAudio(whistle5);
                                    $.playAudio(whistle3);
                                }else if(count >= 3 && count <= 6 && msg['act3'] >= 6 && msg['act3'] <= 10){
                                    $.stopAudio(whistle2);
                                    $.stopAudio(whistle3);
                                    $.stopAudio(whistle1);
                                    $.stopAudio(whistle5);
                                    $.playAudio(whistle4);
                                }else{
                                    $.stopAudio(whistle2);
                                    $.stopAudio(whistle3);
                                    $.stopAudio(whistle4);
                                    $.stopAudio(whistle1);
                                    $.playAudio(whistle5);
                                }
                        // document.getElementById("aact3").style.cssText = `height: calc(${msg['act3'] * 10}% + 0px)`;
                    }
                    if(msg['act4'] <= 10 && msg['act4'] > 0){
                        $.playAudio(aww1);
                                // if(count >= 1 && count <= 50 && msg['act4'] >= 1 && msg['act4'] <= 2){
                                //     $.stopAudio(aww2);
                                //     $.stopAudio(aww3);
                                //     $.stopAudio(aww4);
                                //     $.stopAudio(aww5);
                                //     // var aww = 'aww1';
                                //     $.playAudio(aww1);
                                // }else if(count >= 1 && count <= 50 && msg['act4'] >= 3 && msg['act4'] <= 4){
                                //     $.stopAudio(aww1);
                                //     $.stopAudio(aww3);
                                //     $.stopAudio(aww4);
                                //     $.stopAudio(aww5);
                                //     $.playAudio(aww2);
                                // }else if(count >= 1 && count <= 50 && msg['act4'] >= 5 && msg['act4'] <= 6){
                                //     $.stopAudio(aww2);
                                //     $.stopAudio(aww1);
                                //     $.stopAudio(aww4);
                                //     $.stopAudio(aww5);
                                //     $.playAudio(aww3);
                                // }else if(count >= 1 && count <= 50 && msg['act4'] >= 7 && msg['act4'] <= 8){
                                //     $.stopAudio(aww2);
                                //     $.stopAudio(aww3);
                                //     $.stopAudio(aww1);
                                //     $.stopAudio(aww5);
                                //     $.playAudio(aww4);
                                // }else{
                                //     $.stopAudio(aww2);
                                //     $.stopAudio(aww3);
                                //     $.stopAudio(aww4);
                                //     $.stopAudio(aww1);
                                //     $.playAudio(aww5);
                                // }
                        // document.getElementById("aact4").style.cssText = `height: calc(${msg['act4'] * 10}% + 0px)`;
                    }
                    if(msg['act5'] <= 10 && msg['act5'] > 0){
                        $.playAudio(cheer1);
                                // if(count >= 1 && count <= 50 && msg['act5'] >= 1 && msg['act5'] <= 2){
                                //     $.stopAudio(cheer2);
                                //     $.stopAudio(cheer3);
                                //     $.stopAudio(cheer4);
                                //     $.stopAudio(cheer5);
                                //     // var cheer = 'cheer1';
                                //     $.playAudio(cheer1);
                                // }else if(count >= 1 && count <= 50 && msg['act5'] >= 3 && msg['act5'] <= 4){
                                //     $.stopAudio(cheer1);
                                //     $.stopAudio(cheer3);
                                //     $.stopAudio(cheer4);
                                //     $.stopAudio(cheer5);
                                //     $.playAudio(cheer2);
                                // }else if(count >= 1 && count <= 50 && msg['act5'] >= 5 && msg['act5'] <= 6){
                                //     $.stopAudio(cheer2);
                                //     $.stopAudio(cheer1);
                                //     $.stopAudio(cheer4);
                                //     $.stopAudio(cheer5);
                                //     $.playAudio(cheer3);
                                // }else if(count >= 1 && count <= 50 && msg['act5'] >= 7 && msg['act5'] <= 8){
                                //     $.stopAudio(cheer2);
                                //     $.stopAudio(cheer3);
                                //     $.stopAudio(cheer1);
                                //     $.stopAudio(cheer5);
                                //     $.playAudio(cheer4);
                                // }else{
                                //     $.stopAudio(cheer2);
                                //     $.stopAudio(cheer3);
                                //     $.stopAudio(cheer4);
                                //     $.stopAudio(cheer1);
                                //     $.playAudio(cheer5);
                                // }
                        // document.getElementById("aact5").style.cssText = `height: calc(${msg['act5'] * 10}% + 0px)`;
                    }
                    if(msg['act6'] <= 10 && msg['act6'] > 0){
                                if(count >= 1 && count <= 2 && msg['act6'] >= 1 && msg['act6'] <= 5){
                                    $.stopAudio(laugh2);
                                    $.stopAudio(laugh3);
                                    $.stopAudio(laugh4);
                                    $.stopAudio(laugh5);
                                    // var laugh = 'laugh1';
                                    $.playAudio(laugh1);
                                }else if(count >= 1 && count <= 2 && msg['act6'] >= 6 && msg['act6'] <= 10){
                                    $.stopAudio(laugh1);
                                    $.stopAudio(laugh3);
                                    $.stopAudio(laugh4);
                                    $.stopAudio(laugh5);
                                    $.playAudio(laugh2);
                                }else if(count >= 3 && count <= 6 && msg['act6'] >= 1 && msg['act6'] <= 5){
                                    $.stopAudio(laugh2);
                                    $.stopAudio(laugh1);
                                    $.stopAudio(laugh4);
                                    $.stopAudio(laugh5);
                                    $.playAudio(laugh3);
                                }else if(count >= 3 && count <= 6 && msg['act6'] >= 6 && msg['act6'] <= 10){
                                    $.stopAudio(laugh2);
                                    $.stopAudio(laugh3);
                                    $.stopAudio(laugh1);
                                    $.stopAudio(laugh5);
                                    $.playAudio(laugh4);
                                }else{
                                    $.stopAudio(laugh2);
                                    $.stopAudio(laugh3);
                                    $.stopAudio(laugh4);
                                    $.stopAudio(laugh1);
                                    $.playAudio(laugh5);
                                }
                        // document.getElementById("aact6").style.cssText = `height: calc(${msg['act6'] * 10}% + 0px)`;
                    }
            
        }
                     
                     
                    
                        $('#actt1').html(msg['actt1']);
                        $('#actt2').html(msg['actt2']);
                        $('#actt3').html(msg['actt3']);
                        $('#actt4').html(msg['actt4']);
                        $('#actt5').html(msg['actt5']);
                        $('#actt6').html(msg['actt6']);
                        console.log('artist_action_graph_count response: ', msg)
                    });
	setInterval(function () {
		document.getElementById("aact1").style.cssText = `height:0%`;
		document.getElementById("aact2").style.cssText = `height:0%`;
		document.getElementById("aact3").style.cssText = `height:0%`;
		document.getElementById("aact4").style.cssText = `height:0%`;
		document.getElementById("aact5").style.cssText = `height:0%`;
		document.getElementById("aact6").style.cssText = `height:0%`;
	}, 6000);
    $.playAudio = function(audiotype) {
                audiotype.play();
            
        }
        
        $.stopAudio = function(audiotype) {
                audiotype.pause();
        }
</script>

@endsection