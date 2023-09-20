// Subscriptions 

document.querySelectorAll(".select-btn,.button_gorup button,.plan_preview_change h2").forEach((e) =>{
    e.addEventListener("click", (e)=>{
        document.querySelectorAll(".sub-main").forEach((e) => {
e.classList.toggle("show");
        })
    })
   
})


document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
      const dropZoneElement = inputElement.closest(".drop-zone");

      dropZoneElement.addEventListener("click", (e) => {
          inputElement.click();
      });

      inputElement.addEventListener("change", (e) => {
          if (inputElement.files.length) {
              updateThumbnail(dropZoneElement, inputElement.files[0]);
          }
      });

      dropZoneElement.addEventListener("dragover", (e) => {
          e.preventDefault();
          dropZoneElement.classList.add("drop-zone--over");
      });

      ["dragleave", "dragend"].forEach((type) => {
          dropZoneElement.addEventListener(type, (e) => {
              dropZoneElement.classList.remove("drop-zone--over");
          });
      });

      dropZoneElement.addEventListener("drop", (e) => {
          e.preventDefault();
          
          if (e.dataTransfer.files.length) {
              inputElement.files = e.dataTransfer.files;
              updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
          }

          dropZoneElement.classList.remove("drop-zone--over");
      });
  });

  /**
   * Updates the thumbnail on a drop zone element.
   *
   * @param {HTMLElement} dropZoneElement
   * @param {File} file
   */
  function updateThumbnail(dropZoneElement, file) {
      let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

      // First time - remove the prompt
      if (dropZoneElement.querySelector(".drop-zone__prompt")) {
          dropZoneElement.querySelector(".drop-zone__prompt").remove();
      }

      // First time - there is no thumbnail element, so lets create it
      if (!thumbnailElement) {
          thumbnailElement = document.createElement("div"); +
              thumbnailElement.classList.add("drop-zone__thumb"); dropZoneElement.appendChild(thumbnailElement);
      }

      thumbnailElement.dataset.label = file.name;

      // Show thumbnail for image files
      if (file.type.startsWith("image/")) {
          const reader = new FileReader();

          reader.readAsDataURL(file);
          reader.onload = () => {
              thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
          };
      } else {
          thumbnailElement.style.backgroundImage = null;
      }
  }

  var edit_section = document.querySelectorAll(".page_moving");
  var tab_content = document.querySelector(".tab-content");
  for (let i = 0; i < edit_section.length; i++){
    edit_section[i].addEventListener("click",function(){
      tab_content.classList.toggle("edit-input-filed")
  })
  }
  
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

});

const icons = document.querySelector('.icon'),
menu_list=document.querySelector('ul.nav_list')
 
  icons.addEventListener('click', () => {
    icons.classList.toggle("open");
    menu_list.classList.toggle("show");
  });


  



