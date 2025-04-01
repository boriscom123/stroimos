$(function () {
    $('.announcements').each(function () {
        $(this).slick({
            dots: true,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 5000
        });
    });

});
