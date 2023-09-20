@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Audio Files Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Audio Files
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
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{url('/admin/audiostore')}}">
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Add Introductory</h4> -->
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Audio Name</label
                      >
                      <div class="col-sm-5">
                        <input name="audio_name" value="{{old('audio_name')}}"
                          type="text"
                          class="form-control @error('audio_name') is-invalid @enderror"
                          id="audio_name"
                          placeholder="Enter Your Audio Name"
                        />
                        @error('audio_name')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="time" class="col-sm-2 text-end control-label col-form-label">Audio Type</label>
                      <div class="col-sm-5">
                        <select class="form-control" name="audio_type" id="audio_type">
                            <option value="">Select Audio Type</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                        </select>
                        @error('audio_type')
                        <span class="invalid-feedback">{{$message }}</span>
                      @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >From Action Count:</label
                      >
                      <div class="col-sm-5">
                        <input name="factcount" value="{{old('factcount')}}"
                          type="text"
                          class="form-control @error('factcount') is-invalid @enderror"
                          id="factcount"
                          placeholder="From count"
                        />
                        @error('factcount')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-2 text-end control-label col-form-label"
                        >To Action Count:</label
                      >
                      <div class="col-sm-5">
                        <input name="tactcount" value="{{old('tactcount')}}"
                          type="text"
                          class="form-control @error('tactcount') is-invalid @enderror"
                          id="tactcount"
                          placeholder="To count"
                        />
                        @error('tactcount')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                       <div class="form-group row">
                      <label
                        for="audio_file"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Audio File</label
                      >
                      <div class="col-sm-5">
                        <input name="audio_file" value="{{old('audio_file')}}"
                          type="file"
                          class="form-control @error('audio_file') is-invalid @enderror"
                          id="audio_file"
                          placeholder="Enter Your Link"
                        />
                        @error('audio_file')
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