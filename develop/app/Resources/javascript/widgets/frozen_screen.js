$(function () {

  var $fs = $('.frozen-screen');
  var $fs_i = $('.frozen-screen img');
  var $fs_m = $('.frozen-screen__message');
  var $fs_c = $('.frozen-screen__close');
  
  var unfrozen = false;

  function freeze(special) {
    if (typeof special === 'undefined') special = false;
    if (special) {
      $fs_m.addClass('frozen-screen__message_m' + special);
    } else {
      var message_number = getMessageNumber();
      $fs_m.addClass('frozen-screen__message_m' + message_number);
    }
    $fs.addClass('active');
    var touched = false;

    $fs_c.on('click tap', function() { unfreeze(); });
    $($fs_i).eraser({
      size: 300,
      completeRatio: .3,
      completeFunction: function() { unfreeze(); },
      progressFunction: function() {
        if (!touched) {
          touched = true;
          $fs.addClass('touched');
          setTimeout(function() {
            unfreeze();
          }, 5000)
        } 
      }
    });
    $.cookie('frozenScreenPreviousTimeShownAt', moment(), { path: '/', expires: 100 });
    setTimeout(function() {
      unfreeze();
    }, 15000)
  }

  function unfreeze() {
    if (!unfrozen) {
      $fs.addClass('unfrozen');
      setTimeout(function() {
        $fs.hide();
      }, 1000)
    }
  }

  function getMessageNumber() {
    var previous = $.cookie('frozenScreenPreviousMessage');
    var number = undefined;
    if (previous == undefined || parseInt(previous) == 4) {
      number = 1;
    } else {
      number = parseInt(previous) + 1;
    }
    $.cookie('frozenScreenPreviousMessage', number, { path: '/', expires: 100 });
    return number;
  }

  var check = moment();
  var check_month = check.format('M');
  var check_day   = check.format('D');
  if (check_month == 1 && check_day == 7) {
    if ($.cookie('frozenScreenSpecialRPreviousTimeShownAt') == undefined) {
      freeze('r');
      $.cookie('frozenScreenSpecialRPreviousTimeShownAt', moment(), { path: '/', expires: 100 });
    }
  } else if ((check_month == 12 && check_day > 25) || (check_month == 1 && check_day < 3)) {
    if ($.cookie('frozenScreenPreviousTimeShownAt') == undefined || moment().diff(moment($.cookie('frozenScreenPreviousTimeShownAt')), 'hours') > 18) {
      freeze();
    }
  } else if (check_month == 1 && check_day < 9 && check_day > 2) {
    if ($.cookie('frozenScreenPreviousTimeShownAt') == undefined || moment().diff(moment($.cookie('frozenScreenPreviousTimeShownAt')), 'hours') > 18) {
      freeze();
    }
  }
  
  if ((check_month == 12 && check_day > 25) || (check_month == 1 && check_day < 9)) {
    $('body').addClass('ny');
  }
})