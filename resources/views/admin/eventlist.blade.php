@extends('admin.layouts.master')

@section('content')
<style>
  

button.btn.btn-primary {
    float: right;
    margin-top: 15px;
    margin-right: 15px;
}
</style>
<div class="page-wrapper">
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
            <div class="col-12">

         
              <div class="card">
                <div class="button-right">
                  <a href="event/add"><button type="button" class="btn btn-primary">
                      Add Event 
                    </button></a></div>
                <div class="card-body">

                 <!--  <h5 class="card-title">Introductory List</h5> -->
                      @if(session()->has('Success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle"></i><strong class="px-2">{{ session('Success') }}</strong>
                                        </div>
                                        @endif
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Link For Stream</th>
                          <th>Duration</th>
                          <th>Image</th>
                          {{-- <th>Description</th> --}}
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php foreach ($event as $value) {
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
                          <td><?php echo $value->event_time; ?></td>
                          <td><?php echo ($value->link_to_event_stream) ? substr($value->link_to_event_stream, 0, 20) : '-'; ?></td>
                          <td><?php echo $value->event_duration; ?></td>
                          <td><img src="<?php echo $url; ?>"  width="50" height="50"></td>
                          {{-- <td><?php echo substr($value->event_description, 0, 30); ?></td> --}}
                          <td><?php if($value->event_status == 1) {?> <span class='badge bg-success'>Active</span><?php } else{ ?><span class='badge bg-danger'>In Active</span><?php }?></td>
                           <td>
                              <a href="{{url('/admin/eventedit/'.base64_encode($value->id))}}"><button type="button" class="btn btn-info btn-sm">
                              Edit</button></a>
                              <a href="{{url('/admin/deleteevent/'.base64_encode($value->id))}}" onclick="return confirm(' you want to delete?');"><button type="button" class="btn btn-danger btn-sm text-white">Delete</button></a>
                            </td>
                        </tr>
  
                        <?php }?>
                       
                      </tbody>
                    
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
         </div> 
        </div>
@endsection