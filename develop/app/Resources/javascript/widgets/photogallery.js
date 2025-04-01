$(function () {

    var Gallery = function ($gallery) {
        var unicID = (function () {
            var id, num = 1;
            id = function (prefix) {
                return (prefix || 'gallery') + (+new Date()) + (num++);
            };
            return function (prefix) {
                return id(prefix);
            }
        })();

        this.fullscreenElt = $gallery.closest('.gallery__wrapper').get(0);
        this.$fullscreenBtn = $gallery.find('.gallery__fullscreen');
        this.$closeBtn = $gallery.prev('.gallery__close');
        this.$downloadBtn = $gallery.find('.gallery__download');
        this.$linkBtn = $gallery.find('.gallery__get-btn');
        this.$copyWidget = $gallery.find('.gallery__copy-link');
        this.isFillMode = $gallery.data('count') > this.visibleThumbs;
        this.initialSlide = 0;

        this.id = unicID('gallery__' + $gallery.data('id'));
        this.sliderID = this.id + '-slider';
        this.pagerID = this.id + '-pager';

        this.$gallery = $gallery.attr('id', this.id);
        this.$slider = $gallery.find('.gallery__slider').attr('id', this.sliderID);
        this.$pager = $gallery.find('.gallery__pager').attr('id', this.pagerID);

        if ($gallery.data('count') > 1) {
            this.init();
        }
    };

    var GalleryWithCustomArrows = function ($gallery) {
        var unicID = (function () {
            var id, num = 1;
            id = function (prefix) {
                return (prefix || 'gallery') + (+new Date()) + (num++);
            };
            return function (prefix) {
                return id(prefix);
            }
        })();

        this.fullscreenElt = $gallery.closest('.gallery__wrapper').get(0);
        this.$fullscreenBtn = $gallery.find('.gallery__fullscreen');
        this.$closeBtn = $gallery.prev('.gallery__close');
        this.$downloadBtn = $gallery.find('.gallery__download');
        this.$linkBtn = $gallery.find('.gallery__get-btn');
        this.$copyWidget = $gallery.find('.gallery__copy-link');
        this.isFillMode = $gallery.data('count') > this.visibleThumbs;
        this.initialSlide = 0;

        this.id = unicID('gallery__' + $gallery.data('id'));
        this.sliderID = this.id + '-slider';
        this.pagerID = this.id + '-pager';

        this.$gallery = $gallery.attr('id', this.id);
        this.$slider = $gallery.find('.gallery__slider').attr('id', this.sliderID);
        this.$pager = $gallery.find('.gallery__pager').attr('id', this.pagerID);

        if ($gallery.data('count') > 1) {
            this.init();
        }
    };

    Gallery.prototype = {
        visibleThumbs: 7,
        activeClass: 'slick-center',
        getOptions: function (target) {
            var options = {
                    slidesToScroll: 1, // листать по 1 слайду
                    cssEase: 'ease-in-out',
                    waitForAnimate: true,
                    initialSlide: this.initialSlide
                },
                sliderOpts = {
                    lazyLoad: 'ondemand', // дозагрузка изображений по требованию
                    centerMode: true, // текущий слайд всегда в середине
                    centerPadding: (!!document.fullscreenElement ? '0px' : '100px'), // области в которых видно пред/след слайд
                    slidesToShow: 1, // сколько слайдов показывать в центральной области (ширина окна слайдера минус centerPadding)
                    asNavFor: '#' + this.pagerID // класс или ид элемента используемого в качестве пейджера
                },
                pagerOpts = {
                    centerMode: this.isFillMode, // текущий слайд всегда в середине
                    centerPadding: '95px', // области в которых видно пред/след слайд (в нашем случае на эту область я накладывыю кнопки)
                    slidesToShow: this.visibleThumbs, // сколько слайдов в центральной области.
                    asNavFor: '#' + this.sliderID, // класс или ид элемента используемого в качестве пейджера (у нас двусторонння свзяь)
                    focusOnSelect: true // перемещаться к сладу при клике на него (в т.ч. листает связанный слайдер)
                };

            return $.extend(true, {}, options, (target == 'slider' ? sliderOpts : pagerOpts));
        },
        initFullscreen: function () {
            var _this = this;
            if (!this.$fullscreenBtn.length) return;

            if (typeof document.exitFullscreen !== 'undefined' && window.outerWidth > 800) {
                this.$fullscreenBtn.add(this.$closeBtn).off('click').on('click', function () {
                    _this.fullscreen();
                });

                $(document).off('fullscreenchange').on('fullscreenchange', function () {
                    var $b = $('body');
                    _this.$pager.slick('unslick');
                    _this.$slider.slick('unslick');

                    if (!!document.fullscreenElement) {
                        $b.addClass('fullscreen');
                        _this.$gallery.find('.gallery__buttons').hide();
                        _this.$pager.hide();
                        _this.initSlider();
                    } else {
                        $b.removeClass('fullscreen');
                        _this.$gallery.find('.gallery__buttons').show();
                        _this.$pager.show();
                        _this.initSlider();
                        _this.initPager();
                    }
                });
            } else {
                this.$fullscreenBtn.hide();
            }
        },
        fullscreen: function () {
            if (!!document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                this.fullscreenElt.requestFullscreen();
            }
        },
        initSlider: function () {
            var _this = this,
                $title = this.$gallery.find('.gallery__title'),
                $teaser = this.$gallery.find('.gallery__teaser'),
                $tags = this.$gallery.find('.gallery__tags'),
                $index = this.$gallery.find('.gallery__index>i'),
                sliderOptions = this.getOptions('slider');

            this.$slider
                .on('init', function (event, slick) {
                    _this.initFullscreen();
                })
                .on('beforeChange', function (event, slick, currentSlide, nextSlide) { // эвент перед пролистыванием
                    var $image = slick.$slides.eq(nextSlide).find('img'),
                        title = $image.attr('title'),
                        teaser = $image.attr('data-teaser'),
                        tags = $image.attr('data-tags'),
                        link = $image.attr('src');
                    $title.text(title);
                    $teaser.text(teaser);
                    $tags.html(tags);
                    $index.text(nextSlide + 1);
                    _this.$downloadBtn.attr('href', link);
                    _this.initialSlide = nextSlide;

                    _this.toggleCopyWidget(true);

                    if (!_this.isFillMode) {
                        _this.$pager.find('.gallery__thumb').removeClass(_this.activeClass).eq(nextSlide).addClass(_this.activeClass);
                    }
                })
                .slick(sliderOptions);
        },
        initPager: function () {
            var _this = this,
                pagerOptions = this.getOptions('pager');
            this.$pager
                .on('init', function (event, slick) {
                    if (!_this.isFillMode) {
                        slick.$slides.eq(_this.initialSlide).addClass(_this.activeClass);
                    }
                })
                .slick(pagerOptions)
                .toggleClass('gallery__pager-fixed', !this.isFillMode);
        },
        toggleCopyWidget: function(hide){
            var slick = this.$slider.slick('getSlick'),
                // link = this.$linkBtn.data('base-url') + slick.$slides.eq(slick.currentSlide).find('img').attr('src'),
                link = slick.$slides.eq(slick.currentSlide).find('img').attr('src'),
                $linkInput = this.$copyWidget.find('input[type=text]');
            this.$copyWidget.toggleClass('hidden', !!hide);
            this.$linkBtn.toggleClass('hidden', !hide);
            if (!hide){
                $linkInput.val(link).select();
            } else{
                $linkInput.val('');
            }
        },
        initCopyWidget: function () {
            var _this = this,
                $copyButton = this.$copyWidget.find('button[type=button]'),
                $linkInput = this.$copyWidget.find('input[type=text]');

            this.$linkBtn.on('click', function () {
                _this.toggleCopyWidget();
            });

            $copyButton.on('click', function () {
                _this.toggleCopyWidget(true);
            });

            $linkInput.on('click',function(){
                $(this).select();
            })
        },
        init: function () {
            this.initSlider();
            this.initPager();
            this.initCopyWidget();
        }
    };

    GalleryWithCustomArrows.prototype = {
        visibleThumbs: 7,
        activeClass: 'slick-center',
        getOptions: function (target) {
            var options = {
                    slidesToScroll: 1, // листать по 1 слайду
                    cssEase: 'ease-in-out',
                    waitForAnimate: true,
                    initialSlide: this.initialSlide,
                    prevArrow: `<button type="button" data-role="none" class="slick-prev slick-arrow" aria-label="Previous" role="button" style="display: block;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 4.45753L4.45754 12M12 19.5425L4.45754 12M4.45754 12L19.5425 12" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </button>`,
                    nextArrow: `<button type="button" data-role="none" class="slick-next slick-arrow" aria-label="Next" role="button" style="display: block;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 4.45753L19.5425 12M12 19.5425L19.5425 12M19.5425 12L4.45752 12" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </button>`
                },
                sliderOpts = {
                    lazyLoad: 'ondemand', // дозагрузка изображений по требованию
                    centerMode: true, // текущий слайд всегда в середине
                    centerPadding: '0px', // области в которых видно пред/след слайд
                    slidesToShow: 1, // сколько слайдов показывать в центральной области (ширина окна слайдера минус centerPadding)
                    asNavFor: '#' + this.pagerID // класс или ид элемента используемого в качестве пейджера
                }, 
                pagerOpts = {
                    centerMode: this.isFillMode, // текущий слайд всегда в середине
                    centerPadding: '0px', // области в которых видно пред/след слайд (в нашем случае на эту область я накладывыю кнопки)
                    slidesToShow: this.visibleThumbs, // сколько слайдов в центральной области.
                    asNavFor: '#' + this.sliderID, // класс или ид элемента используемого в качестве пейджера (у нас двусторонння свзяь)
                    focusOnSelect: true // перемещаться к сладу при клике на него (в т.ч. листает связанный слайдер)
                };

            return $.extend(true, {}, options, (target == 'slider' ? sliderOpts : pagerOpts));
        },
        initFullscreen: function () {
            var _this = this;
            if (!this.$fullscreenBtn.length || window.innerWidth < 800) return;

            if (typeof document.exitFullscreen !== 'undefined' && window.outerWidth > 800) {
                this.$fullscreenBtn.add(this.$closeBtn).off('click').on('click', function () {
                    _this.fullscreen();
                });

                $(document).off('fullscreenchange').on('fullscreenchange', function () {
                    var $b = $('body');
                    _this.$pager.slick('unslick');
                    _this.$slider.slick('unslick');

                    if (!!document.fullscreenElement) {
                        $b.addClass('fullscreen');
                        _this.$gallery.find('.gallery__buttons').hide();
                        _this.$pager.hide();
                        _this.initSlider();
                    } else {
                        $b.removeClass('fullscreen');
                        _this.$gallery.find('.gallery__buttons').show();
                        _this.$pager.show();
                        _this.initSlider();
                        _this.initPager();
                    }
                });
            } else {
                this.$fullscreenBtn.hide();
            }
        },
        fullscreen: function () {
            if (!!document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                this.fullscreenElt.requestFullscreen();
            }
        },
        initSlider: function () {
            var _this = this,
                $title = this.$gallery.find('.gallery__title'),
                $teaser = this.$gallery.find('.gallery__teaser'),
                $tags = this.$gallery.find('.gallery__tags'),
                $index = this.$gallery.find('.gallery__index>i'),
                sliderOptions = this.getOptions('slider');

            this.$slider
                .on('beforeChange', function (event, slick, currentSlide, nextSlide) { // эвент перед пролистыванием
                    var $image = slick.$slides.eq(nextSlide).find('img'),
                        title = $image.attr('title'),
                        teaser = $image.attr('data-teaser'),
                        tags = $image.attr('data-tags'),
                        link = $image.attr('src');
                    $title.text(title);
                    $teaser.text(teaser);
                    $tags.html(tags);
                    $index.text(nextSlide + 1);
                    _this.$downloadBtn.attr('href', link);
                    _this.initialSlide = nextSlide;

                    _this.toggleCopyWidget(true);

                    if (!_this.isFillMode) {
                        _this.$pager.find('.gallery__thumb').removeClass(_this.activeClass).eq(nextSlide).addClass(_this.activeClass);
                    }
                })
                .slick(sliderOptions);
        },
        addImageClickListener: function () {
            var _this = this;
            this.$slider.find('img').on('click', function () {
                _this.fullscreen();
            });
        },
        initPager: function () {
            var _this = this,
                pagerOptions = this.getOptions('pager');
            this.$pager
                .on('init', function (event, slick) {
                    if (!_this.isFillMode) {
                        slick.$slides.eq(_this.initialSlide).addClass(_this.activeClass);
                    }
                })
                .slick(pagerOptions)
                .toggleClass('gallery__pager-fixed', !this.isFillMode);
        },
        toggleCopyWidget: function(hide){
            var slick = this.$slider.slick('getSlick'),
                // link = this.$linkBtn.data('base-url') + slick.$slides.eq(slick.currentSlide).find('img').attr('src'),
                link = slick.$slides.eq(slick.currentSlide).find('img').attr('src'),
                $linkInput = this.$copyWidget.find('input[type=text]');
            this.$copyWidget.toggleClass('hidden', !!hide);
            this.$linkBtn.toggleClass('hidden', !hide);
            if (!hide){
                $linkInput.val(link).select();
            } else{
                $linkInput.val('');
            }
        },
        initCopyWidget: function () {
            var _this = this,
                $copyButton = this.$copyWidget.find('button[type=button]'),
                $linkInput = this.$copyWidget.find('input[type=text]');

            this.$linkBtn.on('click', function () {
                _this.toggleCopyWidget();
            });

            $copyButton.on('click', function () {
                _this.toggleCopyWidget(true);
            });

            $linkInput.on('click',function(){
                $(this).select();
            })
        },
        init: function () {
            this.initSlider();
            this.initPager();
            this.initCopyWidget();
        }
    };

    $('.gallery').each(function () {
        new Gallery($(this));
    });

    $('.gallery-with-custom-arrows').each(function () {
        new GalleryWithCustomArrows($(this));
    }); 

    var $gallerypage = $('.gallery-page');

    if ($gallerypage.length) {
        var $slider = $('.gallery__slider');
        var $d = $(document);

        $d.on('keyup', function(e) {
            if (e.which == 37) {
                $slider.slick('slickPrev');
            } else if (e.which == 39) {
                $slider.slick('slickNext');
            }
        })

    }
});
 