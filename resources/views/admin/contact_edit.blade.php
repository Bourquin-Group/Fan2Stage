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
</style>
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Contact Management</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Contact
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
                
                   @if($editcontact)
                    <form class="form-horizontal" method="post" action="{{ url('/admin/updatecontact',$editcontact->id) }}" enctype="multipart/form-data">
                  @method("POST")
                  @else
                    <form class="form-horizontal" method="post" action="{{ url('/admin/contactstore') }}">
                      @method("POST")
                  @endif
                  @csrf
                  <div class="card-body">
                   <!--  <h4 class="card-title">Edit CMS Pape Content</h4> -->

                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Title1</label
                      >
                      <div class="col-sm-5">
                        <textarea rows="5" cols="50" name="title1" id="tinymce" class="form-control @error('title1') is-invalid @enderror">{{ ($editcontact)? (old('title1')? old('title1') : $editcontact->title1) : old('title1') }}</textarea>
                        @error('title1')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Title2</label
                      >
                      <div class="col-sm-5">
                        <textarea rows="5" cols="50" name="title2" id="tinymce" class="form-control @error('title2') is-invalid @enderror">{{ ($editcontact)? (old('title2')? old('title2') : $editcontact->title2) : old('title2') }}</textarea>
                        @error('title2')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Email</label
                      >
                      <div class="col-sm-5">
                        <input name="email" value="{{ ($editcontact)? (old('email')? old('email') : $editcontact->email) : old('email') }}"
                          type="text"
                          class="form-control @error('email') is-invalid @enderror"
                          id="email"
                          placeholder="Enter Your email"
                        />
                        @error('email')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Phone</label
                      >
                      <div class="col-sm-5">
                        <input name="phone" value="{{ ($editcontact)? (old('phone')? old('phone') : $editcontact->phone) : old('phone') }}"
                          type="text"
                          class="form-control @error('phone') is-invalid @enderror"
                          id="phone"
                          placeholder="Enter Your phone number"
                        />
                        @error('phone')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Location</label
                      >
                      <div class="col-sm-5">
                        <input name="location" value="{{ ($editcontact)? (old('location')? old('location') : $editcontact->location) : old('location') }}"
                          type="text"
                          class="form-control @error('location') is-invalid @enderror"
                          id="location"
                          placeholder="Enter Your location"
                        />
                        @error('location')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Map</label
                      >
                      <div class="col-sm-5">
                        <input name="map" value="{{ ($editcontact)? (old('map')? old('map') : $editcontact->map) : old('map') }}"
                          type="text"
                          class="form-control @error('map') is-invalid @enderror"
                          id="map"
                          placeholder="Enter Your map location"
                        />
                        @error('map')
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
                        <input type="checkbox" name="contact_status" class="form-control status" id="contact_status"value="1" {{($editcontact->status == 1)   ? 'checked' : ''}}>
      
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