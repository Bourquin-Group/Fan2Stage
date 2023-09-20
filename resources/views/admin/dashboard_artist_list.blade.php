@extends('admin.layouts.master')

@section('content')
<?php //print_r($user); ?>
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
              <h4 class="page-title">Artist List</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard/">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Artist List
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
                <!-- <div class="button-right">
                  <a href="artist/add"><button type="button" class="btn btn-primary">
                      Add Artist
                    </button></a></div> -->
                <div class="card-body">

                  <!-- <h5 class="card-title">Artist List</h5> -->
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
                      class="table table-striped table-bordered" >
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Image</th>
                          <th>Events</th>
                       
                          <!-- <th>Start date</th>
                          <th>Salary</th> -->
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       foreach ($user as $value) 
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
                               
                               <td><?php echo $value->name; ?></td>
                               <td><img src="<?php echo $url; ?>"  width="50" height="50"></td> 
                               <td><?php echo $artist_event->count('user_id'); ?></td>
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