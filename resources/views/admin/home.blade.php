@extends('admin.layouts.master')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->
 <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          @if(session()->has('Successs'))
          <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            <i class="fas fa-check-circle"></i><strong class="px-2">{{ session('Successs') }}</strong>
        </div>
                                        @endif
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Dashboard</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
                    <!-- <li class="breadcrumb-item active" aria-current="page">
                      Dashboard
                    </li> -->
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid" style="min-height: 0px;">
           @if(session()->has('Success'))
           <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            <i class="fas fa-check-circle"></i><strong class="px-2">{{ session('Success') }}</strong>
        </div>
                                        @endif
          <!-- ============================================================== -->
        <!-- Cards -->
        <div class="row">
            <div class="col-md-3">
              <div class="card mt-0">
              <a href="/admin/user">
                <div class="row" style="padding:20px;">
                  <div class="col-md-6">
                    <div class="peity_line_neutral left text-center mt-2">
                    </div>
                  </div>
                  <div class="col-md-6 pt-2"> 
                    <h3 class="mb-0 fw-bold" style="color:#3e5569;">{{ (count($fans_list))}}</h3>
                    <span class="text-muted">Fans</span> 
                  </div>
                </div>
                </a> 
              </div>
            </div>
            <div class="col-md-3">
              <div class="card mt-0">
              <a href="/admin/artist">
                <div class="row" style="padding:20px;">
                  <div class="col-md-6">
                    <div class="peity_bar_bad left text-center mt-2">
                    </div>
                  </div>
                  <div class="col-md-6 border-left text-center pt-2">
                    <h3 class="mb-0 fw-bold" style="color:#3e5569;">{{ (count($artist_list))}}</h3>
                    <span class="text-muted">Artist</span>
                  </div>
                </div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card mt-0">
                <a href="/admin/event">
                <div class="row" style="padding:20px;">
                  <div class="col-md-6">
                    <div class="peity_line_good left text-center mt-2">
                    </div>
                  </div>
                  <div class="col-md-6 border-left text-center pt-2">
                    <h3 class="mb-0" style="color:#3e5569;">{{ (count($Event_lists))}}</h3>
                    <span class="text-muted">Events</span>
                  </div>
                </div>
              </div>
             </a>
            </div>
          </div>
          <!-- End cards -->

          
          <!-- ============================================================== -->
          <!-- Recent comment and chats -->
          <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->

<!-- Artist list Start -->

<div>
 <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Artist List</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="/admin/dashboard/">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Artist List
                    </li> -->
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
            <div class="col-12">

         
              <div class="card">
                <!-- <div class="button-right">
                  <a href="artist/add"><button type="button" class="btn btn-primary">
                      Add Artist
                    </button></a></div> -->
                <div class="card-body">

                  <!-- <h5 class="card-title">Artist List</h5> -->
                      @if(session()->has('Success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                        <i class="fas fa-check-circle"></i><strong class="px-2">{{ session('Success') }}</strong>
                    </div>
                                        @endif
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered" >
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Stage Name</th>
                          <th>Image</th>
                          <!-- <th>Events</th> -->
                       
                          <!-- <th>Start date</th>
                          <th>Salary</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($artistrating)>0)
                      <?php
                       foreach ($artistrating as $value) 
                       {

                          if($value->image !=''){
                            $filename = explode(',',$value->image);
                            $directory = "image/";
                            $filename1 = $filename[0];
                            if(file_exists($directory . $filename1)){
                                $url = asset('image/'.$filename[0]);
                            }else{
                                $url = asset('assets/images/introductory/thumbnail/noimage.jpg');
                            }
                          }
                          else{
                          $url = asset('assets/images/introductory/thumbnail/noimage.jpg');
                          }
                          ?>
                      		 <tr>
                               
                               <td><?php echo $value->userArtist->name; ?></td>
                               <td><?php echo $value->stage_name; ?></td>
                               <td><img src="<?php echo $url; ?>"  width="50" height="50"></td> 
                               <!-- <td><//?php echo $artist_event->count('user_id'); ?></td> -->
                        </tr>
  
                        <?php }?>
                       @else
                       <tr><td class ="text-center"colspan="3"> No data found </td></tr>
                       @endif
                      </tbody>
                   
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
         </div> 
        </div>

<!-- Artist list End -->

<!-- Event list start -->
<div>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Event List</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
                    <!-- <li class="breadcrumb-item active" aria-current="page">
                    Event List
                    </li> -->
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
        <div class="container-fluid" style="margin-top: 15px;">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-12">

         
              <div class="card">
                <!-- <div class="button-right">
                  <a href="event/add"><button type="button" class="btn btn-primary">
                      Add Event 
                    </button></a></div> -->
                <div class="card-body ">

                  <!-- <h5 class="card-title">Event List</h5> -->
                      @if(session()->has('Success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                        <i class="fas fa-check-circle"></i><strong class="px-2">{{ session('Success') }}</strong>
                    </div>
                                        @endif
                  <!-- <div class="table-responsive"> -->
                    <table  class="table">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Date</th>
                          <th>Image</th>  
                          <th>Event booking</th>  
                        </tr>
                      </thead>
                      <tbody>
                      @if(count($Event_list)>0)
                      	<?php foreach ($Event_list as $value) {
                          if($value->event_image !=''){
                            $filename = explode(',',$value->event_image);
                            $directory = "eventimages/";
                            $filename1 = $filename[0];
                            if(file_exists($directory . $filename1)){
                                $url = asset('eventimages/'.$filename[0]);
                            }else{
                                $url = asset('assets/images/introductory/thumbnail/noimage.jpg');
                            }
                          }
                          else{
                          $url = asset('assets/images/introductory/thumbnail/noimage.jpg');
                          }
                          ?>
                      		 <tr>
                          <td><?php echo $value->event_title; ?></td>
                          <td><?php echo date('Y-m-d',strtotime($value->event_date)); ?></td>
                          <td><img src="<?php echo $url; ?>"  width="50" height="50"></td> 
                          <td>{{($value->eventBooking) ? $value->eventBooking->where('event_id', $value->id)->count() : "-"}}</td>
                        </tr>
  
                        <?php }?>
                       @else <tr><td class ="text-center"colspan="4"> No data found </td></tr>
                       @endif
                        </tbody> 
                    </table>
                  <!-- </div> -->
                </div>
              </div>
            </div>
          </div>
         </div> 
        </div>
<!-- Event list end -->
@endsection