<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords"  content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template"/>
    <meta  name="description"  content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework"/>
    <meta name="robots" content="noindex,nofollow" />
    <title>Matrix Admin Lite Free Versions Template by WrapPixel</title>
    <!-- Favicon icon -->
    <link rel="icon"  type="image/png" sizes="16x16" href="../assets/images/favicon.png"/>
    <!-- Custom CSS -->
    <link href="{{ asset('assets/admin/css/style.min.css') }}" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>
    label.error {
    color: red!important;
    }
    .main-wrapper  {
     min-height: 100vh;
    }
    .main-wrapper.bg-dark {
     display: flex;
     align-items: center;
     justify-content: center;
     padding: 20px  0;
     }
 </style>
  <body>
    <div class="main-wrapper bg-dark">
      <!-- ============================================================== -->
      <!-- Preloader - style you can find in spinners.css -->
      <!-- ============================================================== -->
      <div class="preloader">
        <div class="lds-ripple">
          <div class="lds-pos"></div>
          <div class="lds-pos"></div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- Preloader - style you can find in spinners.css -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Login box.scss -->
      <!-- ============================================================== -->
      <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
        <div class="auth-box bg-dark border-top border-secondary">
           <div>
                <div class="text-center pt-3 pb-3">
                <span class="db"><img src="{{ asset('assets/admin/images/header_logo.png') }}" alt="logo"/></span>
                </div>
            </div> 
            <div class="row mt-3">
                 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                 <!-- Form -->
                 <form class="form-horizontal mt-3" id="checkconfirmpassword" method="POST"  action="{{ route('password.update') }}"> 
                     @csrf
                     <input type="hidden" name="token" value="{{ $token }}"> 
                       <div class="row pb-4">
                          <div class="col-12">
                             <!-- email -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white h-100" id="basic-addon1"><i class="mdi mdi-email fs-4"></i></span>
                                    </div>
                                    <input id="email"  type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus class="form-control @error('email') is-invalid @enderror form-control-lg" placeholder="Email Address"aria-label="Username"aria-describedby="basic-addon1"/>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span  class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i class="mdi mdi-lock fs-4"></i></span>
                                    </div>
                                    <input  id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" autocomplete="new-password"/>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                  </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                       <span  class="input-group-text bg-info text-white h-100" id="basic-addon2"><i class="mdi mdi-lock fs-4"></i></span>
                                    </div>
                                     <input id="passwordconfirm" name="password_confirmation" type="password" class="form-control  form-control-lg" placeholder="Confirm Password" aria-describedby="basic-addon1" autocomplete="new-password"/>
                                    
                                    </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="pt-3 d-grid">
                                        <a class="btn btn-success text-white" href="/admin" id="to-login" name="action" style="margin-bottom:10px;padding:0.5rem 1rem;font-size:1.09375rem;">Cancel</a>
                                        <button class="btn btn-block btn-lg btn-info" id="submit" type="submit">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                 </form>
             </div>
          </div>
      </div>
      <!-- ============================================================== -->
      <!-- Login box.scss -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper scss in scafholding.scss -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper scss in scafholding.scss -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right Sidebar -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right Sidebar -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
  
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
      $(".preloader").fadeOut();
    </script> 
    <script type="text/javascript">
        $(document).ready(function() {
          $('#checkconfirmpassword').on('submit', function(e){
    
        var password = $('#password').val();
        var passwordconfirm = $('#passwordconfirm').val();
         
           if(password != passwordconfirm ) {
            $('#cnfm_pwd_error').html('Password and confirm password does not match');
           
        }
         
    });
});
</script>
  </body>
</html>

