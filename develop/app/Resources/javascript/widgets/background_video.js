$(function () {
    var $w = $(window),
        $b = $('body'),
        $video = $('.background-video'),
        sourcemp4 = $video.find('source[type*="mp4"]').get(0),
        sourcewebm = $video.find('source[type*="webm"]').get(0),
        videoTag = $video.get(0),
        pageWrapperTop = $('.page-wrapper').offset().top + $('.top-panel-frame-wrp').height(),
        visibleViewport = $('.page-overlay').outerHeight() * .3,
        isPaused = false,
        isHidden = false,
        enableMouse = false,
        disableMouse = 'disable-mouse',
        videoPrefix = screen.width >= 1920 ? '/uploads/bg_timelaps/' : '/uploads/bg_timelaps_720p/',

        fadeDuration = 4000,
        playPause = 2000,
        fadeIn = function () {
            $video.fadeIn(fadeDuration);
        },
        fadeOut = function () {
            $video.fadeOut(fadeDuration);
        },

        daytimesVideos = [
            [
                {'mp4':'Rassvet.mp4', 'webm':'Rassvet.webm'}
            ],
            [
                {'mp4':'Pekin_KRUPNO.mp4', 'webm':'Pekin_KRUPNO.webm'},
                {'mp4':'Pekin_OBSH.mp4', 'webm':'Pekin_OBSH.webm'},
                {'mp4':'Triumfal\'naya-1.mp4', 'webm':'Triumfal\'naya-1.webm'},
                {'mp4':'Triumfal\'naya-2.mp4', 'webm':'Triumfal\'naya-2.webm'}
            ],
            [
                {'mp4':'Gopro_Gorky park-1.mp4', 'webm':'Gopro_Gorky park-1.webm'}
            ]
        ];


    // -------- init --------

    $video.fadeOut(1);

    for (var i = 0; i < daytimesVideos.length; i++) {
        daytimesVideos[i] = (function (daytimeVideos) {
            var currentVideo = daytimeVideos.length;

            return function () {
                currentVideo ++;
                if (currentVideo >= daytimeVideos.length) {
                    currentVideo = 0;
                }

                return daytimeVideos[currentVideo];
            };
        })(daytimesVideos[i]);
    }

    // -------- init --------

    var getVideo = function() {
        var hourNow = (new Date()).getHours(),
            videoI = 2;

        if (hourNow > 4) {
            if (hourNow < 10) {
                videoI = 0;
            } else if (hourNow < 20) {
                videoI = 1;
            }
        }

        return daytimesVideos[videoI]();
    };

    var playNextBackgroundVideo = function() {
        var source = getVideo();
        sourcemp4.src = videoPrefix + source.mp4;
        sourcewebm.src = videoPrefix + source.webm;
        videoTag.load();
        videoTag.play();
        videoTag.loop = false;
        videoTag.onloadedmetadata = function () {
            var videoDuration = Math.ceil(videoTag.duration * 1000);

            fadeIn();
            setTimeout(fadeOut, videoDuration - fadeDuration);

            setTimeout(playNextBackgroundVideo, videoDuration + playPause);
        };
    };

    playNextBackgroundVideo();

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

        if (!$.cookie('isHot')) {
            var viewportTop = $w.scrollTop();
            if (!isPaused && viewportTop >= pageWrapperTop) {
                videoTag.pause();
                isPaused = true;
            }
            if (isPaused && viewportTop <= pageWrapperTop) {
                videoTag.play();
                isPaused = false;
            }

            if (!isHidden && viewportTop >= visibleViewport) {
                $video.css({'display': 'none'});
                isHidden = true;
            }

            if (isHidden && viewportTop <= visibleViewport) {
                $video.css({'display': 'block'});
                isHidden = false;
            }
        }
    });
});