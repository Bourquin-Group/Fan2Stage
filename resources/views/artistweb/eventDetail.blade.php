@extends('artistweb.layouts.main')
@section('body')
<section class="main_section custom_container">
    <div class="navgat_otherpage">
      <h1 class="task_titlt">
        <span><a href="{{ url('web/artisthome') }}"><img src="{{ asset('assets/web/images/arrow-left.svg') }}" alt="arrow" /></a></span>
        Event Details
      </h1>
      <div class="button_gorup">
        
        <a href="{{ url('web/eventDelete/'.Crypt::encryptString($sc_event['event_id'])) }}"><button>Delete</button></a>
       
        <a href="{{ url('web/eventEdit/'.Crypt::encryptString($sc_event['event_id'])) }}"><button>Edit</button></a>
        
        @if($sc_event['event_status'] == 1)
       {{-- <button><a href="{{url('web/startevent/'.Crypt::encryptString($sc_event['event_id']))}}">Start Event</a></button> --}}
       <button class="startevent">Start Event</button>
       <input type="hidden" name="event_id" value="{{$sc_event['event_id']}}">
       @endif
      </div>
    </div>
    <div class="row">
      <div class="col-lg-7 col-md-12">
        <div class="event_bg_section">
          <div class="event_bg">
            {{-- <div class="imgsection">
              <img src="{{(isset($sc_event['event_image'])) ? $sc_event['event_image']: ''}}" alt="" />
            </div> --}}
            {{-- ----------------------------------------------------------- --}}
            <?php
              $images = explode(',',$sc_event['event_image']);
            ?>
            @foreach($images as $value)
            <div class="mySlides imgsection">
              <img src="{{(isset($value)) ? url('').'/eventimages/'.$value: ''}}">
            </div>
            @endforeach
            {{-- ----------------------------------------------------------- --}}
            {{-- <div class="img_thumline">
              <span class="thum_img"
                ><img src="{{(isset($sc_event['event_image'])) ? $sc_event['event_image']: ''}}" alt=""
              /></span>
              <span><img src="{{(isset($sc_event['event_image'])) ? $sc_event['event_image']: ''}}" alt="" /></span>
              <span><img src="{{(isset($sc_event['event_image'])) ? $sc_event['event_image']: ''}}" alt="" /></span>
            </div> --}}

            {{-- ----------------------------------------------------------- --}}
            <div class="img_thumline mb-4" style="margin-bottom:77px !important"><?php 
            $id = 1;
            
              foreach($images as $value){
              ?>
              <span class="thum_img"><img class="demo cursor" src="{{(isset($sc_event['event_image'])) ? url('').'/eventimages/'.$value : ''}}" onclick="currentSlide({{$id}})" ></span>
              <?php
              $id++;
              }
              ?>
              {{-- <img class="demo cursor" src="{{(isset($sc_event['event_image'])) ? $sc_event['event_image']: ''}}" style="width:10%" onclick="currentSlide($id)" > --}}
            </div>
            {{-- ----------------------------------------------------------- --}}

          </div>
          <div class="event_booking_list">
            <p>
              {{$booked}} Fans Booked this Event
              <span ><a href="{{ url('web/fanslist/'.base64_encode($sc_event['event_id'])) }}" class="view-link">View</a><a href="{{route('subscription')}}" class="view-link">Upgrade Plans</a></span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-12">
        <div class="event_formsection">
          <form class=" ">
            <div class="form-section">
              <label for="">Event Title</label>
              <span>{{(isset($sc_event['event_title'])) ? $sc_event['event_title']: ''}}</span>
            </div>

            <div class="event_innersection">
              <div class="form-section">
                <label for="">Event Date</label>
                <span>{{(isset($sc_event['event_date'])) ? date('d F Y', strtotime($sc_event['event_date'])): ''}}</span>
              </div>

              <div class="form-section">
                <label for="">Event Time</label>
                <span>{{(isset($sc_event['event_time'])) ? date("g:i A", strtotime($sc_event['event_time']." UTC")): ''}}</span>
              </div>

              <div class="form-section">
                <label for="">Duration</label>
                <span>{{(isset($sc_event['event_duration'])) ? $sc_event['event_duration']: ''}}</span>
              </div>

              <div class="form-section">
                <label for="">Time Zone</label>
                <span>{{(isset($sc_event['event_timezone'])) ? $sc_event['event_timezone']: ''}}</span>
              </div>

              <div class="form-section">
                <label for="">Genre</label>
                <span>{{(isset($sc_event['event_genre'])) ? $sc_event['event_genre']: ''}}</span>
              </div>

              <div class="form-section ">
                <label for="">Stream Link</label>
                  <div class="cpy-sec">
                    <span class="edit-text">{{(isset($sc_event['link_to_event_stream'])) ? $sc_event['link_to_event_stream']: ''}}</span>
                    <img src="{{ asset('assets/web/images/copy_icon.svg') }}" alt="" srcset="">

                  </div>
                
              </div>
              <div class="form-section ">
                <label for="">Event Amount</label>
                  <div class="cpy-sec">
                    <span class="edit-text">{{(isset($sc_event['eventamount'])) ? $sc_event['eventamount']: ''}}</span>

                  </div>
                
              </div>
            </div>

            <div class="form-section m-0">
              <label for="">Description</label>
              <span>
                {{(isset($sc_event['event_description'])) ? $sc_event['event_description']: ''}}
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
</section>
@endsection

@section('eventdetail')
<script>
  var slideIndex = 1;
  showSlides(slideIndex);
  
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }
  
  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    captionText.innerHTML = dots[slideIndex-1].alt;
  }
  </script>

  <script>
    $(document).ready(function(){
      $(document).on("click", ".startevent", function (e) {
        var event_id = $("input[name=event_id]").val();
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: "{{route('startevent') }}",
             
                type: 'POST',
                data: {'event_id':event_id},
                success: function (data) {
                  if (data.success === false) {
                    if(data.flag == 1){
                      Swal.fire({
                            title: 'Another Event is on Live, you are sure want to end that Event and start this Event?',
                            showDenyButton: true,
                            confirmButtonText: 'Yes',
                          }).then((result) => {
                            if (result.isConfirmed) {
                              $.ajax({
                                    headers: {
                                        'X-CSRF-Token': '{{ csrf_token() }}',
                                    },
                                    url: "{{route('startendevent') }}",
                                
                                    type: 'POST',
                                    data: {'event_id':event_id},
                                    success: function (data) {
                                      if (data.success === true) {
                                              window.location.href = "{{ url('/web/artiststartevent/') }}"+"/"+data.event_id;
                                            }
                                    }
                                  });
                            }
                          })
                    }else{
                      swal.fire(data.message,"error");
                    }
                  }else{
                    window.location.href = "{{ url('/web/artiststartevent/') }}"+"/"+data.event_id;
                  }
                }
            });
        });

    });
  </script>
@endsection