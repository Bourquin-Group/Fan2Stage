@extends('admin.layouts.master')

@section('content')
<style>
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    
    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 2px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    input:checked + .slider {
      background-color: #2196F3;
    }
    
    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }
    
    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
          width: 60px;
        height: 30px;
    }
    
    .slider.round:before {
      border-radius: 50%;
    }
    </style>
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Event Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Event
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add Introductory</h4> -->
                   <span class="error_msg" id="main_msg" style="margin-left:37%;font-size:20px;color:red"></span>
                    <div class="form-group row">
                      <label for="title" class="col-sm-2 text-end control-label col-form-label">Event Title</label>
                      <div class="col-sm-5">
                        <input name="event_title" value="{{ ($edit_event)? (old('event_title')? old('event_title') : $edit_event['event_title']) : old('event_title') }}" type="text" class="form-control @error('event_title') is-invalid @enderror"
                          id="title"
                          placeholder="Enter Your Event Title"
                        />
                        <input type="hidden" name="id" value="{{$edit_event['event_id']}}">
                        <span class="invalid-feedback" style="color:red" id="eventtitle1"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="theDate" class="col-sm-2 text-end control-label col-form-label">Event Dates</label>
                      <div class="col-sm-5">
                        <input name="event_date" value="{{\Illuminate\Support\Carbon::parse($edit_event['event_date'])->format("d-m-Y")}}" type="date" class="form-control" @error('event_date') is-invalid @enderror
                          id="theDate1"
                        />
                        <span class="invalid-feedback" id="event_date1"></span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="time" class="col-sm-2 text-end control-label col-form-label">Event Time</label>
                      <div class="col-sm-5">
                        <select class="form-control" name="event_time" id="event_time">
                            <option value="11 AM"{{(isset($edit_event['event_time'])  == '11 AM') ? 'Selected' : ''}}>11 AM</option>
                            <option value="12 AM" {{(isset($edit_event['event_time'])  == '12 AM') ? 'Selected' : ''}}>12 AM</option>
                            <option value="10 PM" {{(isset($edit_event['event_time'])  == '10 PM') ? 'Selected' : ''}}>10 PM</option>
                        </select>
                        <span class="invalid-feedback" id="event_time1"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="duration" class="col-sm-2 text-end control-label col-form-label">Event Duration</label>
                      <div class="col-sm-5">
                        <select class="form-control" name="event_duration" id="event_duration">
                            <option value="120 Mins" {{($edit_event['event_duration'] == '120 Mins') ? 'Selected' : ''}}>120 Mins</option>
                            <option value="60 Mins" {{($edit_event['event_duration'] == '60 Mins') ? 'Selected' : ''}}>60 Mins</option>
                        </select>
                        <span class="invalid-feedback" id="event_duration1"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="time" class="col-sm-2 text-end control-label col-form-label">Time Zone</label>
                      <div class="col-sm-5">
                        <select class="form-control" name="event_timezone" id="event_timezone">
                            <option value="PST" {{($edit_event['event_timezone'] == 'PST')   ? 'Selected' : ''}}>PST</option>
                            <option value="IST" {{($edit_event['event_timezone'] == 'IST')   ? 'Selected' : ''}}>IST</option>
                        </select>
                        <span class="invalid-feedback" id="event_timezone1"></span>
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="event_link" class="col-sm-2 text-end control-label col-form-label">Stream Link</label>
                        <div class="col-sm-5">
                          <input name="link_to_event_stream" value="{{ ($edit_event)? (old('link_to_event_stream')? old('link_to_event_stream') : $edit_event['link_to_event_stream']) : old('link_to_event_stream') }}" type="text" class="form-control @error('link_to_event_stream') is-invalid @enderror"
                            id="event_link"
                            placeholder="Enter Your Event Link"
                          />
                          <span class="invalid-feedback" id="link_to_event_stream1"></span>
                        </div>
                      </div>

                      <div class="form-group row">
                      <label
                        for="description"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Event Description</label
                      >
                      <div class="col-sm-5">
                       <textarea name="event_description" id="event_description" rows="4" cols="50" class="form-control @error('event_description') is-invalid @enderror" placeholder="Enter Your Description">{{ ($edit_event)? (old('event_description')? old('event_description') : $edit_event['event_description']) : old('event_description') }}</textarea>
                      
                       <span class="invalid-feedback" id="event_description1"></span>
                      </div>
                    </div>
                     <div class="form-group row">
                      <label
                        for="image"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Event Image</label>
                      <div class="col-sm-5">
                        <input id="avatar" class="form-control" type="file" name="avatar[]" value="browse" accept=".jfif,.jpg,.jpeg,.png,.gif" multiple/>
                        <span class="invalid-feedback" id="event_image"></span>
                      </div>
                    </div>
                    <div class="img_thumline">
                        <?php
                            $images = explode(',',$edit_event['event_image']);
                        ?>
                        <?php 
                          $id = 1;
                            foreach($images as $value){
                            ?>
                            <span class="thum_img" id="thum_img"><img class="demo cursor" id="imgdel" src="{{(isset($edit_event['event_image'])) ? url('').'/eventimages/'.$value : ''}}" onclick="currentSlide({{$id}})" >
                            <input type="hidden" name="oldimg[]" id="oldimg{{$id}}" value="{{$value}}">
                            </span>
                            
                            <?php
                            $id++;
                            }
                            ?>
                    </div>
                    <div class="form-group row">
                        <label
                          for="status"
                          class="col-sm-2 text-end control-label col-form-label"
                          >Status</label
                        >
                        <div class="col-sm-5">
                            <label class="switch">
                          
                                <input type="checkbox" name="status" class="form-control status" id="event_status"value="1" {{($edit_event['event_status'] == 1)   ? 'checked' : ''}}>
                                                            
                                <span class="slider round"></span>
                            </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button id="upload" class="btn btn-primary">
                        Update
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              </div>
            </div> 
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
         </div>
   
@endsection

@section('eventupdate')
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
          console.log($("#avatar").prop("files").length);
          len_files = $("#avatar").prop("files").length;
          for (var i = 0; i < len_files; i++) {
              var file_data = $("#avatar").prop("files")[i];
       
              form_data.append('file'+number,file_data);
              form_data.append('file_name'+number,file_data.name);
              number++;
              var construc = '<span class="thum_img"><img class="demo cursor" id="img_del" src="' +
                  window.URL.createObjectURL(file_data) + '" alt="' + file_data.name + '" /></span>';
              $('.img_thumline').append(construc);
          }
         console.log(form_data);
      });
      $(".thum_img").click(function() {
            $(this).remove();
          });
      $("#img_del").click(function() {
        alert('hlo');
            // $(this).remove();
          });
      // / UPLOAD CLICK /
      $(document).on("click", "#upload", function (e) {
         // ================================================
         var values = $('input[name="oldimg[]"]').map(function(){
                      return this.value;
                    }).get();
      // ====================================================
        form_data.append('number',number);
        form_data.append('oldimg',values);

        var name = $("input[name=event_title]").val();
        form_data.append('event_title', name);
        // ----------------------------
        if($('#event_status').is(":checked"))  
                { 
                    form_data.append('event_status', 1);
                } else{
                    form_data.append('event_status', 0);
                }
        
        // ----------------------------
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
        var description = $("#event_description").val();
        form_data.append('event_description', description);
        var id = $("input[name=id]").val();
        var url = "{{ route('admin.updateevent', ":id") }}";
          url = url.replace(':id', id);
        
          e.preventDefault();
          $.ajax({
              headers: {
                  'X-CSRF-Token': '{{ csrf_token() }}',
              },
              
              url: url ,
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
                  var event_image_error  = error_msg1;
                  $('#main_msg').html(event_image_error);
                }
                if(error_msg1['number'] && error_msg1['number'].length > 0){
                  var event_image_error  = error_msg1['number'][0];
                  $('#event_image').html(event_image_error);
                }
                if(error_msg1['event_title'] && error_msg1['event_title'].length > 0){
                  var event_title_error  = error_msg1['event_title'][0];
                  $('#eventtitle1').html(event_title_error);
                }
                if(error_msg1['event_date'] && error_msg1['event_date'].length > 0){
                  var event_date_error  = error_msg1['event_date'][0];
                  $('#event_date1').html(event_date_error);
                }
                if(error_msg1['event_time'] && error_msg1['event_time'].length > 0){
                  var event_time_error  = error_msg1['event_time'][0];
                  $('#event_time1').html(event_time_error);
                }
                if(error_msg1['event_duration'] && error_msg1['event_duration'].length > 0){
                  var event_duration_error  = error_msg1['event_duration'][0];
                  $('#event_duration1').html(event_duration_error);
                }
                if(error_msg1['event_timezone'] && error_msg1['event_timezone'].length > 0){
                  var event_timezone_error  = error_msg1['event_timezone'][0];
                  $('#event_timezone1').html(event_timezone_error);
                }
                if(error_msg1['genre'] && error_msg1['genre'].length > 0){
                  var genre_error  = error_msg1['genre'][0];
                  $('#genre1').html(genre_error);
                }
                if(error_msg1['link_to_event_stream'] && error_msg1['link_to_event_stream'].length > 0){
                  var link_to_event_stream_error  = error_msg1['link_to_event_stream'][0];
                  $('#link_to_event_stream1').html(link_to_event_stream_error);
                }
                if(error_msg1['event_description'] && error_msg1['event_description'].length > 0){
                  var event_description_error  = error_msg1['event_description'][0];
                  $('#event_description1').html(event_description_error);
                }

               }else{
                location.reload();
               }
              
              },
          });
      });
  });
</script>
@endsection