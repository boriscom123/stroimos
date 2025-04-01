
$(function () {
//    var $fadeContainer = $('.homepage-gallery__fadeout'),
//        $imageContainer = $('.homepage-gallery__image'),
//        $title = $('.homepage-gallery__meta-title'),
//        $count = $('.homepage-gallery__meta-count'),
//        $thumbs = $('.homepage-gallery__thumb');
//
//    $thumbs.on('click', function (e) {
//        var $this = $(this),
//            data = $this.data();
//
//        $fadeContainer.addClass('active');
//        $imageContainer
//            .attr({'href': data.href, 'style': 'background-image: url(' + data.image + ')', 'data-target': '#' + $this.attr('id'), 'data-image': data.image});
//        $title.text(data.title);
//        $count.text(data.count);
//
//        e.preventDefault();
//    });
//    $fadeContainer.on('transitionend', function () {
//        var $this = $(this);
//
//        if ($this.is('.active')) {
//            $this.removeClass('active').attr({'style': 'background-image: url(' + $imageContainer.attr('data-image') + ')'});
//            $thumbs.removeClass('hidden');
//            $($imageContainer.attr('data-target')).addClass('hidden');
//        }
//    });
//
//
//    // video
//    var tag = document.createElement('script'),
//        firstScriptTag = document.getElementsByTagName('script')[0];
//
//    tag.src = "https://www.youtube.com/iframe_api";
//    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
//
//    var $player = $('.homepage-player'),
//        $videoMeta = $('#video_meta'),
//        player,
//        destroyPlayer= function(){
//            if (player) {
//                player.destroy();
//                player = undefined;
//            }
//            $('#homepage-player').empty();
//        };
//
//    $player.on('click', function () {
//        var isYT = $player.attr('data-provider').indexOf('youtube') != -1;
//        if (isYT) {
//            if (!player) {
//                player = new YT.Player('homepage-player', {
//                    height: '400',
//                    width: '680',
//                    videoId: $player.attr('data-video-id'),
//                    playerVars: {
//                        autoplay: 1,
//                        autohide: 1
//                    }
//                });
//            } else {
//                player.loadVideoById($player.data('video-id'));
//            }
//        } else {
//            destroyPlayer();
//            $('#homepage-player').html('<video src="'+$player.attr('data-video-id')+'" controls="controls" autoplay class="homepage-video__html5"></video>')
//        }
//    });
//
//    $('.homepage-video__thumb').on('click', function (e) {
//        var $this = $(this),
//            data = $this.data();
//
//        e.preventDefault();
//        destroyPlayer();
//        $videoMeta.html($this.find('.homepage-video__meta').html());
//        $player
//            .attr({'style': 'background-image: url(' + data.image + ')', 'data-video-id': data.videoId, 'data-provider': data.provider});
//    });

    var $homeGalleryMain = $('.homepage-gallery__image .homepage-gallery__meta');
    var $pageContainer = $('.page-container');
    var $pageWrapper = $('.page-wrapper');
    var mainWrapWidth = 1440;
    var mainContWidth = 960;
    var $w = $(window);

    $w.on('resize', function() {
        var pageContainerWidth = $pageContainer.width();
        var pageWrapperWidth = $pageWrapper.width();

        if ($homeGalleryMain.length) {
            var left = Math.round((mainWrapWidth - mainContWidth - (pageWrapperWidth - pageContainerWidth))/2);
            $homeGalleryMain.css({
                'left': left
            })
        }
    })

    $w.trigger('resize');
});