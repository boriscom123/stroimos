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
    }

});