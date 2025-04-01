$(function() {
    var $panoramaPopup = $('.panorama-popup');

    $panoramaPopup.magnificPopup({
        type: 'iframe',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-panorama'
    });
});