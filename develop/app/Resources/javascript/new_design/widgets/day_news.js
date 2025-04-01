$(function () {

    var $dayNews = $('.day-news__list').slick({
        dots: false,
        arrows: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'ease-in-out'
    });

    $('.day-news__list-item-title').dotdotdot({
        wrap: 'word',
        height: 19*5
    });

    $('.day-news__header-pager a').on('click', function(e) {
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            $(this).parent().find('a').removeClass('active');
            $(this).addClass('active');
            $(this).closest('.day-news').find('.day-news__list').slick('slickNext');
        }
    });

    //var $dayNews = $('.day-news__list').bxSlider({
    //    mode: 'fade', pagerCustom: '#dayNewsPager', controls: false
    //});
//
    //if ($dayNews.length) {
    //    (function ($dayNews) {
    //        setTimeout(function () {
    //            $dayNews.redrawSlider();
    //        }, 100);
    //    })($dayNews);
    //}  // временно!!!
})