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
                    <h4 class="page-title">Admin Management</h4>
                    <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Admin
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
                            <a href="admin/add"><button type="button" class="btn btn-primary">
                                    Add Admin
                                </button></a>
                        </div>
                        <div class="card-body">
                            @if (session()->has('Success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle"></i><strong
                                        class="px-2">{{ session('Success') }}</strong>

                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Image</th>
                                            <th>Role</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($admin as $value) {
                          if($value->image !=''){
                          $url = asset('assets/images/admin/thumbnail/'.$value->image);}
                          else{
                          $url = asset('assets/images/admin/thumbnail/noimage.jpg');
                          }
                          ?>
                                        <tr>
                                            <td><?php echo $value->name; ?></td>
                                            <td><?php echo $value->email; ?></td>
                                            <td><img src="<?php echo $url; ?>" width="50" height="50"></td>
                                            <td><?php echo $value->user_type; ?></td>
                                            {{-- <td><?php if($value->status == 1) {?> <span
                                                    class='badge badge-success'>Active</span><?php } else{ ?><span
                                                    class='badge badge-danger'>Inactive</span><?php }?></td> --}}
                                            <td>
                                                <a href="{{ url('/admin/adminedit/' . base64_encode($value->id)) }}"><button
                                                        type="button" class="btn btn-info btn-sm">
                                                        Edit</button></a>
                                                <a href="{{ url('/admin/deleteadmin/' . base64_encode($value->id)) }}"
                                                    onclick="return confirm(' you want to delete?');"><button type="button"
                                                        class="btn btn-danger btn-sm text-white">Delete</button></a>
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
