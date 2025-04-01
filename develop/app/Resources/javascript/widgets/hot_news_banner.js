$(function() {
    var $headers = $('.hot-news__animated-banner-content');

    if($headers.length <= 1) {
        return;
    }

    var $titles = $('.hot-news__animated-banner-title'),
        $hotNewsBanner = $('.hot-news__animated-banner'),
        duration = 400,
        topMargin = $($headers.get(1)).css('marginTop');

    var fitHeaderText = function(el){
      textFit(el, {minFontSize: 17, maxFontSize: 30})
    }

    var setBanner = function(data){
        $titles.filter('.active').fadeOut(duration, function() {
            $(this).removeClass('active');
            var $title = $($titles.get(data));
            $title.addClass('active');
            $title.fadeIn(duration);
        });

        var activeHeader = $headers.filter('.active');
        activeHeader.animate(
            {
                marginTop: topMargin,
                opacity: 0
            },
            duration,
            function() {
                activeHeader.removeClass('active');
                activeHeader.hide();
                var $header = $($headers.get(data));
                $header.show();
                fitHeaderText($header[0]);
                $header.addClass('active');
                $header.fadeIn(duration);
                $header.animate({marginTop: '0px', opacity: 1}, duration);

            }
        );
    };

    var sliderBanners = {
        timeout: 0,
        time: 4000,
        slide: 0,
        slides: ($headers.length - 1),
        startSlider: function(skipOnce) {
            var self = this;

            if (!skipOnce) {
                setBanner(self.getSlide());
            }

            self.timeout = setTimeout(function () {
                self.startSlider();
            }, self.time);
        },
        stopSlider: function() {
            var self = this;

            clearTimeout(self.timeout);
        },
        getSlide: function(slideIndex) {
            var self = this;

            if (slideIndex === undefined) {
                self.slide += 1;

                if (self.slide > self.slides) {
                    self.slide = 0;
                }
            } else {
                self.slide = slideIndex;
            }

            return self.slide;
        }
    };

    sliderBanners.startSlider(true);
    fitHeaderText($headers.first()[0]);

    $hotNewsBanner.on('mouseenter', function () {
        sliderBanners.stopSlider();
    });

    $hotNewsBanner.on('mouseleave', function(){
        sliderBanners.startSlider(true);
    });
});
