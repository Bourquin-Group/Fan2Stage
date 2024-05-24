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
              <h4 class="page-title">Audio Files Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Audio Files
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
                  <a href="audio/add"><button type="button" class="btn btn-primary">
                      Add Audio 
                    </button></a></div>
                <div class="card-body">
                      @if(session()->has('Success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle"></i><strong class="px-2">{{ session('Success') }}</strong>
                                            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button> -->
                                        </div>
                                        @endif
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Audio Name</th>
                          <th>Audio Type</th>
                          <th>Block</th>
                          <th>Fan's Action Event</th>
                          <th>Audio File</th>
                          <th>Audio Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($audio)>0)
                      	<?php foreach ($audio as $value) {
                          if($value->audio_file !=''){
                          $url = asset('assets/graph/audio/block'.$value->block.'/'.$value->audio_file);}
                          else{
                          $url = asset('assets/graph/audio/noimage.jpg');
                          }
                          ?>
                      	<tr>
                          <td><?php echo $value->audio_name; ?></td>
                          <td><?php echo $value->audio_type; ?></td>
                          <td><?php echo $value->block; ?></td>
                          <td><?php echo $value->factcount." - ".$value->tactcount; ?></td>
                          <td><audio controls>
                            <source src="{{$url}}" type="audio/mpeg"> 
                            </audio></td>
                          <td><?php if($value->audio_status == 1) {?> <span class='badge bg-success'>Active</span><?php } else{ ?><span class='badge bg-danger'>In Active</span><?php }?></td>
                           <td>
                              <a href="{{url('/admin/audioedit/'.base64_encode($value->id))}}"><button type="button" class="btn btn-info btn-sm">
                              Edit</button></a>
                              <a href="{{url('/admin/deleteaudio/'.base64_encode($value->id))}}" onclick="return confirm(' you want to delete?');"><button type="button" class="btn btn-danger btn-sm text-white">Delete</button></a>
                            </td>
                        </tr>
  
                        <?php }?>
                        @else
                        <tr>
                            <td colspan="6" class="text-center">No Audio Files Found</td>
                        </tr>
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
@endsection