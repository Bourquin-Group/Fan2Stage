@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Buffer Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
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
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{url('/admin/bufferstore')}}">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add Introductory</h4> -->
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Code</label
                      >
                      <div class="col-sm-5">
                        <input name="funcode" value="{{old('funcode')}}"
                          type="text"
                          class="form-control @error('funcode') is-invalid @enderror"
                          id="funcode"
                          placeholder="Enter Your Code"
                        />
                        @error('funcode')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Name</label
                      >
                      <div class="col-sm-5">
                        <input name="funname" value="{{old('funname')}}"
                          type="text"
                          class="form-control @error('funname') is-invalid @enderror"
                          id="funname"
                          placeholder="Enter Your name"
                        />
                        @error('funname')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Description</label
                      >
                      <div class="col-sm-5">
                        <input name="fundesc" value="{{old('fundesc')}}"
                          type="text"
                          class="form-control @error('fundesc') is-invalid @enderror"
                          id="fundesc"
                          placeholder="Enter Your desc"
                        />
                        @error('fundesc')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >value</label
                      >
                      <div class="col-sm-5">
                        <input name="funval1" value="{{old('funval1')}}"
                          type="text"
                          class="form-control @error('funval1') is-invalid @enderror"
                          id="funval1"
                          placeholder="Enter Your value"
                        />
                        @error('funval1')
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