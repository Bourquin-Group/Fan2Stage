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
            
                  <div class="tab-pane show active "  id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-terms-tab" tabindex="0">
                      <div class="tab-heading">
                        <h1 class="font-28">{{ucfirst($aboutus['Title'])}}</h1>
                      </div>
                      <div class="terms-main">
                      <div class="scroll-sec">                      
                          <div class="terms-con-txt">
                              <p class="font-18">{!! $aboutus['Description'] !!}</p>
                          </div>          
                      </div>
                    </div>               
                  </div>
                  <!-- END -->
                
                </div>
            </div>  
        </div> 
     
</section>
@endsection
@section('footer')
@endsection