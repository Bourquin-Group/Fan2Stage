<div class="tab-pane fade {{ (request()->is('web/termscondition')) ? 'show active' : '' }}" id="v-pills-terms" role="tabpanel" aria-labelledby="v-pills-terms-tab" tabindex="0">
    <div class="tab-heading">
      <h1 class="font-28">{{ucfirst($termsandcondition['Title'])}}</h1>
    </div>
    <div class="terms-main">
      <div class="scroll-sec">   
          <div class="terms-con-txt">
              <p class="font-18">{{$termsandcondition['Description']}}</p>
          </div>
        </div>
    </div>                  
</div>