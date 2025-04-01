function _faq_table(el) { this.init(el); }

_faq_table.prototype = {
  init: function(el) {
    var t = this;
    t.qs = [];
    t.table = $(el);
    t.table.find('tr:nth-child(odd)').each(function() { 
      t.qs.push(new t._item(this));
    });
    return t;
  },
  hideAll: function() {
    var t = this;
    $.each(t.qs, function(k,i) { i.hide(); });
  }
}

_faq_table.prototype._item = function(el) { this.init(el) }

_faq_table.prototype._item.prototype = {
  init: function(el) {
    var t = this;
    t.in_progress = false;
    t.element = $(el);
    t.element.find('td').wrapInner('<div class="faq-table__q"></div>');
    t.element.next().find('td').wrapInner('<div class="faq-table__a-wrapper"><div class="faq-table__a"></div></div>');
    t.element.on('click tap', function() {
      t.toggle();
    });
  },
  toggle: function() {
    var t = this;
    if (!t.in_progress) {
      t.in_progress = true;
      t.element.toggleClass('active');
      t.element.next().find('div.faq-table__a-wrapper').slideToggle(500, function() {
        t.in_progress = false;
      });
    }
  },
  hide: function() {
    var t = this;
    t.element.removeClass('active');
    t.element.next().find('div.faq-table__a-wrapper').slideUp(500);
  }
}

function _faq_table_header(el, table) { this.init(el, table); }

_faq_table_header.prototype = {
  init: function(el, table) {
    var t = this;
    t.is_open = false;
    t.in_progress = false;
    t.table = table;
    t.header_element = $(el);

    t.table_element = t.header_element.next('table.faq-table');
    t.table_element.wrap('<div class="faq-table-wrapper"></div>');
    t.table_wrapper = t.header_element.next('.faq-table-wrapper');

    t.table_wrapper.hide();

    t.header_element.on('click tap', function() { t.toggle() });
  },
  toggle: function() {
    var t = this;
    if (!t.in_progress) {
      t.in_progress = true;
      if (t.is_open == true) { t.table.hideAll(); }
      t.is_open = !t.is_open;
      t.header_element.toggleClass('active');
      t.table_wrapper.slideToggle(500, function() {
        t.in_progress = false;
      });
    }
  }
}

$(function () {
  $('.faq-table-title').each(function() {
    if (!$(this).prev().hasClass('faq-table') && !$(this).prev().hasClass('faq-table-wrapper')) { $(this).addClass('faq-table-title_first') }
    var $table = $(this).next('table.faq-table');
    new _faq_table_header($(this), new _faq_table($(this).next('table.faq-table')));
  });
  $(':not(.faq-table-wrapper) > .faq-table').each(function() {
    new _faq_table(this);
  });
})