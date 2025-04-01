$(function () {

    var $b = $('body'),
        $d = $(document),
        $w = $(window),
        $mainMenu = $('.main-menu .main-menu__folder'),
        $subMenu = $('.page-header__submenu'),
        $dropdownMenu = $('.dropdown-menu__section'),
        $dropdownWrapper = $('.dropdown-menu__wrapper'),
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
                $(focusable).trigger('focus');
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

    openDropDown = function ($menu, $dropdown) {
        var menuHeight = $dropdown.outerHeight(),
            //pt = $('.top-panel-frame-wrp').outerHeight() + $('.page-header').outerHeight();
            pt = $('.page-header').offset().top + $('.page-header').outerHeight();

		var $dropdownElems = $dropdown.find('li');
		var dropdownElemsLength = $dropdownElems.length;

		//console.log($dropdownElems, dropdownElemsLength);

        $dropdownMenu.removeClass('active');
        $mainMenu.removeClass('active');

        $menu.addClass('active');
        $dropdown.addClass('active');

        $b.addClass(dropdownState);
		$('.page-header').css({'top': $('.top-panel-frame-wrp').outerHeight()});
		$dropdownElems.css('opacity', 0);
		for(var i = 0; i < dropdownElemsLength; i++) {
			(function(i) {
				setTimeout(function() {
					$dropdownElems.eq(i).css('opacity', 1);
				}, 150*(i+1));
			}(i));
		}
        $dropdownWrapper.not($dropdown.parent())
        .css({
            'height': 0,
        }).removeClass('showed');

        $dropdown.parent()
            .css({
                'height': menuHeight,
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
		$('.page-header').css({'top': 0});
        $dropdownWrapper
            .css({
                'height': 0,
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
        $target = $(this.closest('.page-header__wrapper')).find($this.data('target'));

        e.preventDefault();
        // console.log('wtf????????????');
        if (!$target.length) return;

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

    $b.on('click' + eventNamespace, function () {
        //closeDropDown();
    });

    // обрезка меню
    $('.main-menu').each(function(index, menuItem) {
        var menuWidth = 0;
        var parent = $(menuItem.closest('.page-header__wrapper'));
        $(menuItem).find('li').each(function(index, listItem) {
            menuWidth += $(listItem).outerWidth();
        });

        if (menuWidth > parent.outerWidth()) {
            parent.addClass('dotted');
        }
    });
});
