$(function () {
    var $w = $(window),
        $b = $('body'),
        $video = $('.background-video'),
        pageWrapperTop = $('.page-wrapper').offset().top + $('.top-panel-frame-wrp').height(),
        visibleViewport = $('.page-overlay').outerHeight() * .3,
        isPaused = false,
        isHidden = false,
        enableMouse = false,
        disableMouse = 'disable-mouse';

    if ($.cookie('isHot')) {
        $video.add('.background-video__overlay').remove();
    }

    $(document).on('keydown', function (e) {
        if (e.shiftKey && e.keyCode == 83) { // STOP (shift + s)
            $.cookie('isHot', 'yes');
            $video.remove();
        }
        if (e.shiftKey && e.keyCode == 80) { // PLAY (shift + p)
            $.removeCookie('isHot');
        }
    });

    $(document).on('scroll', function () {
        if (!$b.hasClass(disableMouse)) {
            clearTimeout(enableMouse);
            $b.addClass(disableMouse);
        }

        enableMouse = setTimeout(function () {
            $b.removeClass(disableMouse)
        }, 500);

        //if (!$.cookie('isHot')) {
        //    var viewportTop = $w.scrollTop();
        //    if (!isPaused && viewportTop >= pageWrapperTop) {
        //        $video.get(0).pause();
        //        isPaused = true;
        //    }
        //    if (isPaused && viewportTop <= pageWrapperTop) {
        //        $video.get(0).play();
        //        isPaused = false;
        //    }
//
        //    if (!isHidden && viewportTop >= visibleViewport) {
        //        $video.css({'display': 'none'});
        //        isHidden = true;
        //    }
//
        //    if (isHidden && viewportTop <= visibleViewport) {
        //        $video.css({'display': 'block'});
        //        isHidden = false;
        //    }
        //}
    });
});