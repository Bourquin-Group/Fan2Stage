<div class="tab-pane fade {{ (request()->is('web/aboutus')) ? 'show active' : '' }}" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">
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