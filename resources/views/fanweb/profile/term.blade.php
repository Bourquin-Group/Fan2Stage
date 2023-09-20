@extends('fanweb.layouts.main')
@section('content')
<section class="main_section">
        <div class="custom_container">
            <div class="row d-flex align-items-start res-flex-wrap">
                <div class="col-lg-3 col-md-12 col-sm-12 tab-navbar">
                   <h1 class="font-28">Quick Links</h1>
                    @include('fanweb.profile.side-menu')               
                </div>
                <div class="tab-content col-lg-9 col-md-12 col-sm-12 col-xs-12 profiletab-wrapper " id="v-pills-tabContent ">
            
                  <div class="tab-pane show active " id="v-pills-terms" role="tabpanel" aria-labelledby="v-pills-terms-tab" tabindex="0">
                      <div class="tab-heading">
                        <h1 class="font-28">{{ucfirst($termsandcondition['Title'])}}</h1>
                      </div>
                      <div class="terms-main">
                        <div class="scroll-sec">   
                            <div class="terms-con-txt">
                                <p class="font-18">{!! $termsandcondition['Description'] !!}</p>
                            </div>
                          </div>
                      </div>                  
                  </div>
                  <!-- END -->
                  <!-- 
                  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
                    <div class="tab-heading">
                      <h1 class="font-28">Privacy Policy</h1>
                    </div>
                    <div class="terms-main">
                      <div class="scroll-sec">   
                            <div class="terms-con-txt">
                                <h6 class="font-18">a. Age Restrictions</h6>
                                <p class="font-18">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.</p>
                            </div>                    
                            <div class="terms-con-txt">
                              <h6 class="font-18">b. Basic Use Requirments</h6>
                              <p class="font-18">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.</p>
                            </div>

                            <div class="terms-con-txt">
                              <h6 class="font-18">c. Conset and Information Colletion and Use</h6>
                              <p class="font-18">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                            </div>

                            <div class="terms-con-txt">
                              <h6 class="font-18">d. Getting Started</h6>
                              <p class="font-18">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.</p>
                            </div>
                        </div>
                    </div>  
                  </div> -->
                </div>
            </div>  
        </div> 
      <div class="modal right  fade" id="exampleModalToggle" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="notification_header">
                    <h2>Notifications</h2>
                    <p type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></p>

                </div>
                <div class="list_notification">

                    <div class="today_mgs">
                        <div class="day_list">
                            <h6>Today</h6>
                            <p>Mark all as read</p>
                        </div>
                        <div class="list_notification_innre not_open">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img1.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Justin Biber created a Event</h4>
                                <p> 2 Hours ago</p>
                            </div>
                        </div>
                        <div class="list_notification_innre not_open">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img2.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Right wing tree event is going to
                                    start in few mins, Get ready !!</h4>
                                <p> 5 Hours ago</p>
                            </div>
                        </div>
                    </div>
                    <div class="old_mgs">
                        <div class="day_list">
                            <h6>Today</h6>

                        </div>
                        <div class="list_notification_innre">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img1.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Ariyana grande cancelled the event</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre ">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img2.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img1.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre ">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img2.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img1.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre ">
                            <div class="img_noti"><img src="./assets/fan/images/notification-img2.png" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
      </div>
</section>
@endsection
@section('footer')
@endsection