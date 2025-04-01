$(document).ready(function() {
    $('.collapsible-field').each(function() {
        var field = $(this);
        var group = $(field).closest('.form-group');
        var label = $(group).find('.control-label');
        var field_wrapper = $(group).find('.sonata-ba-field');

        var widget = $(label).append('<a href="javascript:void(0)"><em class="cf-show">(развернуть)</em><em class="cf-hide">(свернуть)</em></a>');
        var widget_show = $(widget).find('.cf-show');
        var widget_hide = $(widget).find('.cf-hide');

        if ($(field).text()) {
            $(widget_show).hide();
        } else {
            $(widget_hide).hide();
            $(field_wrapper).hide();
        }
        
        $(widget).on('click', function(){
            $(field_wrapper).toggle();
            $(widget_show).toggle();
            $(widget_hide).toggle();
        });
    });
});

