@extends('fanweb.layouts.main')
@section('header')
<style>
      
</style>
@endsection
@section('content')
<section class="main_section">
    <div class="custom_container">
        <div class="event_list_section p-0 w-100 my_event">
            <div class="event_list_section_tab list-myevents">
              <h1 class="font-28 navgatePage custom_container my_event"> My Event</h1>
                <ul class="nav nav-pills " id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link active"
                        id="pills-home-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-home"
                        type="button"
                        role="tab"
                        aria-controls="pills-home"
                        aria-selected="true"
                      >
                      Upcoming Events
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button
                        class="nav-link"
                        id="pills-profile-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-profile"
                        type="button"
                        role="tab"
                        aria-controls="pills-profile"
                        aria-selected="false"
                      >
                      Past Events
                      </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content p-0" id="pills-tabContent">
              <div
                class="tab-pane fade show active"
                id="pills-home"
                role="tabpanel"
                aria-labelledby="pills-home-tab"
                tabindex="0"
              >
                <div class="event_tabe_section ">
                  {{-- <a href="./Event-Detail-Cancel.html"> --}}
                    @if(count($upcomingevent) > 0)
                    @foreach($upcomingevent as $ucevent)
                    <div class="event_card">
                        <img src="{{$ucevent['image']}}" alt="card" />
                        <div class="today_btn"></div>
                        <div class="event_card_bottom">
                        <div class="event_card_bottom_left">
                            <h3>{{$ucevent['event_title']}}</h3>
                            <div class="event-card-date">
                            <p>{{date('d F Y', strtotime($ucevent['date']))}}</p>
                            <?php
                                $date = DateTime::createFromFormat('H:i:s',$ucevent['time']);
                                $date->modify('+'.$ucevent['duration'].' minutes');
                            ?>
                            <li>{{date("g:i A", strtotime($ucevent['time']." UTC"))}} - {{$date->format('h:i A')}}</li>
                            </div>
                        
                        </div>
                        <div class="event_card_bottom_right">
                          <a href="{{route('scheduled-event',base64_encode($ucevent['event_id']))}}"><button>VIEW</button></a>
                        </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p>"No Upcoming Events For You"</p>
                    @endif
                  {{-- </a> --}}
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="pills-profile"
                role="tabpanel"
                aria-labelledby="pills-profile-tab"
                tabindex="0"
              >
              <div class="event_tabe_section pastevent-tab">
                @if(count($pastevent) > 0)
                @foreach($pastevent as $paevent)
                <div class="event_card">
                  <img src="{{$paevent['image']}}" alt="card" />
                  <div class="today_btn"></div>
                  <div class="event_card_bottom">
                    <div class="event_card_bottom_left">
                      <h3>{{$paevent['event_title']}}</h3><?php
                      $date = DateTime::createFromFormat('H:i:s',$paevent['time']);
                      $date->modify('+'.$paevent['duration'].' minutes');
                        ?>
                        <p>{{date("g:i A", strtotime($paevent['time']." UTC"))}} - {{$date->format('h:i A')}}</p>
                    </div>
                    <div class="event_card_bottom_right">
                      @if($paevent['eventreviewstatus'] == 0)
                      <button data-bs-toggle="modal" href="#exampleModal{{$paevent['event_id']}}" role="button">Review / Tip</button>
                      @else
                      <button class="reviwed_btn" >Reviewed</button>
                      @endif
                    </div>
                  </div>
                </div>
                
                <div class="modal fade rating-pop-up" id="exampleModal{{$paevent['event_id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title font-22" id="exampleModalLabel">Your Rating</h5>
                        {{-- <form action="{{ route('exitliveevent') }}" method="POST" autocomplete="off">
                          @csrf --}}
                        <div class="rating-sec">
                          <div class="rate">
                              <input type="hidden" name="event_id{{$paevent['event_id']}}" value="{{$paevent['event_id']}}">
                          <input type="radio" id="star5{{$paevent['event_id']}}" class="rate" name="rating{{$paevent['event_id']}}" value="5"/>
                                                            <label for="star5{{$paevent['event_id']}}" title="text">5 stars</label>
                                                            <input type="radio" id="star4{{$paevent['event_id']}}" class="rate" name="rating{{$paevent['event_id']}}" value="4"/>
                                                            <label for="star4{{$paevent['event_id']}}" title="text">4 stars</label>
                                                            <input type="radio" id="star3{{$paevent['event_id']}}" class="rate" name="rating{{$paevent['event_id']}}" value="3"/>
                                                            <label for="star3{{$paevent['event_id']}}" title="text">3 stars</label>
                                                            <input type="radio" id="star2{{$paevent['event_id']}}" class="rate" name="rating{{$paevent['event_id']}}" value="2">
                                                            <label for="star2{{$paevent['event_id']}}" title="text">2 stars</label>
                                                            <input type="radio" id="star1{{$paevent['event_id']}}" class="rate" name="rating{{$paevent['event_id']}}" value="1"/>
                                                            <label for="star1{{$paevent['event_id']}}" title="text">1 star</label>
                          </div>
                        </div>
                        <span class="error_msg" id="rating{{$paevent['event_id']}}"></span>
                        <h4 class="font-18">Share Your Thoughts</h4>
                        {{-- <div class="rat-content"> --}}
                          <textarea class="form-group" name="event_review" id="event_review{{$paevent['event_id']}}" cols="30" rows="5"></textarea>
                          <span class="error_msg" id="event_reviews{{$paevent['event_id']}}"></span>
                        {{-- </div> --}}
                        <button type="button" class="btn-close top-pos" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <h4 class="font-18">Leave a Tip</h4> 
                          <div class="rat-content rat-btn-flex">
                              <div class="content-wrapper">
                                  <input type="radio" name="tips{{$paevent['event_id']}}" id="" value="1" style="display: block">
                                  <button class="rat-con-btn">$1</button>
                              </div>
                              
                              <div class="content-wrapper">
                            <input type="radio" name="tips{{$paevent['event_id']}}" id="" value="5" style="display: block">
                            <button class="rat-con-btn">$5</button>
                              </div>
                              <div class="content-wrapper">
                            <input type="radio" name="tips{{$paevent['event_id']}}" id="" value="10" style="display: block">
                            <button class="rat-con-btn">$10</button>
                              </div>
                              <div class="content-wrapper">
                                  <input type="radio" name="tips{{$paevent['event_id']}}" id="" value="0" style="display: block">
                            <button class="rat-con-btn last-btn">Custom</button>
                              </div>
                          </div>                   
                      </div>
                      <div class="modal-footer premium-footer">
                        <button type="button" class="btn go-btn ms-0" id="rate" value="{{$paevent['event_id']}}">Submit</button>
                      </div> 
                  {{-- </form> --}}
                    </div>
                  </div>
              </div>
                
                @endforeach
                @else
                <p>"No Past Event For You"</p>
                @endif
              </div>
            </div>
            </div>
          </div>
        
    </div>
   
</section>

@endsection
@section('footer')
<script>
  $(document).on("click", "#rate", function (e) {
	  var eventsid = $(this).attr('value');
	  var eventidvalue = "input[name='event_id"+eventsid+"']";
          var event_id = $(eventidvalue).val();
	  var eventratingvalue = 'input[name="rating'+eventsid+'"]:checked';
          var rating = $(eventratingvalue).val();
          var event_review = $("#event_review"+eventsid).val();
	  
	   var eventtipvalue = 'input[name="tips'+eventsid+'"]:checked';
	   console.log(eventtipvalue);
          var tips = $(eventtipvalue).val();
	  console.log(tips)
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: "{{route('exitliveevent') }}",
             
                type: 'POST',
                data: {'event_id':event_id,'rating':rating,'event_review': event_review,'tips': tips}, // Setting the data attribute of ajax with form_data
                success: function (data) {
                    console.log(data)
                  var error_msg1  = data['message'];
                  if(data['status'] == 0){
                if(error_msg1['rating'] && error_msg1['rating'].length > 0){
                    var rating_error  = error_msg1['rating'][0];
                  $('#rating'+eventsid).html(rating_error);
                }else{
                  $('#rating'+eventsid).html('');
                }
                if(error_msg1['event_review'] && error_msg1['event_review'].length > 0){
                  var event_review_error  = error_msg1['event_review'][0];
                  $('#event_reviews'+eventsid).html(event_review_error);
                }else{
                  $('#event_reviews'+eventsid).html('');
                }
            }else{
                if(data['tipflag'] == 1){
                  var event_id = Base64.encode(data['event_id']);
                    var tipamount = Base64.encode(data['tipamount']);
                    console.log(event_id,tipamount);
                    location.replace('/fan/tips/'+event_id+'/'+tipamount);
                }else{

                    location.replace('/fan/fanhome');
                }
            }
               
                
                },
                error:function(data){
                  console.log(data);
                  
                }
            });
        });
</script>
@endsection