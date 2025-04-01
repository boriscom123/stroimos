$(function() {
    var $w = $(window);
    var $btnWrap = $('.bu-buttons__wrap');
    var butWidth = $('#toTop').width();
    var mainWidth = 1080;
    var butLeft = 30;
    var oldTop = 0;
    var animate = false;

    $w.on('resize', function() {
        var wWidth = $w.width();

        if (wWidth < mainWidth + butWidth + butLeft) {
            $btnWrap.css({
                'margin-right': 'auto',
                'right': 30
            });
        } else {
            $btnWrap.css({
                'margin-right': -540,
                'right': '50%'
            });
        }
    });

    $w.on('scroll', function() {
        var wTop = $w.scrollTop();

        if (!animate) {

            if (wTop > 0) {
                $('#toBottom').css('display', 'none');
            }

            if (wTop > 500) {
                $('#toTop').css({
                    'display': 'block'
                });
            } else {
                $('#toTop').css({
                    'display': 'none'
                });
            }
        }
    });

    $w.trigger('scroll');
    $w.trigger('resize');

    $('.bu-buttons__link').on('click', function(e) {
        e.preventDefault();
    });

    $('#toTop').on('click', function() {
        oldTop = $w.scrollTop();
        animate = true;

        $('body').animate({
            scrollTop : 0
        }, 300, function() {
            animate = false;
        });

        $('#toTop').css('display', 'none');
        $('#toBottom').css('display', 'block');
    });

    $('#toBottom').on('click', function() {
        animate = true;
        $('body').animate({
            scrollTop : oldTop
        }, 300, function() {
            animate = false;
        });

        $('#toTop').css('display', 'block');
        $('#toBottom').css('display', 'none');
    });

    $('#backUp').on('click', function() {
        history.back();
    });
});