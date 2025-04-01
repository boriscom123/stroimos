$(function () {
    $('[data-add-scrollbar]').each(function(index) {
        var $topNewsMoreWrapper = $(this);
        var spotlight_scroll = new PerfectScrollbar($topNewsMoreWrapper[0], {
          wheelSpeed: 2,
          minScrollbarLength: 40,
        });
    });
});
