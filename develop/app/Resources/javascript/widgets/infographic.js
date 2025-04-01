$(function() {
    var $listElem = $('.infographics-block__text');

    if ($listElem.length) {
        $listElem.dotdotdot();
    }

    var $infographicPopup = $('.infographics-img__popup').add('.pic');

    $infographicPopup.magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom',
        image: {
            verticalFit: false
        },
        zoom: {
            enabled: true,
            duration: 300
        }
    });
});