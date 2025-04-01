$(function(){   
    $viewportMonitorElements = $('[data-viewport-monitor]');
    if ($viewportMonitorElements.length) {
        $.each($viewportMonitorElements, function(key, element) {
            var $element = $(element);
            var elementOffset = ($element.attr('data-viewport-monitor-offset') ? -parseInt($element.attr('data-viewport-monitor-offset')) : -200);
            var elementWatcher = scrollMonitor.create(document.getElementById($element.attr('id')), elementOffset);
            elementWatcher.enterViewport(function() {
                $element.addClass('in-view');
            });
        });         
    }
});