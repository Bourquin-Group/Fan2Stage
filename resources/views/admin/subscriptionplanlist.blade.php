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
              <h4 class="page-title">Subscription Plan Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Subscription Plan
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
                  <a href="subscriptionplan/add"><button type="button" class="btn btn-primary">
                      Add 
                    </button></a></div>
                <div class="card-body">

                  <!-- <h5 class="card-title">Setting List</h5> -->
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
                          <th>F2S Plan</th>
                          <th>Fans Per Event</th>
                          <th>Events Per Month</th>
                          <th>Push Notification</th>
                          <th>Favorite Link</th>
                          <th>Cost</th>
                           <th>Anual Plan</th>
                           <th>Hardware Required</th>
                           <th>Status</th>
                          <th>Action</th>

                          <!-- <th>Start date</th>
                          <th>Salary</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($subscriptionplan) > 0)
                        <?php foreach ($subscriptionplan['subscriptionplan1'] as $value) {?>
                           <tr>
                          <td><?php echo $value['f2s_plan']; ?></td>
                          <td><?php echo $value['fans_per_event']; ?></td>
                          <td><?php echo $value['events_per_month']; ?></td>
                          <td><?php echo ucfirst($value['push_notification']); ?></td>
                          <td><?php echo ucfirst($value['favorite_link']); ?></td>
                          <td><?php echo ucfirst($value['cost']); ?></td>
                          <td><?php echo ucfirst($value['anual_plan']); ?></td>
                          <td><?php echo ucfirst($value['hardware_required']); ?></td>
                          <td><?php if($value['status'] == 1) {?> <span class='badge badge-success'>Active</span><?php } else{ ?><span class='badge badge-danger'>Deactive</span><?php }?></td>
                           <td>
                              <a href="{{url('/admin/subscriptionplanedit/'.base64_encode($value['id']))}}"><button type="button" class="btn btn-info btn-sm">
                              Edit</button></a>
                             
                            </td>
                        </tr>
                          <?php }?>
                          @else
                          <tr><td colspan="10" class="text-center">No Data Found</td></tr>
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