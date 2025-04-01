$(function() {
    $('.hotline-block__action').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var $par = $this.parent();
        var $open = $par.find('.hotline-block__action.open');
        var $close = $par.find('.hotline-block__action.close');
        var $form = $par.find('.hotline-block__form');
        var $children = $form.children();
        var height = 0;

        $children.each(function() {
            height += $(this).outerHeight();
        });

        if ($this.hasClass('open')) {
            $form.css({'height' : height});
            $open.removeClass('active');
            $close.addClass('active');
        } else {
            $form.css({'height' : 0});
            $open.addClass('active');
            $close.removeClass('active');
        }
    })
});