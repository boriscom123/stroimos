$(function() {
    var $form = $('form');
    $('.persist-preview').on('click', function(){
        $form.attr('target', '_blank');
        setTimeout(function() {
            $form.attr('target', '_self');
        }, 100);
    });
});
