if ('loading' in HTMLImageElement.prototype) {
  const images = document.querySelectorAll('img[loading="lazy"]');
  images.forEach(img => {
    img.src = img.dataset.src;
  });
} else {
  // Dynamically import the LazySizes library
  const script = document.createElement('script');
  script.src =
    'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
  document.body.appendChild(script);
};
window.onscroll = function(e) {
  if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
      console.log(121);
  }
};
function toggleMenu(){
    let menu = document.getElementsByClassName("c-header");
    menu[0].classList.toggle("js-active");
    document.body.classList.toggle("js-active");
    let html_appentlose = '<li class="c-menu c-menu__close" onclick="toggleMenu()" ><svg'+
    '  width="24"'+
    '  height="24"'+
    '  viewBox="0 0 24 24"'+
    '  fill="none"'+
    '  xmlns="http://www.w3.org/2000/svg"'+
    '>'+
    '  <path'+
    '    d="M16.3394 9.32245C16.7434 8.94589 16.7657 8.31312 16.3891 7.90911C16.0126 7.50509 15.3798 7.48283 14.9758 7.85938L12.0497 10.5866L9.32245 7.66048C8.94589 7.25647 8.31312 7.23421 7.90911 7.61076C7.50509 7.98731 7.48283 8.62008 7.85938 9.0241L10.5866 11.9502L7.66048 14.6775C7.25647 15.054 7.23421 15.6868 7.61076 16.0908C7.98731 16.4948 8.62008 16.5171 9.0241 16.1405L11.9502 13.4133L14.6775 16.3394C15.054 16.7434 15.6868 16.7657 16.0908 16.3891C16.4948 16.0126 16.5171 15.3798 16.1405 14.9758L13.4133 12.0497L16.3394 9.32245Z"'+
    '    fill="currentColor"'+
    '  />'+
    '  <path'+
    '    fill-rule="evenodd"'+
    '    clip-rule="evenodd"'+
    '    d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"'+
    '    fill="currentColor"'+
    '  />'+
    '</svg>'+
    '              </li>';
    let html_appent= '<li class="c-menu c-menu__logo"><a href="/"><picture>'+
    '                  <source srcset="/wp-content/themes/storefront-child/assets/images/caras_logo.webp" type="image/webp"><img src="/wp-content/themes/storefront-child/assets/images/caras_logo.png" data-src="/wp-content/themes/storefront-child/assets/images/caras_logo.png" alt="logo caras">'+
    '                </picture></a>'+
    '              </li>';
    let html_appentLang = '<li class="c-menu c-menu__logo"><a href="#">Tiếng Việt</a>'+
    '              </li>';
    let is_true =  document.getElementsByClassName("c-menu__logo")[0];
    if(is_true == undefined){


      let select_appent = document.getElementsByClassName("c-header_menu")[0];
      select_appent.insertAdjacentHTML("afterbegin", html_appent);
      select_appent.insertAdjacentHTML("beforeend", html_appentLang);
      select_appent.insertAdjacentHTML("afterbegin", html_appentlose);
    }

}
// only product detail
function toggleVariations(){
  const is_true = document.getElementsByClassName("js_hide");
  const is_toggle = document.getElementsByClassName("fold");
  if(is_true.length >= 1){
    document.getElementsByClassName('js_down')[0].classList.add('d-none');
    document.getElementsByClassName('js_up')[0].classList.remove('d-none');
    for (const item of is_toggle){
        item.classList.remove("js_hide");
    }
  }
  else{
    document.getElementsByClassName('js_up')[0].classList.add('d-none');
    document.getElementsByClassName('js_down')[0].classList.remove('d-none');
    for (const item of is_toggle){
      item.classList.add("js_hide");
    }
  }
}
function toggleChat(){
  let chat = document.getElementsByClassName("m-chat_inner");
  chat[0].classList.toggle("js-active");
  if ($('.m-chat_inner').hasClass('js-active')) {
    setTimeout(function(){
      $('.overlay-welcome').fadeOut();
    }, 3000);
  }
}
///
jQuery.event.special.touchstart = {
  setup: function( _, ns, handle ) {
      this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
  }
};
jQuery.event.special.touchmove = {
  setup: function( _, ns, handle ) {
      this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
  }
};
jQuery.event.special.wheel = {
  setup: function( _, ns, handle ){
      this.addEventListener("wheel", handle, { passive: true });
  }
};
jQuery.event.special.mousewheel = {
  setup: function( _, ns, handle ){
      this.addEventListener("mousewheel", handle, { passive: true });
  }
};

let positionBf = $(window).scrollTop();
$(window).scroll(function(){
  let positionAf = $(this).scrollTop();
  if( positionAf <= 150){
      document.getElementsByClassName("c-header")[0].classList.remove("js_scroll");
  }
  else{
    if(positionBf >= 85){
      document.getElementsByClassName("c-header")[0].classList.add("js_scroll");
    }
  }
  positionBf = positionAf;
});

///
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

 function showTab(n) {
//   // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
//   // console.log(x[n]);

//   //... and fix the Previous/Next buttons:
//   // if (n == 0) {
//   //   document.getElementById("prevBtn").style.display = "none";
//   // } else {
//   //   document.getElementById("prevBtn").style.display = "inline";
//   // }
//   // if (n == (x.length - 1)) {
//   //   document.getElementById("nextBtn").innerHTML = "Submit";
//   // } else {
//   //   document.getElementById("nextBtn").innerHTML = "Next";
//   // }
//   //... and run a function that will display the correct step indicator:
//   //fixStepIndicator(n)
 }
function nextPrev(Tabcurrent){
  let inputCurrent = $(Tabcurrent).find("input:checked").val();
  console.log('tab-'+ inputCurrent);
  if(inputCurrent == undefined){
    //hide current tab
    $(Tabcurrent).css({"display": "none"});
    $('.tab-giam-do-can').css({"display": "block"});
   }
  else{
    $(Tabcurrent).css({"display": "none"});
    $('.tab-'+ inputCurrent).css({"display": "block"});
  }
}

// function nextPrev(n) {
//   // This function will figure out which tab to display
//   var x = document.getElementsByClassName("tab");
//   //console.log(x);
//   // Exit the function if any field in the current tab is invalid:
//   if (n == 1 && !validateForm()) return false;
//   controlShow();
//   // Hide the current tab:
//   x[currentTab].style.display = "none";
//   // Increase or decrease the current tab by 1:
//   currentTab = currentTab + n;
//   // if you have reached the end of the form...
//   if (currentTab >= x.length) {
//     // ... the form gets submitted:
//     document.getElementById("regForm").submit();
//     return false;
//   }
//   // Otherwise, display the correct tab:
//   showTab(currentTab);
// }

// function validateForm() {
//   // This function deals with validation of the form fields
//   var x, y, i, valid = true;
//   x = document.getElementsByClassName("tab");
//   y = x[currentTab].getElementsByTagName("input");
//   // A loop that checks every input field in the current tab:
//   for (i = 0; i < y.length; i++) {
//     // If a field is empty...
//     if (y[i].value == "") {
//       // add an "invalid" class to the field:
//       y[i].className += " invalid";
//       // and set the current valid status to false
//       valid = false;
//     }
//   }
//   // If the valid status is true, mark the step as finished and valid:
//   if (valid) {
//     //document.getElementsByClassName("step")[currentTab].className += " finish";
//   }
//   return valid; // return the valid status
// }
// function controlShow(){

//   const dataTab = $("input[type=radio]:checked");
//   console.log(dataTab.data('tab'));
//   // var is_Tab = $(".tab");
//   // is_Tab.forEach(function(tab) {
//     // console.log(tab);
//     // debugger;
//   // })
//   // const is_check = is_Tab[currentTab].getElementsByTagName("input");
//   // console.log(is_check);
// }
// $('#regForm').submit(function() {
//   console.log($(this).serialize());
//   return false;
// });
$(document).ready(function() {
  var tabArray = ['#tab-welcome'];
  $('.js-chatbot .tab').each(function(){
    var _this = $(this);
    _this.find('.btn-next').click(function(){
      var screenValue = _this.find('.radiobtn input:checked').data('value');
      tabArray.push(screenValue);
      $('.js-chatbot .tab').hide();
      $('.js-chatbot .tab' + screenValue).show();
    })
    _this.find('#prevBtn').click(function(){
      var screenBack = tabArray[tabArray.length - 2];
      tabArray.pop();
      $('.js-chatbot .tab').hide();
      $('.js-chatbot .tab' + screenBack).show();
      if($.isEmptyObject(tabArray)) {
        tabArray.push('#tab-welcome');
      }
    })
  })
});