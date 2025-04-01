$(function () {

    var $searchInput = $('#search_query'),
        querySuggestUrl = $searchInput.data('suggest-url');

    if (querySuggestUrl) {
        $searchInput.autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: querySuggestUrl,
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        var i, l = data.length, r = [];
                        for (i = 0; i < l; i++) {
                            r.push(data[i].query);
                        }
                        response(r);
                    }
                });
            }
        });
    };
    $('#searchFlitersControl').click(function(e){
           e.preventDefault();
           $('#searchFormFilters').slideDown();
    });
    $('#searchFormFiltersClose').click(function(e){
           e.preventDefault();
           $('#searchFormFilters').hide();
    });



    var searchIsActive = false;

    var searchTrigger = $('.search-form__trigger');
    var searchWindow = $('#searchFormOverflow');
    var searchWindowForm = $('#searchFormOverflow .search-form');

    function showSearchWindow() {
      searchWindow.show();
      searchWindow.addClass('active');
      $('#timelapse_toggle').hide(); // dirty
      $('.bu-buttons__wrap').hide(); // dirty
      $('#searchField').focus();
      searchIsActive = true;
    }

    function hideSearchWindow() {
      searchWindow.hide();
      searchWindow.removeClass('active');
      $('#timelapse_toggle').show(); // dirty
      $('.bu-buttons__wrap').show(); // dirty
      $('#searchField').blur();
      searchIsActive = false;
    }

    searchTrigger.click(function(e){
       e.preventDefault();
       showSearchWindow();
    });

    searchWindow.click(function (e) {
      if (!searchWindowForm.is(e.target) && searchWindowForm.has(e.target).length === 0) {
        hideSearchWindow();
      }
    });

    $(document).keyup(function(e) {
      if (e.keyCode === 27 && searchIsActive) {
        hideSearchWindow();
      }
    });

    $(document).keyup(function(e) {
      if (e.keyCode === 13 && searchIsActive) {
        $('#searchFormOverflow .search-form').submit();
        return false;
      }
    });

    $('#searchFormOverflow .search-form__icon').click(function(e){
      $('#searchFormOverflow .search-form').submit();
      return false;
    });

});
