$(function () {
  $('.oasis-container').each(function() {
  	var sh = $(this)[0].scrollHeight;
    var ch = $(this)[0].clientHeight;
    sh > ch && $(this).addClass('oasis-container_active');
  });
})
