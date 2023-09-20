@extends('admin.layouts.master')

@section('content')
<!-- <style>
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

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
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
</style> -->
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
                      Settings
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
                
                   @if($editsetting)
                    <form class="form-horizontal" method="post" action="{{ url('/admin/updatesetting',$editsetting->id) }}" enctype="multipart/form-data">
                  @method("POST")
                  @else
                    <form class="form-horizontal" method="post" action="{{ url('/admin/settingstore') }}">
                      @method("POST")
                  @endif
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Edit Setting Content</h4> -->

                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Name<span class="text-danger">*</span></label>
                      
                      <div class="col-sm-5">
                        <input name="title" value="{{ ($editsetting)? (old('title')? old('title') : $editsetting->name) : old('title') }}"
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
                        for="slug"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Key<span class="text-danger">*</span></label>
                      
                      <div class="col-sm-5">
                        <input name="slug" value="{{ ($editsetting)? (old('slug')? old('slug') : $editsetting->key) : old('slug') }}"
                          type="text"
                          class="form-control @error('slug') is-invalid @enderror"
                          id="slug"
                          placeholder="Enter Your Title" readonly
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
                        >Value<span class="text-danger">*</span></label>
                      
                      <div class="col-sm-5">
                         <input name="description" value="{{ ($editsetting)? (old('description')? old('description') : $editsetting->value) : old('description') }}"
                          type="text"
                          class="form-control @error('description') is-invalid @enderror"
                          id="description"
                          placeholder="Enter Your Value"
                        />
                      
                        @error('description')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>



                    <div class="form-group row">
                      <label
                        for="ccode"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Category<span class="text-danger">*</span></label
                      >
                      <div class="col-sm-5">
                        <select name="category"
                        class="select2 form-select shadow-none"
                        style="width: 100%; height: 36px" 
                      >
                      
                        <option>Select Your Category</option>
                      
                         
                                           
                          <option value="<?php echo $editsetting->category; ?>"selected><?php echo $editsetting->category; ?></option>
                          <!-- <option value="event">Event</option>
                           <option value="test">Test</option> 
                          -->
                                                       
                        
                       
                      </select>
                        @error('category')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label
                        for="status"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Status</label
                      >
                      <div class="col-sm-5">
                       <label class="switch">
                         @if($editsetting->status == true)
                                                        <input type="checkbox" name="status" class="form-control status " value="1" checked="">
                                                        @else
                                                         <input type="checkbox" name="status" class="form-control status " value="">
                                                         @endif
                        <span class="slider round"></span>
                      </label>
                        @error('slug')
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