$(function() {
    var $bannerPopup = $('.slide-banner__popup').add('.pic');

    $bannerPopup.magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins',
        image: {
            verticalFit: false
        }
    });
});
