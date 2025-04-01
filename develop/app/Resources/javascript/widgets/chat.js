$(function() {
    var submited = false;
    var first = false;

    var refreshChat = function() {
        $.ajax({
            url: $('.event-content__chat-form').attr('data-refresh-chat'),
            type: 'GET',
            success: function(data) {
                $('.event-content__chat-list').html(data);
                if (!first) {
                    $('.event-content__chat-list').scrollTop($('.event-content__chat-list').get(0).scrollHeight);
                    first = true;
                }
                if ($('.event-content__chat-list').scrollTop() > ($('.event-content__chat-list').get(0).scrollHeight - 500 - $('.event-content__chat-list').height())) {
                    $('.event-content__chat-list').scrollTop($('.event-content__chat-list').get(0).scrollHeight);
                }
                setTimeout(function() {
                    refreshChat();
                }, 5000);
            },
            error: function(st) {
                //console.log(st.readyState, st,status, st.statusText);
                setTimeout(function() {
                    refreshChat();
                }, 5000);
            }
        });
    };

    if ($('.event-content__chat-form').length) {
        refreshChat();
    }

    $('.event-content__chat-form').on('submit', function(e) {
        e.preventDefault();
        if (!submited) {
            submited = true;
            $.ajax({
                url: $('.event-content__chat-form').attr('action'),
                type: 'POST',
                data: $('.event-content__chat-form').serialize(),
                success: function() {
                    $.ajax({
                        url: $('.event-content__chat-form').attr('data-refresh-chat'),
                        type: 'GET',
                        success: function (data) {
                            $('.event-content__chat-form').find('textarea').val('');
                            $('.event-content__chat-list').html(data);
                            $('.event-content__chat-list').scrollTop($('.event-content__chat-list').get(0).scrollHeight);
                            submited = false;
                        }
                    });
                }
            });
        }
    });

    $('body').on('click', '.message-close', function(e) {
        e.preventDefault();
        $this = $(this);
        $.ajax({
            url: $this.attr('data-url'),
            type: 'POST',
            success: function() {
                $this.parents('.event-content__chat-item').hide('300');
                $.ajax({
                    url: $('.event-content__chat-form').attr('data-refresh-chat'),
                    type: 'GET',
                    success: function (data) {
                        $('.event-content__chat-form').find('textarea').val('');
                        $('.event-content__chat-list').html(data);
                        //$('.event-content__chat-list').scrollTop($('.event-content__chat-list').get(0).scrollHeight);
                    }
                });
            }
        });
    });
});