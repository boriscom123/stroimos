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
                    $.cookie('subscribePopupEmail', $('.subscribe-form__email').val());
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

    $('input[name="form[email]"]').keydown(function(event) {
        const keys = ['Escape', 'Control', 'Alt', 'Shift'];
        if (keys.includes(event.key)) {
            return;
        }
        $message.text('').hide();
    })

    $('input[name="form[reason][]"][value="other"]',  '#unsubscribe-reason-form').change(function() {
        if (!this.checked) {
            $('input[name="form[comment]"]',  '#unsubscribe-reason-form').val('').removeAttr('required');
        }
        else {
            $('input[name="form[comment]"]',  '#unsubscribe-reason-form').val('').attr('required', 'required');
        }
    });

    $('input[name="form[comment]"]',  '#unsubscribe-reason-form').click(function() {
        var fieldId  = $(this).closest('label').attr('for');
        $('#' + fieldId).prop('checked', true);
        $(this).attr('required', 'required');
        return false;
    });

    var $admUnitsSelector = $('#adminUnitsSelector');

    $admUnitsSelector.selectize({
        plugins: ['remove_button'],
        options: $admUnitsSelector.data('options'),
        hideSelected: false,
        onDropdownClose: function($dropdown){
            $($dropdown).find('.selected').not('.active').removeClass('selected');
        },
        render: {
            option: function(item, escape) {
                return `<div class="${item.isArea ? 'optgroup' : 'option'}" data-value="${item.value}">${item.text}</div>`;
            }
        },
    });

});
