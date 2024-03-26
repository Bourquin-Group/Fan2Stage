@extends('artistweb.layouts.main')
@section('body')
<section class="main_section custom_container">
    <div class="navgat_otherpage">
        <h1 class="task_titlt"><span><a href=""><img src="{{ asset('assets/web/images/arrow-left.svg') }}" alt="arrow"></a></span> Event Details</h1>
        <div class="button_gorup">
          <form method="post" id="forms" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <button><a href="{{url()->previous()}}">Cancel</a> </button>
           <button id="update"> Save</button>
        </div>
    </div>
  <div class="row ">
    <div class="col-lg-7 col-md-12">
     <div class="event_bg_section">
      <div class="event_bg">
        <div class="imgsection">
            <?php
            $images = explode(',',$edit_event['event_image']);
          ?>
          @foreach($images as $value)
          <div class="mySlides">
            <img src="{{(isset($value)) ? url('').'/eventimages/'.$value: ''}}">
          </div>
          @endforeach
          <div class="hover_section_event">
            <div class="content_section">
              <div class="btn-align"><span class="edit_img_button" id="deleteimg"><img src="{{ asset('assets/web/images/remove_icon.svg') }}" alt=""></span><span class="font-18">Remove</span></div>
              <div class="btn-align"><span class="edit_img_button"><a class="next" onclick="plusSlides(1)"><img src="{{ asset('assets/web/images/img_change.svg') }}" alt=""></a></span><span class="font-18">Change</span></div>
            </div>
          </div>
          
        </div>
        <span class="error_msg" id="event_image"></span>
        <div class="img_thumline mb-4" style="margin-bottom:77px !important">
          <?php 
            $id = 1;
              foreach($images as $value){
              ?>
              <span class="thum_img" id="thum_img"><img class="demo cursor" src="{{(isset($edit_event['event_image'])) ? url('').'/eventimages/'.$value : ''}}" onclick="currentSlide({{$id}})" ><input type="hidden" name="oldimg[]" id="oldimg{{$id}}" value="{{$value}}"></span>
              
              <?php
              $id++;
              }
              ?>
              {{-- <div class="preview" style="display:flex"></div> --}}
              <span class="img_adding"><label for="avatar"><input id="avatar" type="file" name="avatar[]" accept=".jfif,.jpg,.jpeg,.png,.gif" multiple /></span>
              {{-- <div class="thum_img img_adding active"></div> --}}
        </div>
        
        {{-- <div class="check-box-section event-cus-check">
          <input type="checkbox" name="thumb_check" id="cus-box">
          <label class="font-16" for="cus-box ">Set as Thumbnail</label>
      </div> --}}
      </div>
      <div class="event_booking_list">
        <p><b>270</b> Fans Booked this Event <span ><a href="#" class="view-link">View</a><a href="#" class="view-link">Upgrade Plans</a></span></p>
      </div>
     </div>

    </div>
    <div class="col-lg-5 col-md-12">
      <div class="event_formsection">
            <div class="form-section">
              <label for="">Event Title</label>
              <input type="text" placeholder="" name="event_title" value="{{(isset($edit_event['event_title'])) ? $edit_event['event_title']: ''}}">
              <input type="hidden" name="id" value="{{$edit_event['event_id']}}">
              <span class="error_msg" id="eventtitle1"></span>
            </div>

        <div class="event_innersection">
          <div class="form-section">
            <label for="">Event Date</label>
            <input type="date" placeholder="21 Jan 2023" id="theDates"name="event_date" value="{{ date_format(date_create($edit_event['event_date']), 'Y-m-d') }}">
            <span class="error_msg" id="event_date1"></span>
          </div>
      
          <div class="form-section">
            <label for="">Event Time</label>
            <input type="time" name="event_time" id="event_time" value="{{date('H:i', strtotime($edit_event['event_time']))}}">
            <span class="error_msg" id="event_time1"></span>
          </div>

          <div class="form-section">
            <label for="">Duration</label>
            <select name="event_duration" id="event_duration">
              <?php 
                $timer = "60,120,180";
                        $durations = explode(',',$timer);?>
              @forEach($eventduration as $value)
              <option value="{{$value->duration}}" {{($edit_event['event_duration'] == $value->duration) ? 'Selected' : ''}}>{{($value->duration)}} {{(in_array($value->duration, $durations)) ? 'Hour' : 'Mins'}}</option>
                        @endforeach
            </select>
            <span class="error_msg" id="event_duration1"></span>
          </div>

          <div class="form-section">
            <label for="">Time Zone</label>
            <input type="text" name="event_timezone" id="event_timezone" value="{{$a_profile['timezone']['timezone']}}" readonly>
            {{-- <select name="event_timezone" id="event_timezone">
              @forEach($timezone as $value)
              <option value="PST" {{($edit_event['event_timezone'] == $value->timezone)   ? 'Selected' : ''}}>{{$value->timezone}}</option>
                        @endforeach
            </select> --}}
            <span class="error_msg" id="event_timezone1"></span>
          </div>

          <div class="form-section">
            <label for="">Genre</label>
            <div class="genere_sec">
              <select name="genre" id="genre"> {{-- class="selectpicker" name="genre[]" multiple --}}
                <option value="">Select Genre</option>
                <?php 
                        $genre = explode(',',$edit_event['event_genre']);?>
                        @forEach($genres as $value)
                        <option value="{{$value->genre1}}" {{(in_array($value->genre1, $genre)) ? 'selected' : ''}}>{{$value->genre1}}</option>
                        @endforeach
              </select>
              <span class="error_msg" id="genre1"></span>
            </div>
          </div>
          <div class="form-section">
            <label for="">Stream Link</label>
            <div class="cpy-sec  url_icon">
            <div class="copy-input">
              <input type="text" name="link_to_event_stream" id="" value="{{(isset($edit_event['link_to_event_stream'])) ? $edit_event['link_to_event_stream']: ''}}">
              <img src="{{ asset('assets/web/images/copy_icon.svg') }}" alt="" srcset="">
            </div> 
          </div>
          <span class="error_msg streamurl" id="link_to_event_stream1"></span>
            <span class="error_msg" id="streamurl"></span>
          </div>
          <div class="form-section">
            <label for="">Event Amount</label>
            <div class="cpy-sec  url_icon">
            <div class="copy-input">
              <input type="text" name="eventamount" id="" value="{{(isset($edit_event['eventamount'])) ? $edit_event['eventamount']: ''}}">
              <span class="error_msg" id="eventamount1"></span>
            </div> 
          </div>
          </div>
        </div>
            
            <div class="form-section m-0">
              <label for="">Description</label>
              <textarea name="event_description" id="event_description" >{{(isset($edit_event['event_description'])) ? $edit_event['event_description']: ''}}
              </textarea>
            </div>
            <span class="error_msg" id="event_description1"></span>
         

        </form>
      </div>

    </div>
  </div>
</section>
@endsection
@section('eventedit')
<script>
  var date = new Date();

var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();

if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;

var today = year + "-" + month + "-" + day;


document.getElementById('theDate').value = today;
</script>
<script>
  var slideIndex = 1;
  showSlides(slideIndex);
  
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }
  
  var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
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

  $(document).ready(function () {
var form_data = new FormData();
      var number = 0;
      
      
      // / WHEN YOU UPLOAD ONE OR MULTIPLE FILES /
      $(document).on('change', '#avatar', function () {
        // span count
        var spancount = $('.img_thumline #thum_img').children().length;
        var totalspan = spancount+1;
        // span count
          console.log($("#avatar").prop("files").length);
          len_files = $("#avatar").prop("files").length;
          for (var i = 0; i < len_files; i++) {
              var file_data = $("#avatar").prop("files")[i];
       
              form_data.append('file'+number,file_data);
              form_data.append('file_name'+number,file_data.name);
              number++;
              var construc = '<span class="thum_img" id="thum_img"><img  class="demo cursor" src="' +
                  window.URL.createObjectURL(file_data) + '" alt="' + file_data.name + '" onclick="currentSlide('+totalspan+')" /></span>';
              $('.img_thumline .img_adding:last').before(construc);

              var construct = '<div class="mySlides" style="display:none"><img src="' +
                  window.URL.createObjectURL(file_data) + '"/></div>';
              $('.imgsection .hover_section_event:last').before(construct);
          }
         console.log(form_data);
      });
    //    // / WHEN YOU CLICK ON THE IMG IN ORDER TO DELETE IT /
    //    $(document).on('click', 'img', function () {

    //     var filename = $(this).attr('alt');
    //     var newfilename = filename.replace(/\./gi, "_");
    //     form_data.delete($(this).attr('alt'))
    //     $(this).remove()

    //     });
           
    $("#deleteimg").click(function() {
            $(".thum_img .active").parent().remove();
          });
          
      // / UPLOAD CLICK /
      $(document).on("click", "#update", function (e) {
        // ==============================
         var values = $('input[name="oldimg[]"]').map(function(){
                      return this.value;
                    }).get();
      // ====================================================
      form_data.append('number',number);
      form_data.append('oldimg',values);

          var name = $("input[name=event_title]").val();
          form_data.append('event_title', name);
          
          
          var date = $("input[name=event_date]").val();
          form_data.append('event_date', date);
          var oldimg = $("input[name=oldimg]").val();
          form_data.append('event_oldimg', oldimg);
          var time = $("#event_time").val();
          form_data.append('event_time', time);
          var duration = $("#event_duration").val();
          form_data.append('event_duration', duration);
          var timezone = $("#event_timezone").val();
          form_data.append('event_timezone', timezone);
          var genres = $("#genre").val();
          form_data.append('genre', genres);
          var link = $("input[name=link_to_event_stream]").val();
          form_data.append('link_to_event_stream', link);
          var eventamount = $("input[name=eventamount]").val();
          form_data.append('eventamount', eventamount);
          var description = $("#event_description").val();
          form_data.append('event_description', description);
          var id = $("input[name=id]").val();
          var url = "{{ route('eventUpdate', ":id") }}";
          url = url.replace(':id', id);

          
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: url,
             
                type: 'POST',
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, // Setting the data attribute of ajax with form_data
                success: function (data) {
                  var error_msg  = JSON.parse(data);
               if(error_msg['status'] == 0){
                var error_msg1  = error_msg['message'];
                var error_msg2  = error_msg['flag'];
                if(error_msg2 && error_msg2 == 1){
                  var event_validate_error  = error_msg1;
                  if(event_validate_error == 'Invalid Url'){
                    $('#link_to_event_stream1').css('display','none');
                    $('#streamurl').css('display','block');
                    $('#streamurl').html(event_validate_error);
                  }else{
                    $('#main_msg').html(event_validate_error);
                  }
                  
                }else{
                  $('#main_msg').html('');
                }

                if(error_msg1['number'] && error_msg1['number'].length > 0){
                  var event_image_error  = error_msg1['number'][0];
                  $('#event_image').html(event_image_error);
                }else{
                  $('#event_image').html('');
                }
                if(error_msg1['event_title'] && error_msg1['event_title'].length > 0){
                  var event_title_error  = error_msg1['event_title'][0];
                  $('#eventtitle1').html(event_title_error);
                }else{
                  $('#eventtitle1').html('');
                }
                if(error_msg1['event_date'] && error_msg1['event_date'].length > 0){
                  var event_date_error  = error_msg1['event_date'][0];
                  $('#event_date1').html(event_date_error);
                }else{
                  $('#event_date1').html('');
                }
                if(error_msg1['event_time'] && error_msg1['event_time'].length > 0){
                  var event_time_error  = error_msg1['event_time'][0];
                  $('#event_time1').html(event_time_error);
                }else{
                  $('#event_time1').html('');
                }
                if(error_msg1['event_duration'] && error_msg1['event_duration'].length > 0){
                  var event_duration_error  = error_msg1['event_duration'][0];
                  $('#event_duration1').html(event_duration_error);
                }else{
                  $('#event_duration1').html('');
                }
                if(error_msg1['event_timezone'] && error_msg1['event_timezone'].length > 0){
                  var event_timezone_error  = error_msg1['event_timezone'][0];
                  $('#event_timezone1').html(event_timezone_error);
                }else{
                  $('#event_timezone1').html('');
                }
                if(error_msg1['genre'] && error_msg1['genre'].length > 0){
                  var genre_error  = error_msg1['genre'][0];
                  $('#genre1').html(genre_error);
                }else{
                  $('#genre1').html('');
                }
                if(error_msg1['link_to_event_stream'] && error_msg1['link_to_event_stream'].length > 0){
                  var link_to_event_stream_error  = error_msg1['link_to_event_stream'][0];
                  $('#streamurl').css('display','none');
                  $('#link_to_event_stream1').css('display','block');
                  $('#link_to_event_stream1').html(link_to_event_stream_error);
                }else{
                  $('#link_to_event_stream1').html('');
                }
                if(error_msg1['eventamount'] && error_msg1['eventamount'].length > 0){
                  var eventamount_error  = error_msg1['eventamount'][0];
                  $('#eventamount1').html(eventamount_error);
                }else{
                  $('#eventamount1').html('');
                }
                if(error_msg1['event_description'] && error_msg1['event_description'].length > 0){
                  var event_description_error  = error_msg1['event_description'][0];
                  $('#event_description1').html(event_description_error);
                }else{
                  $('#event_description1').html('');
                }

               }else{
                window.location.href = "{{ url('web/artisthome') }}";
                  localStorage.setItem("eventupdate","Event Updated Successfully");
               }
                  // console.log(data);
                  // window.location.href = "{{ url('web/artisthome') }}";
                  // localStorage.setItem("eventupdate","Event Updated Successfully");
                  // location.reload();
                },
                error:function(data){
                  console.log('vimal',data);
                  var error_msg  = JSON.parse(data['responseText']);
                  console.log(error_msg['event_duration'][0]);
                  if(error_msg['number'] && error_msg['number'].length > 0){
                    var event_image_error  = error_msg['number'][0];
                    $('#event_image').html(event_image_error);
                  }
                  if(error_msg['event_title'] && error_msg['event_title'].length > 0){
                    var event_title_error  = error_msg['event_title'][0];
                    $('#eventtitle1').html(event_title_error);
                  }
                  if(error_msg['event_date'] && error_msg['event_date'].length > 0){
                    var event_date_error  = error_msg['event_date'][0];
                    $('#event_date1').html(event_date_error);
                  }
                  if(error_msg['event_time'] && error_msg['event_time'].length > 0){
                    var event_time_error  = error_msg['event_time'][0];
                    $('#event_time1').html(event_time_error);
                  }
                  if(error_msg['event_duration'] && error_msg['event_duration'].length > 0){
                    var event_duration_error  = error_msg['event_duration'][0];
                    $('#event_duration1').html(event_duration_error);
                  }
                  if(error_msg['event_timezone'] && error_msg['event_timezone'].length > 0){
                    var event_timezone_error  = error_msg['event_timezone'][0];
                    $('#event_timezone1').html(event_timezone_error);
                  }
                  if(error_msg['genre'] && error_msg['genre'].length > 0){
                    var genre_error  = error_msg['genre'][0];
                    $('#genre1').html(genre_error);
                  }
                  if(error_msg['link_to_event_stream'] && error_msg['link_to_event_stream'].length > 0){
                    var link_to_event_stream_error  = error_msg['link_to_event_stream'][0];
                    $('#streamurl').css('display','none');
                    $('#link_to_event_stream1').css('display','block');
                    $('#link_to_event_stream1').html(link_to_event_stream_error);
                  }
                  if(error_msg['event_description'] && error_msg['event_description'].length > 0){
                    var event_description_error  = error_msg['event_description'][0];
                    $('#event_description1').html(event_description_error);
                  }
                  
                }
            });
        });
  });
  </script>
@endsection