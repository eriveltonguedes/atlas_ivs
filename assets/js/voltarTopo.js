$(document).ready(function() {
    $(".voltarTopo").hide();
    $(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('.voltarTopo').fadeIn();
            }
            else {
                $('.voltarTopo').fadeOut();
            }
        });
        $('.voltarTopo').click(function() {
            $('body,html').animate({scrollTop: 0}, 600);
        });
    });
});