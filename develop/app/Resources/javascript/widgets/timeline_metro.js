$(function(){
    var $timeline = $('.timeline-metro');
    var $imgSmall = $('.small').find('.timeline-metro__img');
    var $imgLarge = $('.large').find('.timeline-metro__img');
    var $year = $('.timeline-metro__map-year');
    //TODO use this if we need full preload (anyway it was broken)
    //var firstLoad = false;

    if ($timeline.length) {

        //var imgArray = [];

        //$.each(metroTimeline,function(k, elem){
        //    imgArray.push(elem.src);
        //});

        $("#zoom").anythingZoomer({
            edge: -50,
            switchEvent: null
        });

        //$.preloadImages = function(mas, count) {
        //    var i = 1;
        //    while((count-i > 0) || (count+i < mas.length)) {
        //        var j = null;
        //        if (count-i >= 0) {
        //            j = count-i;
        //            //console.log(count-i);
        //        }
        //        if (count+i < mas.length) {
        //            j = count+i;
        //            //console.log(count+i);
        //        }
        //        if(j) {
        //            $("<img />").attr("src", mas[j].small);
        //            $("<img />").attr("src", mas[j].large);
        //        }
        //        i += 1;
        //    }
        //};

        //console.log(first, last);

        $timeline.slider({
            min: 0,
            max: metroTimeline.length,
            slide: function(slider, ui) {
                var i = ui.value;

                $imgSmall.attr('src', metroTimeline[i].src.small);
                $imgLarge.attr('src', metroTimeline[i].src.large);
                $year.html(metroTimeline[i].year);
            }
            //},
            //change: function(event, ui) {
            //    if (!firstLoad) {
            //        var count = ui.value;
            //        $.preloadImages(imgArray, count);
            //        firstLoad = true;
            //    }
            //}
        });
    }
});