$(function () {
    if ($('.top-news.animated').length) {
      var $topNewsWrapper = $('.top-news.animated'),
          $topNews = $('.top-news__section[data-background]'),
          $bgTopNews = $('.top-news__bg-in, .top-news__bg-out'),
          setBg = function(data){
              $bgTopNews.not('.active').css({'background-image': 'url(' + data.url + ')'});
              $bgTopNews.toggleClass('active');
              $topNews.removeClass('active');
              $topNews.eq(data.ind).addClass('active');
          };

      var sliderTopNews = {
          timeout: 0,
          time: 5000,
          slide: 0,
          slides: ($topNews.length - 1),
          startSlider: function(skipOnce) {
              var self = this;

              if (!skipOnce) {
                  setBg(self.getSlide());
              }

              self.timeout = setTimeout(function () {
                  self.startSlider();
                  //console.log(self.getSlide, new Date());
              }, self.time);
          },
          stopSlider: function(slideIndex) {
              var self = this;

              clearTimeout(self.timeout);
              setBg(self.getSlide(slideIndex));
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

              //console.log(self.slide, new Date());

              return {
                  url: $topNews.eq(self.slide).attr('data-background'),
                  ind: self.slide
              };
          }
      };

      sliderTopNews.startSlider(true);

      $topNews.on('mouseenter', function () {
          //console.log($topNews.index(this));
          sliderTopNews.stopSlider($topNews.index(this));
      });

      $topNewsWrapper.on('mouseleave', function(){
          sliderTopNews.startSlider(true);
      });
    }
    
    $('[data-add-scrollbar]').each(function(index) {
        var $topNewsMoreWrapper = $(this);
        var spotlight_scroll = new PerfectScrollbar($topNewsMoreWrapper[0], {
          wheelSpeed: 2,
          minScrollbarLength: 40,
        });
    });
});
