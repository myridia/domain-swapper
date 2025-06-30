jQuery(document).ready(function($){

    /* STICKY / BACK TO TOP */
    var addtocart_btn = $('.addtocart_btn');
    $(window).scroll(function() {
        if ($(this).scrollTop() > 250) {
           
            addtocart_btn.css({bottom:"65px"});
            //$( ".main-menu-wrap" ).addClass( "stickymenu" );
        } 
        else {
           
            addtocart_btn.css({bottom:"-300px"});
            //$( ".main-menu-wrap" ).removeClass( "stickymenu" );
        }
    });
    
    
    /* New sticky menu */
    const navbar = document.querySelector('.main-menu-wrap');
    let top = navbar.offsetTop;
    function stickynavbar() {
      if (window.scrollY >= top) {    
        navbar.classList.add('stickymenu');
      } else {
        navbar.classList.remove('stickymenu');    
      }
    }
    window.addEventListener('scroll', stickynavbar);
    
    
});