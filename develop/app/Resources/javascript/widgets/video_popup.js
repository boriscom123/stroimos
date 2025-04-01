$(function () {

    var vp_check = moment();
    var vp_check_month = vp_check.format('M');
    var vp_check_day   = vp_check.format('D');
    var vp_check_year  = vp_check.format('Y');

    if (vp_check_year == 2018 && (vp_check_month < 9 || (vp_check_month == 9 && vp_check_day <= 5))) {
        initVideoPupup();
    }

    var $wrapper = $('.video-popup__wrapper');
    var $popup = $('.video-popup__content');
    var $close = $('.video-popup__close');

    var videos = [
        'kJC-UIec3rg',
        '1ReQGVXsVos',
        'aEwNoZ6pXyU',
        'mcMRk3YegRM',
        'PsS1RpEGNSU',
        't41tIsk_TNY',
        'pKLKbNJnoqU',
        'LFx9YAby2LE'
    ]

    function initVideoPupup() {
    
        if (previousTimeShownCheck()) {
            if ($.cookie('videoPopupVisitStartedAt') == undefined) $.cookie('videoPopupVisitStartedAt', moment(), { path: '/', expires: 365 });
            var diff = moment().diff(moment($.cookie('videoPopupVisitStartedAt')), 'seconds');
            var timeout = (diff >= 15*60) ? 10 : (diff < 15*60 && diff > 10) ? 0 : 10 - diff;
            setTimeout(function() {
            showPopup();
            }, timeout*1000);
        }
    
        function showPopup() {
          if(previousTimeShownCheck()) {
            $.cookie('videoPopupPreviousTimeShownAt', moment(), { path: '/', expires: 365 });
            $.removeCookie('videoPopupVisitStartedAt', { path: '/', expires: 365 });
            $popup.html('<iframe width="800" height="450" src="https://www.youtube.com/embed/' + getVideo() + '?autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>')
            $wrapper.fadeIn(300);
    
            setTimeout(function() {
                $close.fadeIn(300);
                $close.on('click tap', function(e) { 
                    e.preventDefault(); 
                    closePopup() }
                );
                $wrapper.on('click tap', function(e) { 
                    e.preventDefault(); 
                    closePopup() }
                );
            }, 15000);
          }
        }   
    }

    function closePopup() {
      $wrapper.fadeOut(300, function() {
        $popup.html('');
      });
    }

    function getVideo() {
        var unshown_videos = $.cookie('videoPopupUnshownVideos') ? $.cookie('videoPopupUnshownVideos').split(',') : videos;
        var random_video = unshown_videos[Math.floor(Math.random()*unshown_videos.length)];
        var random_video_index = unshown_videos.indexOf(random_video);
        if (random_video_index !== -1) { unshown_videos.splice(random_video_index, 1) }
        unshown_videos = unshown_videos.lengtn == 0 ? videos : unshown_videos;
        $.cookie('videoPopupUnshownVideos', unshown_videos.join(','), { path: '/', expires: 365 });
        return random_video;
    }

    function previousTimeShownCheck() {
      return $.cookie('videoPopupPreviousTimeShownAt') == undefined || moment().diff(moment($.cookie('videoPopupPreviousTimeShownAt')), 'hours') > 18;
    }
});
