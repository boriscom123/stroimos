$(function () {
    var $topNewsWrapper = $('.top-news'),
        $topNews = $('.top-news__section'),
        $topPost = $topNews.filter('.top-news__teaser-first'),
        setBgr = function(url){
            $topNewsWrapper.css({'background-image': 'url(' + url + ')'});
        };

    $topNews.on('mouseenter', function () {
        var bg = $(this).data('background') || $topPost.data('background');

        setBgr(bg);
    });

    $topNewsWrapper.on('mouseleave', function(){
        var bg = $topPost.data('background');
        setBgr(bg);
    });
});