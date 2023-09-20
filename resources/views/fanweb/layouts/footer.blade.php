<footer>
<div class="modal right  fade" id="exampleModalToggle1" aria-hidden="true"
            aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <form method="post" action="{{route('advanceSearch')}}">
                        @csrf
                    <div class="notification_header">
                        <h2>Advance Search</h2>
                        <p type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></p>

                    </div>
                    <div class="list_notification">
                        <div class="seach_field">
                            <input type="text" placeholder="Search" name="ad_search"> 
                            <span><img src="{{asset('/assets/fan/images/search_icon.svg')}}" alt=""></span>
                        </div>
                        <div class="radio_section_header">
                            <div class="radio_section">
                                <input type="radio" name="ad_type"   value="events" id="event">
                                <label for="event">Events</label>
                            </div>
                            <div class="radio_section">
                                <input type="radio" name="ad_type" checked value="artists" id="artist">
                                <label for="artist">Artist</label>
                            </div>
                        </div>
                        <div class="bottom_section_rating">
                            <div class="checkBox_sction">
                                <input type="checkbox" name="ad_rating_checkbox" id="rating" value="1">
                                <label for="rating">Rating</label>
                                <input type="hidden" name="ad_rating_value" id="ad_rating_value">
                            </div>
                            <div class="Rating_star_section">
                                <p class="Rating_star" data-value="1">1 <span> <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M11.6815 4.29154L7.99251 3.72804L6.33901 0.206039C6.21551 -0.0569609 5.78401 -0.0569609 5.66051 0.206039L4.00751 3.72804L0.318514 4.29154C0.0155136 4.33804 -0.105486 4.70654 0.107014 4.92404L2.78701 7.67104L2.15351 11.5545C2.10301 11.863 2.43251 12.0945 2.70501 11.943L6.00001 10.122L9.29501 11.9435C9.56501 12.0935 9.89751 11.8665 9.84651 11.555L9.21301 7.67154L11.893 4.92454C12.1055 4.70654 11.984 4.33804 11.6815 4.29154Z"
                                            fill="currentColor" />
                                    </svg></p>
                                <p class="Rating_star" data-value="2"  name="2">2 <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M11.6815 4.29154L7.99251 3.72804L6.33901 0.206039C6.21551 -0.0569609 5.78401 -0.0569609 5.66051 0.206039L4.00751 3.72804L0.318514 4.29154C0.0155136 4.33804 -0.105486 4.70654 0.107014 4.92404L2.78701 7.67104L2.15351 11.5545C2.10301 11.863 2.43251 12.0945 2.70501 11.943L6.00001 10.122L9.29501 11.9435C9.56501 12.0935 9.89751 11.8665 9.84651 11.555L9.21301 7.67154L11.893 4.92454C12.1055 4.70654 11.984 4.33804 11.6815 4.29154Z"
                                            fill="currentColor" />
                                    </svg></p>
                                <p class="Rating_star" data-value="3">3 <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M11.6815 4.29154L7.99251 3.72804L6.33901 0.206039C6.21551 -0.0569609 5.78401 -0.0569609 5.66051 0.206039L4.00751 3.72804L0.318514 4.29154C0.0155136 4.33804 -0.105486 4.70654 0.107014 4.92404L2.78701 7.67104L2.15351 11.5545C2.10301 11.863 2.43251 12.0945 2.70501 11.943L6.00001 10.122L9.29501 11.9435C9.56501 12.0935 9.89751 11.8665 9.84651 11.555L9.21301 7.67154L11.893 4.92454C12.1055 4.70654 11.984 4.33804 11.6815 4.29154Z"
                                            fill="currentColor" />
                                    </svg></p>
                                <p class="Rating_star" data-value="4">4 <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M11.6815 4.29154L7.99251 3.72804L6.33901 0.206039C6.21551 -0.0569609 5.78401 -0.0569609 5.66051 0.206039L4.00751 3.72804L0.318514 4.29154C0.0155136 4.33804 -0.105486 4.70654 0.107014 4.92404L2.78701 7.67104L2.15351 11.5545C2.10301 11.863 2.43251 12.0945 2.70501 11.943L6.00001 10.122L9.29501 11.9435C9.56501 12.0935 9.89751 11.8665 9.84651 11.555L9.21301 7.67154L11.893 4.92454C12.1055 4.70654 11.984 4.33804 11.6815 4.29154Z"
                                            fill="currentColor" />
                                    </svg></p>
                                <p class="Rating_star" data-value="5">5 <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12" fill="none">
                                        <path
                                            d="M11.6815 4.29154L7.99251 3.72804L6.33901 0.206039C6.21551 -0.0569609 5.78401 -0.0569609 5.66051 0.206039L4.00751 3.72804L0.318514 4.29154C0.0155136 4.33804 -0.105486 4.70654 0.107014 4.92404L2.78701 7.67104L2.15351 11.5545C2.10301 11.863 2.43251 12.0945 2.70501 11.943L6.00001 10.122L9.29501 11.9435C9.56501 12.0935 9.89751 11.8665 9.84651 11.555L9.21301 7.67154L11.893 4.92454C12.1055 4.70654 11.984 4.33804 11.6815 4.29154Z"
                                            fill="currentColor" />
                                    </svg></p>
                            </div>
                            {{-- add this class to remove date filter for artist "event_div" --}}
                            <div class="checkBox_sction"> 
                                <input type="checkbox" name="ad_date" value="1" id="date">
                                <label for="date">Date & Time</label>
                            </div> 
                            <div class="seach_field"> 
                                <input id="" type="date"  name="ad_from_date"  placeholder="From Date" type="datetime">
                                {{-- <span><img src="{{asset('/assets/fan/images/calendar.svg')}}" alt=""></span> --}}
                            </div>
                            <div class="seach_field"> 
                                <input type="date" name="ad_to_date"  placeholder="To Date">
                                {{-- <span><img src="{{asset('/assets/fan/images/calendar.svg')}}" alt=""></span> --}}
                            </div>
                            {{-- <div class="seach_field form-section event_div"> 
                                <select name="ad_time" class="form-control" >
                                    <option value="">Select Time</option>
                                    <option value="11 AM" >11 AM</option>
                                    <option value="12 PM" >12 PM</option>
                                </select>

                                <span><img src="{{asset('/assets/fan/images/clock.svg')}}" alt=""></span>
                            </div> --}}
                            <div class="checkBox_sction event_div">
                                <input type="checkbox" value="1" name="ad_popular" id="Popular">
                                <label for="Popular">Most Popular</label>
                               
                            </div>
                            <div class="checkBox_sction ">
                                <input type="checkbox"  name="ad_genre_checkbox" value="1" id="genre">
                                <label for="genre">Genre</label>
                                <input type="hidden" name="ad_genre" id="ad_genre">
                            </div>
                            <div class="gender_section">
                                <p class="gender_lisr">Pop</p>
                                <p class="gender_lisr">Jazz</p>
                                <p class="gender_lisr">Hip hop</p>
                                <p class="gender_lisr">Blues</p>
                                <p class="gender_lisr">Dance pop </p>
                                <p class="gender_lisr">Techno</p>
                                <p class="gender_lisr">Classic</p>
                                <p class="gender_lisr">Melody</p>
                            </div>
                            <div class="button_section">
                                <button class="re_btn w-100" type="submit"><a>Search</a></button>
                            </div>
                            <a class="clear_navgat" data-bs-dismiss="modal" aria-label="Close" style="cursor:pointer">Clear</a>
                        </div>
                    </div>
                    </form>
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
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img1.png')}}" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Justin Biber created a Event</h4>
                                <p> 2 Hours ago</p>
                            </div>
                        </div>
                        <div class="list_notification_innre not_open"> 
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img2.png')}}" alt="">
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
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img1.png')}}" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Ariyana grande cancelled the event</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre "> 
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img2.png')}}" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre"> 
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img1.png')}}" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre"> 
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img2.png')}}" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre">
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img1.png')}}" alt="">
                            </div>
                            <div class="notification_text">
                                <h4>Your favorite artist event started</h4>
                                <p> 24 jan</p>
                            </div>
                        </div>
                        <div class="list_notification_innre ">
                            <div class="img_noti"><img src="{{asset('/assets/fan/images/notification-img2.png')}}" alt="">
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
  
<div class="footer">
    @if(auth()->user()->newsletter == 0)
    <div class="footer-news-letter-wraper">
        <div class="footer_newsletter">
        <div class="footer_newsletter_right"> 
            <div class="footer_newsletter_right_icon"><img src="{{asset('/assets/fan/images/verticalCard-rocket-icon.svg')}}"
                    alt="icon">
            </div>
            <div class="footer_newsletter_right_text">
                <h1>Join the Newsletter</h1>
                <p>Stay up to date with the latest news, announcements, and articles </p>
            </div>
        </div>
        
        <form class="footer_newsletter_form" action="{{ url('/fan/newsletter') }}" method="POST">
            @csrf
            @method("POST")
            <div class="footer_newsletter_form_input">
                {{-- @if(session()->has('success'))
                        <span class="text-success" style="margin-top: -49px;">{{session('success')}}</span>
                    @endif --}}
                {{-- <span>
                 <img src="{{asset('/assets/fan/images/Email.svg')}}" alt="">
                </span> --}}
                <input type="hidden" name="email" id="" value="{{auth()->user()->email}}">
                {{-- @if ($errors->has('email'))
                <span class="error_msg1">{{ $errors->first('email') }}</span><br>
                @endif --}}
            </div>
            
            <button type="submit">Subscribe</button>
           
        </form>
        <button class="Maybe">Maybe Later</button>
    </div>
    </div>
    @endif
    
    <div class="footer_logo mt-3"><img src="{{asset('/assets/fan/images/header_logo.png')}}" alt=""></div>
    <ul class="footer_manu">
        <li><a href="{{route('fanhome')}}">Home</a></li>
        <li><a href="{{ url('fan/about')}}">About</a></li>
        <li><a href="{{ url('fan/myevent')}}">My Events</a></li>
        <li><a href="{{route('editProfile')}}">Profile</a></li>
        <li><a href="">Go Ad Free now</a></li>
    </ul>
    <div class="footer_social_icon"><span><a href=""></a></span><span><a href=""></a></span><span><a
                href=""></a></span><span><a href=""></a></span></div>
    <div class="footer_policy">
        <p>©All Rights Reserved Colan Infotech | Terms &amp; Conditions | Privacy Policy</p>
    </div>
</div>
</footer>


