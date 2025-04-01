
$(function() {
    if ($('.datepick').length) {
        $('.datepick').on('change', function() {
            if ($('.events-block__filter').length) {
                $('.events-block__filter').submit();
            }
        });
    }
});