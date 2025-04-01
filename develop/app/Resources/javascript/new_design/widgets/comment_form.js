$(function () {
    $(document).on('fos_comment_new_comment', '.fos_comment_comment_new_form', function (event, data) {
        var $message = $(event.target).find('.message');

        $message.show();
    });
});

