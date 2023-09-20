


  


$(document).ready(function(){  

    // eye icon 
    $('.eye-icon').click(function(){
            if($(this).prev().attr('type')== 'password'){
                $(this).prev().attr('type','text');
                $(this).find('#pw-close').hide();
                $(this).find('#pw-open').show();
            }
            else{
                $(this).prev().attr('type','password');
                $(this).find('#pw-close').show();
                $(this).find('#pw-open').hide();
            }        
    });
    // hamberger
    $(".menu_icon").click(function () {
        $(".nav_list").toggleClass("show");
        $(this)
          .toggleClass("opened")
          .setAttribute("aria-expanded", this.classList.contains("opened"));
      });


      $(".page_moving").click(()=>{
        $(".profiletab-wrapper").addClass("edit-input-filed");
      })
      $(".page-move-cancel").click(()=>{
        $(".profiletab-wrapper").removeClass("edit-input-filed");
      })
      $(".subscribe-btn").click(()=>{
        $(".profilegotofree").addClass("edit-gotoinput");
        
      })
      $(".gotocancelbutton").click(()=>{
        $(".profilegotofree").removeClass("edit-gotoinput");
      })


      $("#add-class").click(() => {
        $(".profiletab-wrapper").removeClass("edit-input-filed");
        $(".billing-form").addClass("edit-input-section");
        $(".billing-align").addClass("edit-input-section");
      });
  
      $(".remove-class").click(() => {
        $(".billing-form").removeClass("edit-input-section");
        $(".billing-align").removeClass("edit-input-section");
      });

});

var uploaderBtn = document.querySelector("#profile_fan")
uploaderBtn.addEventListener("change", function (event) {
  console.log(src,preview ,"text")
if (event.target.files.length > 0) {
  var src = URL.createObjectURL(event.target.files[0]);
  var preview = (document.querySelector(".imgs").src = src);
  console.log(src,preview ,"text")
}
});

const icons = document.querySelector('.icon'),
menu_list=document.querySelector('ul.nav_list')
 
  icons.addEventListener('click', () => {
    icons.classList.toggle("open");
    menu_list.classList.toggle("show");
  });





