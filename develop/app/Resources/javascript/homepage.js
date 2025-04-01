
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
    var $unlimitedContainer = $('.container__unlimited');
    var $jsunlimited = $('.js-unlimited');
    var $unlimitedContent = $('.container__unlimited .container_content__unlimited');
    var $unlimitedContainerLeft = $('.container_left__unlimited');
    var $unlimitedContentLeft = $('.container_left__unlimited .container_left_content__unlimited');
    var $pageContainer = $('.page-container');
    var $pageWrapper = $('.page-wrapper');
    var $spotlightWrapper = $('.spotlight__wrapper');
    var $spotlightTitle = $('.spotlight__title');
    var $spotlightCollapse = $('.spotlight__collapse');
    var $spotlightExpand = $('.spotlight__expand');
    var mainWrapWidth = 1440;
    var mainContWidth = 960;
    var spotlight_scroll = undefined;
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
        if ($jsunlimited.length) {
            var margin = Math.round((pageWrapperWidth - pageContainerWidth)/2);
            $jsunlimited.css({
                'margin-left': -margin,
		            'margin-right': -margin
            })
	     }
        if ($unlimitedContainer.length) {
            var margin = Math.round((pageWrapperWidth - pageContainerWidth)/2);
            $unlimitedContainer.css({
                'margin-left': -margin,
		            'margin-right': -margin
            })
	     }
	     if ($unlimitedContent.length) {
            var padding = Math.round((pageWrapperWidth - pageContainerWidth)/2);
            $unlimitedContent.css({
                'padding-left': padding,
                'padding-right': padding
            })
	     }
       if ($unlimitedContainerLeft.length) {
           var margin = Math.round((pageWrapperWidth - pageContainerWidth)/2);
           $unlimitedContainerLeft.css({
               'margin-left': -margin
           })
      }
      if ($unlimitedContentLeft.length) {
           var padding = Math.round((pageWrapperWidth - pageContainerWidth)/2);
           $unlimitedContentLeft.css({
               'padding-left': padding
           })
      }

  });

    $w.trigger('resize');

    var $infDynElements = $('.infographic-top__group > .infographic-top__teaser');
    var infDynElementTitleDefaultHeight = $infDynElements.first().find('.infographic-top__teaser-title').css('height');
    var infDynElementTitleNewHeight = infDynElementTitleDefaultHeight;
    $infDynElements.each(function() {
      var $el_title = $(this).find('.infographic-top__teaser-title');
      $el_title.css('height', 'auto');
      var el_title_height = $el_title.css('height');
      if (parseInt(infDynElementTitleNewHeight) < parseInt(el_title_height)) { infDynElementTitleNewHeight = el_title_height; }
    });
    $infDynElements.each(function() {
      $(this).find('.infographic-top__teaser-title').css('height', infDynElementTitleNewHeight);
    });

    if (!(bowser.mobile || bowser.tablet)) {
      if ($spotlightWrapper.length) {
        function initSpotlightScroll() {
          $spotlightExpand.show();
          $spotlightCollapse.hide();
          $spotlightWrapper.css('height','');
          spotlight_scroll = new PerfectScrollbar($spotlightWrapper[0], {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 16,
            maxScrollbarLength: 16
          });
          $spotlightWrapper[0].scrollTop = 0;
          $spotlightWrapper.find('.ps__rail-y').prepend('<div class="ps__rail-y-alt"></div>');
          var $spotlightRailYAlt = $('.ps__rail-y-alt');
          var $spotlightThumbY = $('.ps__thumb-y');
          $spotlightRailYAlt.css('height', $spotlightThumbY.css('top'));
          $spotlightWrapper[0].addEventListener('ps-scroll-y', function() {
            $spotlightRailYAlt.css('height', $spotlightThumbY.css('top'));
          });
          $.cookie('spotlightScrollIsActive', 'true', { path: '/', expires: 365 });
        }

        if ($.cookie('spotlightScrollIsActive') == 'true') {
          initSpotlightScroll();
        } else {
          $spotlightExpand.hide();
          $spotlightWrapper.css('height', 'auto');
        }

        $spotlightExpand.on('click tap', function(){
          spotlight_scroll.destroy();
          spotlight_scroll = null;
          $spotlightWrapper.css('height', 'auto');
          $spotlightExpand.hide();
          $spotlightCollapse.show();
          $.cookie('spotlightScrollIsActive', 'false', { path: '/', expires: 365 });
        });

        $spotlightCollapse.on('click tap', function(){
          initSpotlightScroll();
          $(window).scrollTop($spotlightTitle.offset().top);
        });
      }
    } else {
      $spotlightWrapper.css('height', 'auto');
      $spotlightExpand.hide();
      $spotlightCollapse.hide();
    }

    $('.popup-gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      tLoading: 'Загрузка',
      mainClass: 'mfp-img-mobile',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1],
        arrowMarkup: `
          <button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 52 52" fill="none">
              <path d="M24.001 8.91506L39.0859 24M24.001 39.0849L39.0859 24M39.0859 24L8.91602 24" stroke="currentColor" stroke-opacity="0.5" stroke-width="4"/>
            </svg>
          </button>
        `
      },
      image: {
        tError: 'Ошибка при загрузке изображения',
      },
      callbacks: {
        open: function() {
          $('.mfp-wrap').addClass('gallery-page-popup');
        },
      }
    });

    var magnificPopup = $.magnificPopup.instance;

    $('.fullscreen-button').on('click', function () {
      const gallerySlides = $('.gallery__slide');
      const activeSlide = gallerySlides.filter('.slick-active');
      const activeSlideIndex = gallerySlides.index(activeSlide);

      $('.popup-gallery').magnificPopup('open', activeSlideIndex);
    })
});
 