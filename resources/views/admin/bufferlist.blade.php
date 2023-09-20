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
              <h4 class="page-title">Buffer List</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard/">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Buffer
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
                  <a href="buffer/add"><button type="button" class="btn btn-primary">
                      Add Buffer
                    </button></a></div>
                <div class="card-body">
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
                          <th>Fun Code</th>
                          <th>Fun Name</th>
                          <th>Fun Description</th>
                          <th>Fun Value</th>
                          <th>Fun Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php foreach ($buffer as $value) {?>
                      		 <tr>
                          <td><?php echo $value->funcode; ?></td>
                          <td><?php echo $value->funname; ?></td>
                          <td><?php echo $value->fundesc; ?></td>
                          <td><?php echo $value->funval1; ?></td>
                          <td><?php if($value->funstatus == 1) {?> <span class='badge bg-success'>Active</span><?php } else{ ?><span class='badge bg-danger'>In Active</span><?php }?></td>
                           <td>
                              <a href="{{url('/admin/bufferedit/'.base64_encode($value->id))}}"><button type="button" class="btn btn-info btn-sm">
                              Edit</button></a>
                              <a href="{{url('/admin/deletebuffer/'.base64_encode($value->id))}}" onclick="return confirm(' you want to delete?');"><button type="button" class="btn btn-danger btn-sm text-white">Delete</button></a>
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