@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Setting Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Setting
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
                <form class="form-horizontal" method="post" action="{{url('/admin/settingstore')}}">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add</h4> -->
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Name<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <input name="title" value="{{old('title')}}"
                          type="text"
                          class="form-control @error('title') is-invalid @enderror"
                          id="title"
                          placeholder="Enter The Name"
                        />
                        @error('title')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label
                        for="slug"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Key<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <input name="slug" value="{{old('slug')}}"
                          type="text"
                          class="form-control @error('slug') is-invalid @enderror"
                          id="fname"
                          placeholder="Enter The Key"
                        />
                        @error('slug')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                      <div class="form-group row">
                      <label
                        for="description"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Value<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                       <input name="description" value="{{old('description')}}"
                          type="text"
                          class="form-control @error('description') is-invalid @enderror"
                          id="description"
                          placeholder="Enter The Value"
                        />
                       <!--  <input name="description" value="{{old('description')}}"
                          type="textarea"
                          class="form-control @error('description') is-invalid @enderror"
                          id="fname"
                          placeholder="Enter Your Description"
                        /> -->
                        @error('description')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="category"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Setting Category<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <select name="category" id="category"
                        class="select2 form-select shadow-none @error('category') is-invalid @enderror"
                        style="width: 100%; height: 36px"
                      >
                        <option value="">Select Your category</option>
                          <option value="event">Event</option>
                      
                        
                       
                      </select>
                        @error('category')
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