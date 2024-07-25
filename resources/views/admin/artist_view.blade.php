@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper">
<!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Artist Profile</h4>
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
                  <div class="card-body">
                    <!-- <h4 class="card-title">Edit Artist</h4> -->
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Account Number</div>
                            <div class="col-md-6">{{($edituser->artistProfile->account_number != "") ? $edituser->artistProfile->account_number : "-"}}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Name</div>
                            <div class="col-md-6">{{$edituser->name}}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Phone_number</div>
                            <div class="col-md-6">{{$edituser->phone_number}}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Email</div>
                            <div class="col-md-6">{{$edituser->email}}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Genre</div>
                            <div class="col-md-6">{{($edituser->artistProfile->genre != "") ? $edituser->artistProfile->genre : "-"}}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">stage_name</div>
                            <div class="col-md-6">{{($edituser->artistProfile->stage_name != "") ? $edituser->artistProfile->stage_name : "-"}}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Time Zone</div>
                            <div class="col-md-6">
                                <?php
    if ($edituser->timezone != "") {
        if ($edituser->timezone == 1) {
            echo "PST";
        } elseif ($edituser->timezone == 2) {
            echo "IST";
        } elseif ($edituser->timezone == 3) {
            echo "EST";
        } elseif ($edituser->timezone == 4) {
            echo "MDT";
        } elseif ($edituser->timezone == 5) {
            echo "GMT";
        } else {
            echo "PDT";
        }
    } else {
        echo "-";
    }
    ?>
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">website_link</div>
                            <div class="col-md-6">{{($edituser->artistProfile->website_link != "") ? $edituser->artistProfile->website_link : "-"}}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">itunes_link</div>
                            <div class="col-md-6">{{($edituser->artistProfile->itunes_link != "") ? $edituser->artistProfile->itunes_link : "-"}}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">youtube_link</div>
                            <div class="col-md-6">{{($edituser->artistProfile->youtube_link != "") ? $edituser->artistProfile->youtube_link : "-"}}</div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">instagram_link</div>
                            <div class="col-md-6">{{($edituser->artistProfile->instagram_link != "") ? $edituser->artistProfile->instagram_link : "-"}}</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Profile Image</div>
                            <div class="col-md-6"><img src="{{(isset($edituser->artistProfile->profile_image)) ? asset('/artist_profile_images/'.$edituser->artistProfile->profile_image):  asset('artist_profile_images/profile1.jpeg')}}" style="object-fit: contain;
                                width: 50%;
                                height: 50%;object-position: top;"alt=""></div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6 fw-bold">Landing Page Image</div>
                            <div class="col-md-6"><img src="{{(isset($edituser->artistProfile->landing_page_image)) ? asset('/artist_landingpage_images/'.$edituser->artistProfile->landing_page_image):  asset('artist_profile_images/profile1.jpeg')}}" style="object-fit: contain;
                                width: 50%;
                                height: 50%;object-position: top;" alt=""></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 fw-bold">Bio</div>
                        <div class="col-md-9">{{($edituser->artistProfile->bio != "") ? $edituser->artistProfile->bio : "-"}}</div>
                    </div>
                  </div>
              </div>
              </div>
            </div> 
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
         </div>
         
@endsection