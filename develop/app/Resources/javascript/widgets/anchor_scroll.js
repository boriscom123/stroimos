$(function () {
  function scrollToAnchor(hash) {
    setTimeout(function(){
      var target = $(hash);
      var headerHeight = 76 + 10;
      target = target.length ? target : $('[name=' + hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - headerHeight
        }, 100);
        return false;
      }
    }, 1)
  }
  if (window.location.hash) {
    scrollToAnchor(window.location.hash);
  }
  $('a[href*=\\#]:not([href=\\#])').on('click tap', function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
      scrollToAnchor(this.hash);
    }
  })
})