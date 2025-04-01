$(function () {
    $('.material-owner-link').click(function (event) {
        event.preventDefault();
        var $a = $(event.target);
        if (!$a.hasClass('loading')) {
          $a.addClass('loading');
          $.post($a.data('url'), function (data) {
              alert(data);
              $('.material-owner-link:hidden').show();
              $a.removeClass('loading');
              $a.hide();
          }).fail(function(data) {
              console.log(data.responseJSON);
              alert('Ошибка! Что-то пошло не так... Попробуйте перезагрузить страницу.');
          });
        }
    });
});
