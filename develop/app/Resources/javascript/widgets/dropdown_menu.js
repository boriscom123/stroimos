$(function () {

    var keys = {37: 1, 38: 1, 39: 1, 40: 1, 33: 1, 34: 1, 35: 1, 36: 1};

    function preventDefault(e) {
        e = e || window.event;
        if (e.preventDefault)
            e.preventDefault();
        e.returnValue = false;
    }

    function preventDefaultForScrollKeys(e) {
        if (keys[e.keyCode]) {
            preventDefault(e);
            return false;
        }
    }

	function disableScrollBar(e) {
		e.preventDefault();
		$w.scrollTop(0);
	}

    function disableScroll() {
		$w.on('scroll', disableScrollBar);
		if (window.addEventListener) // older FF
            window.addEventListener('DOMMouseScroll', preventDefault, false);
        window.onwheel = preventDefault; // modern standard
        window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
        window.ontouchmove  = preventDefault; // mobile
        document.onkeydown  = preventDefaultForScrollKeys;
    }

    function enableScroll() {
		$w.off('scroll', disableScrollBar);
        if (window.removeEventListener)
            window.removeEventListener('DOMMouseScroll', preventDefault, false);
        window.onmousewheel = document.onmousewheel = null;
        window.onwheel = null;
        window.ontouchmove = null;
        document.onkeydown = null;
    }

    var $b = $('body'),
        $d = $(document),
        $w = $(window),
        $mainMenu = $('.main-menu .main-menu__folder'),
        $subMenu = $('.page-header__submenu'),
        $pageOverlay = $('.page-overlay'),
        $dropdownMenu = $('.dropdown-menu__section'),
        $dropdownWrapper = $('.dropdown-menu__wrapper, .dropdown-menu__fallback'),
        $dropdownOverlay = $('.dropdown-menu__overlay'),
        $video = $('.background-video'),
        dropdownState = 'dropdown-menu__showed',
        minDuration = 150,
        focusable = '#dd_menu_focus',
        notFocusable = '#page, #header_frame',
        eventNamespace = '.DropDownMenu';

    $dropdownMenu.each(function () {
        var $this = $(this),
            menuHeight = $this.outerHeight(),
            duration = Math.max(menuHeight, minDuration);
        $this.css({'transition-duration': duration + 'ms, 0ms'});
    });

	setInterval(function() {
		var $elem = $('.top-panel-frame-wrp');
		if ($elem.length) {
			pt = $('.dropdown-menu__showed .top-panel-frame-wrp').outerHeight() + $('.page-header').outerHeight();
			if ($('body').hasClass('dropdown-menu__showed')) {
				$('.page-header').css({'top' : $elem.outerHeight()});
				$dropdownWrapper
					.css({
						'padding-top': pt
					});
        $subMenu.css({
          'top': pt
        });
			}
		}
	}, 30);

    enableTab = function () {
        $(focusable).add(notFocusable).removeAttr('tabindex');
        $d.off('focusin' + eventNamespace);
    };

    disableTab = function () {
        $(focusable).attr('tabindex', 1);
        $(notFocusable).attr('tabindex', -1);
        $d.on('focusin' + eventNamespace, function (e) {
            var $target = $(e.target);
            if (!!$target.closest(notFocusable).length) {
                $w.scrollTop(0);
                $(focusable).trigger('focus');
                $dropdownOverlay.scrollTop(0);
            }
        });
    };

    enableEsc = function () {
        $d.on('keyup' + eventNamespace, function (e) {
            if (e.keyCode === 27) {
                closeDropDown();
            }
        });
    };

    disableEsc = function () {
        $d.off('keyup' + eventNamespace);
    };

    enableVideo = function () {
        if ($video.length && $video.is(':hidden')) {
            $video
                .css({'display': 'block'})
                .get(0).play();
        }
    };

    disableVideo = function () {
        if ($video.length && $video.is(':visible')) {
            $video
                .css({'display': 'none'})
                .get(0).pause();
        }
    };

    openDropDown = function ($menu, $dropdown) {
        var menuHeight = $dropdown.outerHeight(),
            //pt = $('.top-panel-frame-wrp').outerHeight() + $('.page-header').outerHeight();
            pt = $('.page-header').offset().top + $('.page-header').outerHeight();

		var $dropdownElems = $dropdown.find('li');
		var dropdownElemsLength = $dropdownElems.length;

		//console.log($dropdownElems, dropdownElemsLength);

        $w.scrollTop(0);
        $pageOverlay.attr('data-label', $dropdown.data('label'));
        $dropdownMenu.removeClass('active');
        $mainMenu.removeClass('active');

        $menu.addClass('active');
        $dropdown.addClass('active');

        $b.addClass(dropdownState);
        disableScroll();
		$('.page-header').css({'top': $('.top-panel-frame-wrp').outerHeight()});
		$dropdownElems.css('opacity', 0);
		for(var i = 0; i < dropdownElemsLength; i++) {
			(function(i) {
				setTimeout(function() {
					$dropdownElems.eq(i).css('opacity', 1);
				}, 150*(i+1));
			}(i));
		}
        $dropdownWrapper
            .css({
                'height': menuHeight,
                'padding-top': pt
            })
            .addClass('showed');
        $subMenu.css({
          'top': pt + menuHeight
        });
        $('<style id="dropdown-style">.page-overlay::before{top:' + pt + 'px}</style>').appendTo('head');

        enableEsc();
        disableTab();
    };

    closeDropDown = function () {
        $dropdownMenu.removeClass('active');
        $mainMenu.removeClass('active');

        $b.removeClass(dropdownState);
        enableScroll();
		$('.page-header').css({'top': 0});
        $dropdownWrapper
            .css({
                'height': 0,
                'padding-top': ''
            })
            .removeClass('showed');
        $subMenu.css({
          'top': 0
        });
        $('style#dropdown-style').remove();

        disableEsc();
        enableTab();
    };

    $mainMenu.on('click' + eventNamespace, function (e) {
        var $this = $(this),
            $target = $($this.data('target'));

        e.preventDefault();
        if (!$target.length) return;

        $dropdownOverlay.scrollTop(0);
        disableVideo();

        if ($this.is('.active')) {
            closeDropDown();
        } else {
            openDropDown($this, $target);
        }
    });

    $dropdownWrapper
        .on('click' + eventNamespace, function (e) {
            e.stopPropagation();
        })
        .on('transitionend' + eventNamespace, function () {
            var $this = $(this);
            if (!$this.is('.showed')) {
                enableVideo();
                $pageOverlay.attr('data-label', '');
            }
        });

    $dropdownOverlay.on('click' + eventNamespace, function () {
        closeDropDown();
    });
});
