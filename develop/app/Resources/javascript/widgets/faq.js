$(function () {
  var $page = $('body');

  function showFaq($faq_block_tmp, question_id) {
    var $faq_block = $faq_block_tmp.clone().insertAfter($page);
    var $faq_modal = $faq_block.find('.faq-block__modal');
    var $faq_close = $faq_modal.find('.faq-block__modal-close');
    var $faq_back = $faq_modal.find('.faq-block__modal-back');
    var $faq_modal_q = $faq_modal.find('.faq-block__modal-content-q')[0];
    var $faq_modal_a = $faq_modal.find('.faq-block__modal-content-a')[0];
    var faq_ps_q = null, faq_ps_a = null;
    var faq_image_is_open = false;
    var faq_card_id = $faq_block.data('card-id');

    var updateQuestionScroll = function() {
      faq_ps_q != null && faq_ps_q.destroy();
      faq_ps_q = null;
      faq_ps_q = new PerfectScrollbar($faq_modal_q, {
        wheelSpeed: 2,
        minScrollbarLength: 24,
        maxScrollbarLength: 24,
        suppressScrollX: true
      });
    }

    var updateAnswerScroll = function() {
      faq_ps_a != null && faq_ps_a.destroy();
      faq_ps_a = null;
      $faq_modal_a.scrollTop = 0;
      faq_ps_a = new PerfectScrollbar($faq_modal_a, {
        wheelSpeed: 2,
        minScrollbarLength: 0,
        maxScrollbarLength: 12,
        suppressScrollX: true
      });
    }

    var updateScrolls = function() {
      updateAnswerScroll();
      updateQuestionScroll();
    }

    var closeFaqModal = function() {
      $(window).off('resize', updateScrolls);
      $faq_close.off('click', closeFaqModal);
      $faq_back.off('click', closeFaqModal);
      $faq_block.off('click', closeFaqModal);
      $(document).off('keyup', closeFaqModalEsc);
      $faq_block.remove();
      $page.removeClass('faq-modal-active');
      faq_ps_q.destroy();
      faq_ps_q = null;
      faq_ps_a.destroy();
      faq_ps_a = null;
    }

    var closeFaqModalEsc = function(e) {
      if (faq_image_is_open == false && e.keyCode == 27) {
        closeFaqModal();
      }
    }

    var selectFaq = function($faq_modal_q_item) {
      $faq_modal.find('[data-faq-q]').removeClass('faq-block__modal-question-link_active');
      $faq_modal_q_item.addClass('faq-block__modal-question-link_active');

      $faq_modal.find('[data-faq-a]').removeClass('faq-block__modal-answer_active');
      $faq_modal.find('[data-faq-a=' + $faq_modal_q_item.data('faq-q')+ ']').addClass('faq-block__modal-answer_active');

      updateAnswerScroll();
    }

    $faq_modal.on('click', function(e) {
      e.stopPropagation();
    });

    $faq_modal.find('img').each(function() {
      var $img = $(this);
      $img.magnificPopup({
        tLoading: 'Загрузка...',
        items: {
          src: $img.attr('src'),
          type: 'image'
        },
        callbacks: {
          open: function() {
            faq_image_is_open = true;
          },
          close: function() {
            faq_image_is_open = false;
          }
        }
      });
    })

    $faq_modal.find('[data-faq-q]').on('click', function(e) {
      $faq_modal_q_item = $(this);
      selectFaq($faq_modal_q_item)
    });

    $(window).on('resize', updateScrolls);
    $faq_close.on('click', closeFaqModal);
    $faq_back.on('click', closeFaqModal);
    $faq_block.on('click', closeFaqModal);
    $(document).on('keyup', closeFaqModalEsc);

    $faq_block.removeClass('faq-block-tmp').addClass('faq-block');
    $faq_block.addClass('faq-block_active');
    $page.addClass('faq-modal-active');

    updateScrolls();

    if (question_id) {
      var $current_item = $faq_modal.find('[data-faq-q="' + question_id + '"]');
      $current_item.length > 0 && selectFaq($current_item);
      $faq_modal.find('.faq-block__modal-content-q')[0].scrollTop = $current_item.position().top;
    }
  }

  var getUrlVars = function(url) {
      var vars = [], hash;
      var hashes = url.slice(url.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++)
      {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
      }
      return vars;
  }

  $('.faq-card').each(function() {
    var $faq_card = $(this);
    var $faq_block_tmp = $(this).next('.faq-block-tmp');

    $faq_card.on('click', function() {
      showFaq($faq_block_tmp, false);
    })
  });

  var url_hash = location.href.indexOf('#') !== -1 ? location.href.substr(location.href.indexOf('#')+1) : false;
  var url_nohash = location.href.indexOf('#') !== -1 ? location.href.substr(0, location.href.indexOf('#')) : location.href;
  var url_vars = getUrlVars(url_nohash);
  if (url_vars['utm_campaign'] && url_vars['utm_campaign'].indexOf('faq-card') !== -1) {
    var card_id = url_vars['utm_campaign'];
    var question_id = url_hash ? url_hash.substr(1, url_hash.length) : false;
    if ($('#' + card_id).length > 0) {
      var $faq_block_tmp = $('#' + card_id).next('.faq-block-tmp');
      showFaq($faq_block_tmp, question_id);
      if (window && window.history && window.history.scrollRestoration) {
        window.history.scrollRestoration = 'manual';
      }
      $('html')[0].scrollTop = $('#' + card_id).position().top;
    }
  }

})
