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
              <h4 class="page-title">Payment Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Payment 
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
                <div class="card-body">
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Artist Name</th>
                          <th>Subscription Name</th>
                          <th>Subscription Type</th>
                          <th>Start Date</th>
                          <th>Expiry Date</th>
                          <th>Amont</th>
                          <th>Event Per Month</th>
                          <th>Fans Per Month</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php foreach ($payment as $value) {
                          ?>
                      	<tr>
                          <td>{{($value->artistDetail->name ?? '-')}}</td>
                          <td>{{$value->subscriptionPlan->f2s_plan}}</td>
                          <td>{{$value->subscriptionPlan->cost}}</td>
                          <td>{{$value->payment_date->format('d-m-Y')}}</td>
                          <td>{{$value->renewal_date->format('d-m-Y')}}</td>
                          <td>{{$value->amount}}</td>
                          <td>{{$value->events_per_month}}</td>
                          <td>{{$value->fans_per_event}}</td>
                          <td><?php if($value->payment_status == 1) {?> <span class='badge bg-success'>Success</span><?php } else{ ?><span class='badge bg-danger'>Failed</span><?php }?></td>
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