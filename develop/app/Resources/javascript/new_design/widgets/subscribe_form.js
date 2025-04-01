$(function () {
    var $message = $('#subscribe-form__message');

    $('#subscribe-form').on('submit', function (e) {
        e.preventDefault();

        var $form = $(e.target);

        $.ajax($form.attr('action'), {
            'data': $form.serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function (data) {
                if (!data.errors) {
                    $form.hide();
                    $message.text(data.message).show();
                } else {
                    $message.text(data.errors.join('\n')).show();
                }
            },
            'error': function () {
                $message.text('Непредвиденная ошибка. Попробуйте ещё раз').show().delay(5000).fadeOut(700);
            }
        });
    });
});
