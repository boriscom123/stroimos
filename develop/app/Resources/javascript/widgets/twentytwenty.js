$(function () {
    // KOSTYL
    $('div[data-embedded-type="twenty_twenty"]').each(function() {
        $(this).attr('style', '');
        $(this).find('img').attr('width', '100%');
        $(this).find('img').attr('style', '');
        $(this).find('twentytwenty-admin_title').remove();
    })

    $('div[data-embedded-type="twenty_twenty"]').twentytwenty({
        before_label: 'До',
        after_label: 'После'
    });
})
