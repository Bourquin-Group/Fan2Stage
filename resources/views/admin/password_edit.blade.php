@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Change Password</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Change Password
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

                 @if(session()->has('Error'))
                                        <div class="alert alert-error alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle"></i><strong class="px-2">{{ session('Error') }}</strong>
                                            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button> -->
                                        </div>
                                        @endif

                
                   @if($editpassword)
                    <form class="form-horizontal" method="post" action="{{ url('/admin/updatepassword',$editpassword->id) }}" enctype="multipart/form-data">
                  @method("POST")
                  @else
                    <form class="form-horizontal" method="post" action="{{ url('/admin/passwordstore') }}">
                      @method("POST")
                  @endif
                  @csrf
               <div class="card-body">
                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Old Password</label
                      >
                      <div class="col-sm-5">
                        <input name="password" value=""
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

                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >New Password</label
                      >
                      <div class="col-sm-5">
                        <input name="newpassword" value=""
                          type="password"
                          class="form-control @error('newpassword') is-invalid @enderror"
                          id="lname"
                          placeholder="New Password Here"
                        />
                        @error('newpassword')
                          <span class="invalid-feedback">{{$message }}</span>
                        @enderror
                      </div>
                    </div>

                      <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-2 text-end control-label col-form-label"
                        >Confirm Password</label
                      >
                      <div class="col-sm-5">
                        <input name="confirmpassword" value=""
                          type="password"
                          class="form-control @error('confirmpassword') is-invalid @enderror"
                          id="lname"
                          placeholder="Confirm Password Here"
                        />
                        @error('confirmpassword')
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