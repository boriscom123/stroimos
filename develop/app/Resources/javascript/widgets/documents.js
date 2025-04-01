$(function() {
    var $category = $('#category');
    var $filters = $('.documents-page__document-filter');
    var $documentType = $('.documents-page__document-type');
    var $submenu = $('.search-form__submenu-wrap');
    var months = [
        "января",
        "февраля",
        "марта",
        "апреля",
        "мая",
        "июня",
        "июля",
        "августа",
        "сентября",
        "октября",
        "ноября",
        "декабря"
    ];
    var monthsShort = [
        "январь",
        "февраль",
        "март",
        "апрелб",
        "май",
        "июнь",
        "июль",
        "август",
        "сентябрь",
        "октябрь",
        "ноябрь",
        "декабрь"
    ];

    $documentType.on('click', function() {
        $submenu.css({'height' : 'auto','overflow' : 'visible'});
    });

    $category.on('change', function() {
        var $this = $(this);

        $filters.removeClass('active').css('display', 'none');
        $submenu.css({'height' : 'auto','overflow' : 'visible'});
        $filters.filter('.documents-page__document-type').addClass('active').css('display', 'block');
        if ($this.val() == 'decision') {
            $filters.filter('.documents-page__decision').addClass('active').css('display', 'block');
        } else if ($this.val() == 'law') {
            $filters.filter('.documents-page__law').addClass('active').css('display', 'block');
        } else if ($this.val() == 'draft') {
            $filters.filter('.documents-page__draft').addClass('active').css('display', 'block');
        }
    });

    // TREE

    $('.documents-page__document-category').tree({
        collapse: true,
        onCheck: {
            node: 'expand'
        },
        onUncheck: {
            node: 'collapse'
        }
    });
    $('.documents-page__document-category').tree('collapseAll');
    $('.documents-page__document-category').on('click', function() {
        $submenu.css({'height' : 'auto','overflow' : 'visible'});
    });

    $('.datepick').each(function() {
        $(this).datepicker({
            altField: "#"+$(this).attr('id')+' + .altField',
            altFormat: 'dd M yy',
            monthNames: monthsShort,
            monthNamesShort: months,
            dateFormat: 'dd.mm.yy',
            dayNamesMin: [ "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            showOtherMonths: true,
            selectOtherMonths: true,
            firstDay: 1
        });
    });
    $('.hasDatepicker').on('change', function() {
        var $this = $(this);
        var val = $this.datepicker('getDate');
        var date = new Date(val);
        var month = date.getMonth();
        //console.log(months, month, months[month].length);
        var symb = 8 + months[month].length;
        $this.attr('size', symb);
    })
});