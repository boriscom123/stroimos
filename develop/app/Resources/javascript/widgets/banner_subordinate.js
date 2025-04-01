$(function () {
    var $banners = $('.slide-banner');
    var $group = $();
    $banners.each(function(index, item) {
        var nextElement = item.nextElementSibling;
        if (nextElement?.classList.contains('slide-banner')) {
            $group = $group.add(item);
        } else {
            $group = $group.add(item);
            if ($group.length > 1) {
                if ($group.length % 2 === 0) {
                    $group.wrapAll( "<div class='grid-banner-even'></div>" );
                } else {
                    $group.wrapAll( "<div class='grid-banner-odd'></div>" );
                }
            }
            $group = $();
        }
    });
});
