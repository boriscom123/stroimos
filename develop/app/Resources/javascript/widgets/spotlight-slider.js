$(function () {
    $('.js-spotlight-slider').each(function () {
        console.log($(this).find('.js-slider').children().length);
        if ($(this).find('.js-slider').children().length < 4) {
            $(this).find('.js-controls').css('display', 'none');
        }
        $(this).find('.js-slider').slick({
            infinite: false,
            dots: false,
            adaptiveHeight: false,
            autoplay: false,
            autoplaySpeed: 5000,
            slidesToShow: 4,
            prevArrow: $(this).find('.js-prev-arrow'),
            nextArrow: $(this).find('.js-next-arrow'),
        });
        $(this).find('.js-slider').css('margin-right', '-20px')
    });
});