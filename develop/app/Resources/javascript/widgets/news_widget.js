$(function () {
  // var type = $.cookie('lastShownNewsWidgetType') != undefined ? !parseInt($.cookie('lastShownNewsWidgetType')) : Math.round(Math.random()) == 1;
  // var sc = document.createElement('script'); sc.type = 'text/javascript'; sc.async = true; sc.charset = 'utf-8';
  // if (type) {
  //     sc.src = '//smi2.ru/data/js/93779.js';
  //     $('#unit_93779').show();
  //     $.cookie('lastShownNewsWidgetType', 1, { path: '/', expires: 365 });
  // } else {
  //     sc.src = '//news.mirtesen.ru/data/js/93856.js';
  //     $('#unit_93856').show();
  //     $.cookie('lastShownNewsWidgetType', 0, { path: '/', expires: 365 })
  // }
  // var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sc, s);

  var sc = document.createElement('script'); sc.type = 'text/javascript'; sc.async = true; sc.charset = 'utf-8';
  sc.src = '//news.mirtesen.ru/data/js/93856.js';
  $('#unit_93856').show();
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sc, s);
});
