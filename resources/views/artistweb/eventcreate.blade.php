@extends('artistweb.layouts.main')
@section('body')
<section class="main_section custom_container">
  <div class="navgat_otherpage">
      <h1 class="task_titlt"><span><a href="{{url()->previous()}}"><img src="{{ asset('assets/web/images/arrow-left.svg') }}" alt="arrow"></a></span>Create New Event</h1>
      
      <span class="error_msg" id="main_msg" style="margin-left:10%;font-size:20px;color:red"></span>
      
      <div class="button_gorup" style="display:flex">
        <a href="{{url('web/artisthome')}}"><button>CANCEL</button></a>
        <form method="post" id="forms" enctype="multipart/form-data">
          @csrf
          @method("POST")
          {{-- <button type="submit">create</button> --}}
          <button id="upload" value="Upload" type="button">CREATE</button>
      </div>
  </div>
<div class="row ">
  <div class="col-lg-7 col-md-12 ">
    <div class="event_bg">
      <div class="imgsection">
        <!-- <img src="./assets/images/event_bg.png" alt=""> -->
        <div class="drop-zone">
          <div class="drop-zone__prompt">
            <div class="prompt-button">
              <input id="avatar" class="prompt-input" type="file" name="avatar[]" value="browse" accept=".jfif,.jpg,.jpeg,.png,.gif" multiple hidden />
              <label for="avatar">browse</label>
              {{-- <span>browse</span> --}}

              {{-- <input type="file" id="upload" hidden>
		<label for="upload">file</label> --}}
            </div>
              {{-- <button class="">browse</button> --}}
            </div>
            {{-- <input id="avatar" type="file" name="avatar[]" accept=".jfif,.jpg,.jpeg,.png,.gif" multiple /> --}}
          {{-- -------------------------------------------------------------------------- --}}
          {{-- <input type="file" name="event_image" class="drop-zone__input"> --}}
           {{-- <input id='files' name="event_image[]" type="file"
          accept=".jfif,.jpg,.jpeg,.png,.gif" class="drop-zone_or"  multiple> --}}
          
          {{-- <input id='files' type='file' name="event_image[]" multiple/> --}}
          {{-- -------------------------------------------------------------------------- --}}
          {{-- <div class="upload__box">
            <div class="upload__btn-box">
              <label class="upload__btn">
                <p>Upload images</p>
                <input type="file" multiple="" data-max_length="20" class="upload__inputfile">
              </label>
            </div>
            
          </div> --}}
          {{-- -------------------------------------------------------------------------- --}}

      </div>
      </div>
          <span class="error_msg" id="event_image"></span>
      <p class="create_event_img">Upload Your Event Images </p>
       <div class="img_thumline">
        {{-- <div class="images-preview-div"> </div> --}}
        {{-- <output id='result' style="display:flex">    --}}
          {{-- <div class="previews" style="display:flex">
          </div> --}}
        {{-- <div id="divImageMediaPreview"></div>   1--}}
      </div>
    </div>
    <!-- <div class="event_booking_list">
      <p>270 Fans Booked this Event <span><a href="#">Upgrade Plans</a></span></p>
    </div> -->

  </div>
  <div class="col-lg-5 col-md-12">
    <div class="event_formsection">
          <div class="form-section">
            <label for="">Event Title*</label>
            <input type="text" placeholder="Type Event Title" name="event_title" value="{{ old('event_title') }}">
            @if(old('event_title') == '')
            <span class="error_msg" id="eventtitle1"></span>
            @endif
          </div>
          
          <div class="event_innersection">
            <div class="form-section">
              <label for="">Event Date*</label>
              <input type="date" placeholder="Select Date" id="theDate" value="Select Date" name="event_date" value="{{ old('event_date') }}">
              <span class="error_msg" id="event_date1"></span>
            </div>
            
            <div class="form-section">
              <label for="">Event Time*</label>
              <input type="time" name="event_time" id="event_time">
              <span class="error_msg" id="event_time1"></span>
            </div>
            
            <div class="form-section">
              <label for="">Duration*</label>
              <select name="event_duration" id="event_duration">
                <option value="">Select Duration</option>
                <?php 
                $timer = "60,120,180";
                        $durations = explode(',',$timer);?>
                @forEach($eventduration as $value)
                <option value="{{$value->duration}}" @if (old('event_duration') == $value->duration) {{ 'selected' }} @endif>{{($value->duration)}} {{(in_array($value->duration, $durations)) ? 'Hour' : 'Mins'}}</option>
                    @endforeach
              </select>
              <span class="error_msg" id="event_duration1"></span>
            </div>
            
            <div class="form-section">
              <label for="">Time Zone*</label>
              <input type="text" name="event_timezone" id="event_timezone" style="background-color: #80808099" value="{{$a_profile['timezone']['timezone']}}" readonly>
              <span class="modify_timezone_text">Please change Timezone in profile for a different Timezone event.</span>
              {{-- <select name="event_timezone" id="event_timezone">
                <option value="">Select Time Zone</option>
                @forEach($timezone as $value)
                    <option value="{{$value->timezone}}" @if (old('event_timezone') == $value->timezone) {{ 'selected' }} @endif >{{$value->timezone}}</option>
                    @endforeach
              </select> --}}
              <span class="error_msg" id="event_timezone1"></span>
            </div>
            
            <div class="form-section">
              <label for="">Genre*</label>
                <div class="genere_sec">
              <select class="selectpicker" name="genre[]" id="genre" placeholder="Select genre" multiple>
                @forEach($genre as $value)
                    <option value="{{$value->genre1}}">{{$value->genre1}}</option>
                    @endforeach
              </select>
            </div>
              <span class="error_msg" id="genre1"></span>
            </div>
            
            <div class="form-section">
              <label for="">Stream Link*</label>
              <input type="url" placeholder="Paste stream Link here" name="link_to_event_stream" value="{{ old('link_to_event_stream') }}">
            <span class="error_msg streamurl" id="link_to_event_stream1"></span>
            <span class="error_msg" id="streamurl"></span>
            </div>
            <div class="form-section">
              <label for="">Amount</label>
              <input type="url" placeholder="Amount In Dollar" name="eventamount" value="{{ old('eventamount') }}" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
            <span class="error_msg" id="eventamount1"></span>
            </div>
            
          </div>

          <div class="form-section m-0">
            <label for="">Description*</label>
            <textarea name="event_description" class="font-15" id="event_description" placeholder="Type Description" spellcheck="false" value="{{ old('event_description') }}"></textarea>
          </div>
            <span class="error_msg" id="event_description1"></span>
      </form>
    </div>

  </div>
</div>


</section>
@endsection

@section('eventdetail')
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
$(document).ready(function () {

 
  var form_data = new FormData();
        var number = 0;

        // / WHEN YOU UPLOAD ONE OR MULTIPLE FILES /
        $(document).on('change', '#avatar', function () {
            len_files = $("#avatar").prop("files").length;
            for (var i = 0; i < len_files; i++) {
                var file_data = $("#avatar").prop("files")[i];
         
                form_data.append('file'+number,file_data);
                form_data.append('file_name'+number,file_data.name);
                number++;
                var construc = '<span class="thum_img"><img class="demo cursor active" src="' +
                    window.URL.createObjectURL(file_data) + '" alt="' + file_data.name + '" /></span>';
                $('.img_thumline').append(construc);
            }
        });
       
        // / UPLOAD CLICK /
        $(document).on("click", "#upload", function (e) {
          form_data.append('number',number);

          var name = $("input[name=event_title]").val();
          form_data.append('event_title', name);
          var date = $("input[name=event_date]").val();
          form_data.append('event_date', date);
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

          
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: "{{route('eventStore') }}",
             
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
                // location.reload();
                window.location.href = "artisthome";
               }
              
                
                },
                error:function(data){
                  
                  var error_msg  = JSON.parse(data['responseText']);
                  
                  if(error_msg['message'] && error_msg['message'].length > 0){
                    var event_image_error  = error_msg['message'];
                    $('#main_msg').html(event_image_error);
                  }
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