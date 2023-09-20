@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Action Files Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Actions
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
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{url('/admin/actionstore')}}">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add Introductory</h4> -->
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Action Name</label
                      >
                      <div class="col-sm-5">
                        <input name="action_name" value="{{old('action_name')}}"
                          type="text"
                          class="form-control @error('action_name') is-invalid @enderror"
                          id="action_name"
                          placeholder="Enter Your Audio Name"
                        />
                        @error('action_name')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Action Description</label
                      >
                      <div class="col-sm-5">
                        <input name="action_desc" value="{{old('action_desc')}}"
                          type="text"
                          class="form-control @error('action_desc') is-invalid @enderror"
                          id="action_desc"
                          placeholder="Enter Your Audio Name"
                        />
                        @error('action_desc')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                       <div class="form-group row">
                      <label
                        for="action_file"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Action Image</label
                      >
                      <div class="col-sm-5">
                        <input name="action_file" value="{{old('action_file')}}"
                          type="file"
                          class="form-control @error('action_file') is-invalid @enderror"
                          id="action_file"
                          placeholder="Enter Your Link"
                        />
                        @error('action_file')
                          <span class="invalid-feedback">{{$message }}</span>
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