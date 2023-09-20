@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Introductory Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Introductory
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
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{url('/admin/introductorystore')}}">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add Introductory</h4> -->
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Title</label
                      >
                      <div class="col-sm-5">
                        <input name="title" value="{{old('title')}}"
                          type="text"
                          class="form-control @error('title') is-invalid @enderror"
                          id="title"
                          placeholder="Enter Your Title"
                        />
                        @error('title')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                      <div class="form-group row">
                      <label
                        for="description"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Description</label
                      >
                      <div class="col-sm-10">
                       <textarea id="tinymce" name="description" rows="4" cols="50" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Your Description"></textarea>
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
                        for="slug"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Link</label
                      >
                      <div class="col-sm-5">
                        <input name="slug" value="{{old('slug')}}"
                          type="text"
                          class="form-control @error('slug') is-invalid @enderror"
                          id="fname"
                          placeholder="Enter Your Link"
                        />
                        @error('slug')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                     <div class="form-group row">
                      <label
                        for="image"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Image</label
                      >
                      <div class="col-sm-5">
                        <input name="image" value="{{old('image')}}"
                          type="file"
                          class="form-control @error('image') is-invalid @enderror"
                          id="fname"
                          placeholder="Enter Your Link"
                        />
                        @error('image')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                       <div class="form-group row">
                      <label
                        for="video"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Video</label
                      >
                      <div class="col-sm-5">
                        <input name="video" value="{{old('video')}}"
                          type="file"
                          class="form-control @error('video') is-invalid @enderror"
                          id="video"
                          placeholder="Enter Your Link"
                        />
                        @error('video')
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