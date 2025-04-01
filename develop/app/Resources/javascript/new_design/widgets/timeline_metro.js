$(function(){
    var $timeline = $('.timeline-metro');
    var $img = $('.timeline-metro__img');
    var data=[
        {"year" : 2010, "src" : "/images/metro_map/2010.png"},
        {"year" : 2011, "src" : "/images/metro_map/2011.png"},
        {"year" : 2012, "src" : "/images/metro_map/2012.png"},
        {"year" : 2013, "src" : "/images/metro_map/2013.png"},
        {"year" : 2014, "src" : "/images/metro_map/2014.png"},
        {"year" : 2015, "src" : "/images/metro_map/2015.png"}
    ];

    if ($timeline.length) {

        var imgArray = [];

        for(i = 0; i < data.length; i++) {
            imgArray.push(data[i].src);
        }

        $.preloadImages = function(mas) {
            for (var i = 0; i < mas.length; i++) {
                $("<img />").attr("src", mas[i]);
            }
        }

        $.preloadImages(imgArray);
        $timeline.slider({
            min: data[0].year,
            max: data[data.length-1].year,
            slide: function(slider, ui) {
                $.each(data, function(k, v) {
                    if (v.year == ui.value) {
                        $img.attr('src', v.src);
                        return;
                    }
                });
            }
        });
    }
});