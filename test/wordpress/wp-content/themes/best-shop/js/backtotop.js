jQuery(document).ready(function($){

    /* STICKY / BACK TO TOP */
    var scrollup = $('.backtotop');
    $(window).scroll(function() {
        if ($(this).scrollTop() > 250) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-250px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });
    
    
});