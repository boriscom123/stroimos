$(function () {
  if ($('.zd-block-list__right').length > 0) {
    $('.zd-block-list__right').slick({
      infinite: true,
      slidesToShow: 2,
      slidesToScroll: 1,
      prevArrow: ''
    });
  }
})
