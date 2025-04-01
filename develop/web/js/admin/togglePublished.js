$(function () {
    $(document).delegate('input.togglePublished[data-toggle="toggle"]', 'change', function (event) {
        var $target = $(event.target);
        var isError = $target.data('isError');
        var url = $target.data('url');
        if (isError) {
            return false;
        }
        $.ajax({
            type: "POST",
            url: url
        })
        .fail(function () {
            var checked = $target.prop('checked');
            $target.data('isError', true);
            $target.prop('checked', !checked).change();
            $target.prop('disabled', true).change();
            alert('Не возможно сменить статус. Ошибка на сервере.');
            return false;
        });
    })
});
