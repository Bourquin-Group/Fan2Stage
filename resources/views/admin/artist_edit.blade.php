@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Edit Artist</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Artist
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
                
                   @if($edituser)
                    <form class="form-horizontal" method="post" action="{{ url('/admin/updateartist',$edituser->id) }}" enctype="multipart/form-data">
                  @method("POST")
                  @else
                    <form class="form-horizontal" method="post" action="{{ url('/admin/artiststore') }}">
                      @method("POST")
                  @endif
                  @csrf
                  <div class="card-body">
                    <!-- <h4 class="card-title">Edit Artist</h4> -->
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Name</label
                      >
                      <div class="col-sm-5">
                        <input name="name" value="{{ ($edituser)? (old('name')? old('name') : $edituser->name) : old('name') }}"
                          type="text"
                          class="form-control @error('name') is-invalid @enderror"
                          id="fname"
                          placeholder="Enter Your Name"
                        />
                        @error('name')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                  
                     <div class="form-group row">
                      <label
                        for="phone"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Phone Number</label
                      >
                      <div class="col-sm-5">
                        <input name="phone" value="{{ ($edituser)? (old('phone')? old('phone') : $edituser->phone_number) : old('phone') }}"
                          type="text" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10"
                          class="form-control @error('phone') is-invalid @enderror"
                          id="phone"
                          placeholder="Enter Your Phone Number"
                        />
                        @error('phone')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label
                        for="stage"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Stage Name</label
                      >
                      <div class="col-sm-5">
                        <input name="stage" value="{{ ($edituser)? (old('stage')? old('stage') : $edituser->stage_name) : old('stage') }}"
                          type="text"
                          class="form-control @error('stage') is-invalid @enderror"
                          id="stage"
                          placeholder="Enter Your Stage Name"
                        />
                        @error('stage')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                     <div class="form-group row">
                      <label
                        for="email1"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Email</label
                      >
                      <div class="col-sm-5">
                        <input name="email" value="{{ ($edituser)? (old('email')? old('email') : $edituser->email) : old('email') }}"
                          type="text"
                          class="form-control @error('email') is-invalid @enderror"
                          id="email1"
                          placeholder="Enter Your Email"
                        />
                         @error('email')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Password</label
                      >
                      <div class="col-sm-5">
                        <input name="password" value="{{ ($edituser)? (old('password')? old('password') : $edituser->password) : old('password') }}"
                          type="password"
                          class="form-control @error('password') is-invalid @enderror"
                          id="lname"
                          placeholder="Password Here"
                        />
                        @error('password')
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
         <script>
    
    $(document).ready(function(){
        // $('body').on('keypress keyup blur', '#placement', function (){
    $("#phone").on("keypress keyup blur",function (e) {
      
   $(this).val($(this).val().replace(/[^0-9\.]/g,''));
      if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
      }
  });
  });
</script>
@endsection