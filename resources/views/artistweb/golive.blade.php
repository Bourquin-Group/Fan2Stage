@extends('artistweb.layouts.main')
@section('body')
<section class="main_section custom_container">
    <div class="navgat_otherpage">
      <h1 class="task_titlt"><a href="{{url()->previous()}}"><span><img src="{{asset('/assets/fan/images/arrow-left.svg')}}" alt="arrow"></span></a> {{ucfirst(trans($sc_event['event_title']))}}</h1>
      <div class="button_gorup">
         <a href="{{url('web/golive/'.Crypt::encryptString($sc_event['event_id']))}}"> <button>Go live</button></a> 
      </div>
  </div>
    <div class="row ">
        <input type="hidden" name="event_id" id="event_id" value="{{$sc_event['event_id']}}">
        <input type="hidden" name="user_id" id="user_id" value="{{isset(auth()->user()->id) ? auth()->user()->id : ''}}">
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
                      <h2><span id="livecount"></span></h2>
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
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" value="30"/>
                  <div class="range-slider__bar"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/clap-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  <div class="range-slider__bar theme1"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/boo-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live">
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  <div class="range-slider__bar theme2"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/party-svg.svg')}}" alt=""></div></div>
      
              <div class="main_live"> 
              <div class="range-slider" data-slider-value="70">
                  <input type="range" orient="vertical" min="0" max="100" value="20" />
                  <div class="range-slider__bar theme3"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/music-svg.svg')}}" alt=""></div></div>
              <div class="main_live">
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" />
                  <div class="range-slider__bar theme2"></div>
                  <div class="range-slider__thumb"></div>
              </div>
              <div class="emog_section"><img src="{{asset('/assets/web/images/surprised-svg .svg')}}" alt=""></div></div>
      
              <div class="main_live">
              <div class="range-slider">
                  <input type="range" orient="vertical" min="0" max="100" value="20" />
                  <div class="range-slider__bar theme3"></div>
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
     // socket script
     var socket = io.connect("https://live-stream.f2s.live");
    //  var socket = io.connect("http://127.0.0.1:7002");
    //  var socket = io.connect("https://fan2stage-live.colanapps.in");
                    
                    signIn();
                        
                    function signIn() {
                        var event_id = $('#event_id').val();
                        var userid = $('#user_id').val();
                        // const event_id = 1;
                        // const userid = 43;
    
                        // const eventAndUser = prompt("Enter Event Id, User_id as comma separated values");
                        // const values = eventAndUser.split(",");
                        // if (values.length < 2) {
                        //     alert('Enter Event Id and User Id');
                        //     return;
                        // }
    
                        socket.emit('join-event', { event: event_id, user_id: userid });
                    }
    
                    socket.on('joining-confirmation', (msg) => {
                        // will receive the socket idfor the user;
                        console.log('My Socket Id: ', msg)
                    });
    
                    socket.on('live_fan_count', (msg) => {
                        $('#livecount').html(msg['livecount']);
                        $('#bookedcount').html(msg['bookedcount']);
                        console.log('live_fan_count response: ', msg)
                    });
                    socket.on('artist_action_graph_count', (msg) => {
                        console.log('artist_action_graph_count response: ', msg)
                    });
                    // socket.on('action_graph_count', (msg) => {
                    //     // console.log()
                    //     $('#livecount').html(msg['livecount']);
                    //     console.log('action_graph_count response: ', msg);
                    // });
    
                   
               // socket script
    // $(document).ready(function(){
    //     var ajax_call = function() {
    //         var id = $('#event_id').val();
    //         var url = "/web/livefancount/"+id;
        
    //         $.ajax({
    //             type: "GET",
    //             url: url,
    //             success: function (data) {
    //                 if(data['livecount'] && data['livecount'] != ''){
    //                     $('#livecount').html(data['livecount']);
    //                 }else{
    //                     $('#livecount').html('0');
    //                 }
    //                 if(data['bookedcount'] && data['bookedcount'] != ''){
    //                     $('#bookedcount').html(data['bookedcount']);
    //                 }else{
    //                     $('#bookedcount').html('0');
    //                 }
    //             },
    //             error: function (data) {
    //                 console.log('Error:', data);
    //             }
    //         });
    //         };

    //     var interval = 1000 * 60 * 1; 
    //     ajax_call();
    //     setInterval(ajax_call, interval); 
    // });
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