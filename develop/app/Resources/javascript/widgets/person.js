$(function() {
    var $menu = $('.person-page__profile-menu-item');
    var $elem = $('.person-page__profile-info-section');
    var $w = $(window);
    var wTop = $w.scrollTop();

    //$elem.each(function(i) {
    //    var $this = $(this);
    //    var elemTop = $this.offset().top;
    //    var elemBottom = elemTop + $this.outerHeight();
    //    if ((wTop + 75) > elemTop && (wTop + 75) < elemBottom) {
    //        $menu.removeClass('active');
    //        $menu.eq(i).addClass('active');
    //    } else {
    //        return;
    //    }
    //});

    $menu.on('click', function(e) {
        var $this = $(this);
        var href = $this.attr('data-href');

        e.preventDefault();

        $menu.removeClass('active');
        $this.addClass('active');

        $('html, body').animate({
            scrollTop: $elem.filter('.'+href).offset().top - 75
        }, 200);

    });

    $w.on('scroll', function() {
        wTop = $w.scrollTop();

        $elem.each(function(i) {
            var $this = $(this);
            var elemTop = $this.offset().top;
            var elemBottom = elemTop + $this.outerHeight();
            if ((wTop + 75) > elemTop && (wTop + 75) < elemBottom) {
                $menu.removeClass('active');
                $menu.eq(i).addClass('active');
            } else {
                return;
            }
        });
    });

});