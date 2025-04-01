$(function () {
  function canPlayVideo() {
    var canPlay = false;
    var v = document.createElement('video');
    if(v.canPlayType && (v.canPlayType('video/mp4').replace(/no/, '') || v.canPlayType('video/webm').replace(/no/, ''))) {
       canPlay = true;
    }
    return canPlay;
  }
  if (canPlayVideo()) {
    $('#timelapse_toggle_cb').on('change', function () {
      if($(this).is(':checked')) {
        $.cookie('showTimelapse', true, { expires: 365, path: '/' });
        $('.background-video__container').show();
      } else {
        $.cookie('showTimelapse', null, { expires: -1, path: '/' });
        $('.background-video__container').hide();
      }
      return false;
    });
  }
});
