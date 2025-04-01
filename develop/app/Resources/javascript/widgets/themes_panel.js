$(function() {
    var $w = $(window);
    var $menu = $('.themes-panel__menu');
    var $menuWrap = $('.themes-panel__menu-wrapper');
    var $articleThemes = $('.themes-panel__menu-all');
    var menuHeight = $menu.outerHeight();

    $articleThemes.on('click', function(e) {
        e.preventDefault();
        if (!$menuWrap.hasClass('active')) {
            $menuWrap.addClass('active');
            $articleThemes.addClass('active');
            $menuWrap.css({
                "height" : menuHeight
            }).removeAttr('tabindex');
        } else {
            $menuWrap.removeClass('active');
            $articleThemes.removeClass('active');
            $menuWrap.css({
                "height" : 0
            }).attr('tabindex',-1);
        }
    });

    var $body = $('body');
    var $topWrap = $('.themes-panel');
    var $fixedMenu = $('.themes-panel__fixed');
    var $fixedMenuBtn = $('.themes-fixed__menu-all');
    var $fixedMenuDrop = $('.themes-fixed__menu-drop');
    var menuDropHeight = $fixedMenuDrop.outerHeight();
    var $fixedMenuWrap = $('.themes-fixed__menu-drop-wrap');
    var $shadow = $('.themes-fixed__shadow');

    if ($topWrap.length) {
        $w.on('scroll', function() {
            var $this = $(this);
            var thisTop = $this.scrollTop();
            var topWrapBottom = $topWrap.offset().top + $topWrap.outerHeight() - parseInt($topWrap.css('padding-bottom'));

            if (thisTop > topWrapBottom) {
                $fixedMenu.addClass('showed').css('top', 0).removeAttr('tabindex');
                $fixedMenuWrap.css('top', 75)
            } else {
                $fixedMenu.removeClass('showed').css('top', -76).attr('tabindex',-1);
                $fixedMenuWrap.css('top', -10000)
            }
        });
    }

    $fixedMenuBtn.on('click', function(e) {
        e.preventDefault();
        if (!$fixedMenuWrap.hasClass('active')) {
            $fixedMenuWrap.addClass('active').removeAttr('tabindex');
            $fixedMenuWrap.css('height', menuDropHeight);
            $shadow.addClass('active');
            $body.css('overflow', 'hidden');
        } else {
            $fixedMenuWrap.removeClass('active').attr('tabindex',-1);
            $fixedMenuWrap.css('height', 0);
            $shadow.removeClass('active');
            $body.css('overflow', 'auto');
        }
    });

    $shadow.on('click', function() {
        $fixedMenuWrap.removeClass('active');
        $fixedMenuWrap.css('height', 0);
        $shadow.removeClass('active');
        $body.css('overflow', 'auto');
    });
});