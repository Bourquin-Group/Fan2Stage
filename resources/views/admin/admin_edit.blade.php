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

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
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
                <div class="col-md-12">
                    <div class="card">

                        @if ($editadmin)
                            <form class="form-horizontal" method="post"
                                action="{{ url('/admin/updateadmin', $editadmin->id) }}" enctype="multipart/form-data">
                                @method('POST')
                            @else
                                <form class="form-horizontal" method="post" action="{{ url('/admin/adminstore') }}"
                                    enctype="multipart/form-data">
                                    @method('POST')
                        @endif
                        @csrf
                        <div class="card-body">
                            <!-- <h4 class="card-title">Edit CMS Pape Content</h4> -->

                            <div class="form-group row">
                                <label for="fname" class="col-sm-2 text-end control-label col-form-label">Name</label>
                                <div class="col-sm-5">
                                    <input name="name"
                                        value="{{ $editadmin ? (old('name') ? old('name') : $editadmin->name) : old('name') }}"
                                        type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" placeholder="Enter Your Name" />
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fname" class="col-sm-2 text-end control-label col-form-label">Email</label>
                                <div class="col-sm-5">
                                    <input name="email"
                                        value="{{ $editadmin ? (old('email') ? old('email') : $editadmin->email) : old('email') }}"
                                        type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="Enter Your Email" />
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="fname"
                                    class="col-sm-2 text-end control-label col-form-label">Password</label>
                                <div class="col-sm-5">
                                    <input name="password"
                                        value="{{ $editadmin ? (old('password') ? old('password') : $editadmin->password) : old('password') }}"
                                        type="text" class="form-control @error('password') is-invalid @enderror"
                                        id="password" placeholder="Enter Your password" />
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="image" class="col-sm-2 text-end control-label col-form-label">Image</label>
                                <div class="col-sm-5">
                                    @if ($editadmin)
                                        <input type="file" name="image" class="form-control" id="image">
                                        <img src="{{ asset('assets/images/admin/thumbnail/' . $editadmin->image) }}"
                                            name="old_upload_image" id="old_upload_image" style="margin-top: 10px;" width="50" height="50">
                                    @else
                                        <input type="file" name="image" class="form-control" id="image">
                                    @endif
                                    @error('image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-2 text-end control-label col-form-label">Status</label>
                                <div class="col-sm-5">
                                    <label class="switch">
                                        @if ($editadmin->status == true)
                                            <input type="checkbox" name="status" class="form-control status "
                                                value="1" checked="">
                                        @else
                                            <input type="checkbox" name="status" class="form-control status "
                                                value="">
                                        @endif
                                        <span class="slider round"></span>
                                    </label>
                                    @error('slug')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">
                                    Submit
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
