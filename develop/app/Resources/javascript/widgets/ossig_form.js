$(function () {
  $('#ossig_form').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var success = $('#ossig_form_success');
    var error = $('#ossig_form_error');
    var footer = $('#ossig_form_footer');

    var form_data = form.serializeArray();
    var data = { title: 'Обращение с сайта' };
    $(form_data).each(function(index, obj){ data[obj.name] = obj.value });

    footer.hide();
    $.ajax({
      type: 'POST',
      url: url,
      dataType : 'json',
      data: JSON.stringify(data),
      success: function(data)
      {
        success.show();
        error.hide();
      },
      error: function(data) {
        success.hide();
        error.show();
      }
    });
  });
})
