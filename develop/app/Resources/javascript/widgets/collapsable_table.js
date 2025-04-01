$(function () {
  $('.collapsable-table').each(function() {
    var $table = $(this);
    var shown_rows_counter = $table.attr('data-shown-rows') ? parseInt($table.attr('data-shown-rows')) : 8;
    var $hidden_rows = $table.find('tr:nth-child(n+' + (shown_rows_counter+1) + ')');
    var $btn = $('<a class="collapsable-table__btn"><span class="collapsable-table__btn-expand">Раскрыть</span><span class="collapsable-table__btn-collapse">Свернуть</span></a>');
    $btn.on('click tap', function() {
      $hidden_rows.toggle();
      $btn.toggleClass('active');
      if (!$btn.hasClass('active')) {
        $('html, body').animate({
          scrollTop: $table.offset().top - 150
        }, 300);
      }
    });
    $hidden_rows.hide();
    $($table).after($btn);
  });
})