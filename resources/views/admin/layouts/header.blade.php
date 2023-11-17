<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <meta name="robots" content="noindex,nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Fan2Stage</title>
    <!-- Favicon icon -->
    {{-- <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="{{ asset('assets/admin/images/favicon.png') }}"
    /> --}}
     <link
      rel="stylesheet"
      type="text/css"
      href="{{ asset('assets/admin/libs/select2/dist/css/select2.min.css') }}"
    />
      <link
      rel="stylesheet"
      type="text/css"
      href="{{ asset('assets/admin/css/custom.css') }}"
    />
      <link
      rel="stylesheet"
      type="text/css"
      href="{{ asset('assets/admin/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
    />
    <link
      href="{{ asset('assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
      rel="stylesheet"
    />
        <link
      rel="stylesheet"
      type="text/css"
      href="{{ asset('assets/admin/extra-libs/multicheck/multicheck.css') }}"
    />
    <style>
      .dropdown {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.dropdown > a, .dropdown > button {
  cursor: pointer;
}

.dropdown input[type=checkbox] {
  position: absolute;
  display: block;
  top: 0px;
  left: 0px;
  width: 100%;
  height: 100%;
  margin: 0px;
  opacity: 0;
}

.dropdown input[type=checkbox]:checked {
  position: fixed;
  z-index:+0;
  top: 0px; left: 0px; 
  right: 0px; bottom: 0px;
}

.dropdown ul {
  position: absolute;
  top: 55px;
  border: 1px solid #ccc;
  border-radius: 3px;
  right: 0px;
  list-style: none;
  padding: 4px 0px;
  display: none;
  background-color: white;
  box-shadow: 0 3px 6px rgba(0,0,0,.175);
}

.dropdown input[type=checkbox]:checked + ul {
  display: block;
}
.dropdown, .dropend, .dropstart, .dropup {
    position: relative;
    display: flex;
}

.dropdown ul li {
  display: block;
  padding: 6px 20px;
  white-space: nowrap;
  min-width: 100px;
}

.dropdown ul li:hover {
  background-color: #F5F5F5;
  cursor: pointer;
}

.dropdown ul li a {
  text-decoration: none;
  display: block;
  color: black
}

.dropdown .divider {
  height: 1px;
  margin: 9px 0;
  overflow: hidden;
  background-color: #e5e5e5;
  font-size: 1px;
  padding: 0;
}

    </style>

   <script src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea#tinymce',
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste codesample"
            ],
            toolbar:
                "undo redo | fontselect styleselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample action section button",
            font_formats:"Segoe UI=Segoe UI;",
            fontsize_formats: "8px 9px 10px 11px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 42px 44px 46px 48px 50px 52px 54px 56px 58px 60px 62px 64px 66px 68px 70px 72px 74px 76px 78px 80px 82px 84px 86px 88px 90px 92px 94px 94px 96px",
            height: 600
        });
    </script>
 
    <script src="{{ asset('assets/admin/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Custom CSS -->
    <link href="{{ asset('assets/admin/libs/flot/css/float-chart.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/admin/css/style.min.css') }}" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
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
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="index.html">
              <!-- Logo icon -->
              <b class="logo-icon ps-2">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text ms-2" style="color:rgb(176, 231, 25);font-size:25px">
                <!-- dark Logo text -->
                Fan2Stage
              </span>
              <!-- Logo icon -->
              <!-- <b class="logo-icon"> -->
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <!-- <img src="../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

              <!-- </b> -->
              <!--End Logo icon -->
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)"
              ><i class="ti-menu ti-close"></i
            ></a>
          </div>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <div
            class="navbar-collapse collapse"
            id="navbarSupportedContent"
            data-navbarbg="skin5"
          >
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a
                  class="nav-link sidebartoggler "
                  href="javascript:void(0)"
                  data-sidebartype="mini-sidebar"
                  ><i class="mdi mdi-menu font-24"></i
                ></a>
              </li>
             
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            
            <span class="dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img
                  src="{{ asset('assets/admin/images/users/1.jpg') }}" alt="user" class="rounded-circle"  width="31"/>
              </a>
              <label>
                <input type="checkbox">
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ url('admin/profileedit/1') }}"
                    ><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a
                  > 
                  <a class="dropdown-item" href="{{ url('admin/passwordedit/1') }}"
                    ><i class="mdi mdi-wallet me-1 ms-1"></i>Change Password</a
                  >
                 <!--  <a class="dropdown-item" href="javascript:void(0)"
                    ><i class="mdi mdi-email me-1 ms-1"></i> Inbox</a
                  >
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:void(0)"
                    ><i class="mdi mdi-settings me-1 ms-1"></i> Account
                    Setting</a
                  > -->
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                  if(confirm('Are you sure you want to logout?')) {
                      document.getElementById('employee-logout-form').submit();
                  }"
                    ><i class="fa fa-power-off me-1 ms-1"></i> Logout</a
                  >
                   <form id="employee-logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                  @csrf
                  </form>
                <!--   <div class="dropdown-divider"></div>
                  <div class="ps-4 p-10">
                    <a
                      href="javascript:void(0)"
                      class="btn btn-sm btn-success btn-rounded text-white"
                      >View Profile</a
                    >
                  </div> -->
                </ul>
              </label>
            </span>

    
            <ul class="navbar-nav float-end">
           
              <li class="nav-item dropdown">
             

              </li>
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- ============================================================== -->
      <!-- End Topbar header -->