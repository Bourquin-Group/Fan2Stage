<div class="tab-pane fade {{ (request()->is('web/privacypolicy')) ? 'show active' : '' }}" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
  <div class="tab-heading">
    <h1 class="font-28">{{ucfirst($privacypolicy['Title'])}}</h1>
  </div>
  <div class="terms-main">
    <div class="scroll-sec">   
          <div class="terms-con-txt">
              <p class="font-18">{!! $privacypolicy['Description'] !!}</p>
          </div>
      </div>
  </div>  
</div>