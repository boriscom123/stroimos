$(function () {
    $('.metro-station__map_small').magnificPopup({
        type:'inline',
        midClick: true,
        closeOnContentClick: true,
        closeBtnInside: false
    });

    // аккордион
    var MSEC_IN_DAY = 86400000;
    var tabActiveClass = 'station-block__line-top_active';
    var tabContentClass = 'station-block__content';
    var tabParentClass = 'station-block__item';
    var stationLinkClass = 'station-block__line-top';

    var $stationLinks = $('.' + stationLinkClass);
    var $contentBlocks = $('.' + tabContentClass);

    function saveActiveLineInStorage(item) {
        var data = {
            activeLine: $(item).attr('data-id'),
            date: Date.now()
        }
        localStorage.setItem('stroi-mos-active-station', JSON.stringify(data))
    }

    function removeActiveLineInStorage() {
        localStorage.removeItem('stroi-mos-active-station')
    }

    function checkActiveLineStorage($stations) {
        if (localStorage.getItem('stroi-mos-active-station')) {
            var data = JSON.parse(localStorage.getItem('stroi-mos-active-station'));
            var dateOffsetDays = (Date.now() - data.date) / MSEC_IN_DAY;
            if (dateOffsetDays <= 1) {
                $stations.each(function() {
                    if ($(this).attr('data-id') === data.activeLine) {
                        openTab(this);
                    }
                })
            }
        }
    }

    function openTab(item) {
        var $parent = $(item.closest('.' + tabParentClass));
        $parent.find('.' + tabContentClass).slideDown(400);
        $(item).addClass(tabActiveClass);
    }

    function closeAllTabs($stationLinks, $contentBlocks) {
        $stationLinks.removeClass(tabActiveClass);
        $contentBlocks.slideUp(400);
    }

    if ($stationLinks.length > 0 && $contentBlocks.length > 0) {

        checkActiveLineStorage($stationLinks);

        $stationLinks.on('click', function(evt) {
            evt.preventDefault();

            if (!$(this).hasClass(tabActiveClass)) {
                closeAllTabs($stationLinks, $contentBlocks);
                openTab(this);
                saveActiveLineInStorage(this);
            } else {
                closeAllTabs($stationLinks, $contentBlocks);
                removeActiveLineInStorage();
            }
        });
    }
});
