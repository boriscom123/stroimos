$(function () {

    var $dayNews = $('.day-news__list').slick({
        arrows: true,
        infinite: false,
        speed: 500,
        cssEase: 'ease-in-out',
        slidesToShow: 3,
        slidesToScroll: 3
    });

    $('.day-news__item-title').dotdotdot({
        wrap: 'word',
        height: 15*3
    });

    var $newDayNews = $('.new-day-card-list').slick({
        arrows: true,
        infinite: false,
        speed: 500,
        cssEase: 'ease-in-out',
        slidesToShow: 4,
        slidesToScroll: 4
    });
})
