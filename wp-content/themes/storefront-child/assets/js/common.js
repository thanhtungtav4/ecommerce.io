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
    let html_appent= '<li class="c-menu c-menu__logo"><a href="#"><picture>'+
    '                  <source srcset="assets/images/logo.webp" type="image/webp"><img src="assets/images/logo.png" data-src="assets/images/logo.png" alt="logo">'+
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
