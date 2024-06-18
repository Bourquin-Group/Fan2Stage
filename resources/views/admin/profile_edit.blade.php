@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Edit Profile</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Profile
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
                
                   @if($editprofile)
                    <form class="form-horizontal" method="post" action="{{ url('/admin/updateprofile',$editprofile->id) }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                  @method("POST")
                  @else
                    <form class="form-horizontal" method="post" action="{{ url('/admin/profilestore') }}" onsubmit="return validateForm()">
                      @method("POST")
                  @endif
                  @csrf
                  <div class="card-body">
                    <!-- <h4 class="card-title">Edit Fan User</h4> -->
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Name</label
                      >
                      <div class="col-sm-5">
                        <input name="name" value="{{ ($editprofile)? (old('name')? old('name') : $editprofile->name) : old('name') }}"
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



                    {{-- <div class="form-group row">
                      <label
                        for="ccode"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Country Code</label
                      >
                      <div class="col-sm-5">
                        <select name="ccode"
                        class="select2 form-select shadow-none"
                        style="width: 100%; height: 36px"
                      >
                      
                        <option>Select Your Country Code</option>
                      
                          @foreach($country as $code)
                          @if($editprofile->country_code == ' +'.$code->phonecode)                        
                          <option value="<?php echo "+".$code->phonecode ?>"selected><?php echo "+".$code->phonecode; ?>-<?php echo $code->name; ?></option>
                           @else
                           <option value="<?php echo "+".$code->phonecode ?>"><?php echo "+".$code->phonecode; ?>-<?php echo $code->name; ?></option> 
                           @endif  
                          @endForeach
                                                       
                        
                       
                      </select>
                        @error('ccode')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div> --}}

                  
                     {{-- <div class="form-group row">
                      <label
                        for="phone"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Phone Number</label
                      >
                      <div class="col-sm-5">
                        <input name="phone" value="{{ ($editprofile)? (old('phone')? old('phone') : $editprofile->phone_number) : old('phone') }}"
                          type="text" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10"
                          class="form-control @error('phone') is-invalid @enderror"
                          id="phone"
                          placeholder="Enter Your Phone Number"
                        />
                        @error('phone')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div> --}}
                     <div class="form-group row">
                      <label
                        for="email1"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Email</label
                      >
                      <div class="col-sm-5">
                        <input name="email" value="{{ ($editprofile)? (old('email')? old('email') : $editprofile->email) : old('email') }}"
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
                        for="image"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Image</label
                      >
                      
                      <div class="col-sm-5">
                        <img src="{{ asset('assets/images/admin/thumbnail/' . auth()->user()->image) }}"
                                            name="old_upload_image" id="old_upload_image" style="margin-top: 10px;" width="50" height="50">
                      {{-- @if($editprofile)
                      <input type="file" name="image" class="form-control" id="image" accept=".svg, .jpg, .jpeg, .png" onchange="checkFile()">
                      <img src="{{asset('assets/images/profile/thumbnail/'.$editprofile->image)}}" name="old_upload_image" id="old_upload_image" style="margin-top: 10px;">
                     @else
                     <input type="file" name="image" class="form-control" id="image" accept=".svg, .jpg, .jpeg, .png" onchange="checkFile()">
                    @endif
                    <span id="fileError" class="invalid-feedback" style="display: none;"></span>
                        @error('image')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror --}}
                      </div>
                    </div>
                    
                  </div>
                  {{-- <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div> --}}
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

  function checkFile() {
    var fileInput = document.getElementById('image');
    var errorContainer = document.getElementById('fileError');

    if (fileInput.files.length === 0) {
        errorContainer.style.display = 'none';
    }
}

function validateForm() {
    var fileInput = document.getElementById('image');
    var allowedExtensions = /(\.svg|\.jpg|\.jpeg|\.png)$/i;
    var errorContainer = document.getElementById('fileError');

    if (fileInput.files.length > 0) {
        var filePath = fileInput.value;
        if (!allowedExtensions.exec(filePath)) {
            errorContainer.style.display = 'block';
            errorContainer.innerHTML = 'Please upload files having extensions .svg, .jpg, .jpeg, .png only.';
            return false;
        } else {
            errorContainer.style.display = 'none';
            return true;
        }
    }
    return true; // If no file is uploaded, skip validation
}

</script>
@endsection