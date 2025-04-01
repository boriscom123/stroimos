
(function ($) {
    $.fn.loadMore = function (options) {
        $.fn.loadMore.defaults = {
            target: '#loadmore_container',
            item: '.loadmore-item',
            dataSource: 'data-loadmore',
            source: '',
            offset: false,
            limit: false,
            order: false,
            max:false
        };

        var $temp = $('<div></div>').css({'opacity': 0, 'visibility': 'hidden', 'overflow':'hidden', 'position': 'absolute', 'top': -10000, 'left': -10000}).appendTo('body');

        return this.each(function () {
            var $this = $(this),
                $target, targetHeight, targetNewHeight,
                offset, requestData, loading = false;

            options = $.extend(true, {}, $.fn.loadMore.defaults, $this.data(), options);

            if (options.source) {
                $target = $(options.target).css({'overflow': 'hidden'}).data('loadmore', $this);

                $this.on('loadmore:reset',function (event, onlyStyles) {
                    $target.css({
                        'transition': 'none',
                        'height': 'auto'
                    });
                    targetHeight = 0;
                    if (!onlyStyles) {
                        offset = options.offset;
                    }
                }).trigger('loadmore:reset');

                $this.on('click', function (e) {

                    e.preventDefault();

                    if (options.max && (offset === '' || offset >= options.limit * options.max)){
                        $(document).trigger('loadmore:end');
                        $this.addClass('hidden').trigger('loadmore:reset').off();
                        return;
                    }

                    if (loading) return;
                    loading = true;

                    $(document).trigger('loadmore:load');

                    if (!targetHeight) {
                        targetHeight = $target.outerHeight();
                        $target.css({'height': targetHeight});
                    }

                    requestData = {
                        offset: offset,
                        limit: options.limit
                    };

                    if (options.order) {
                        requestData.order = options.order;
                    }

                    $.ajax({
                        url: options.source,
                        data: requestData,
                        success: function (data) {
                            var $items, $data, $dataSource,
                                itemsHeight;

                            if (!data) {
                                $(document).trigger('loadmore:end');
                                $this.addClass('hidden').trigger('loadmore:reset').off();
                                return;
                            }

                            $data = $(data);
                            $dataSource = $data.filter(options.dataSource);
                            $items = $data.not(':text').not($dataSource);
                            $temp.attr({'class': $target.attr('class'), 'id': $target.attr('id')}).css({'width': $target.outerWidth()}).append($items);
                            itemsHeight = $temp.outerHeight(true);

                            $temp.empty().attr({'class':'', 'id':''});
                            $target.append($items);

                            targetNewHeight = targetHeight + itemsHeight;
                            $target.css({
                                'height': targetNewHeight,
                                'transition': 'height ' + itemsHeight + 'ms ease'
                            });

                            targetHeight = targetNewHeight;

                            if (
                                ($dataSource.length && $dataSource.data('offset') === '')
                                ||
                                ($items.filter(options.item).add($items.find(options.item)).length < options.limit )
                            ) {
                                $this.addClass('hidden');
                                setTimeout(function () {
                                    $this.trigger('loadmore:reset', [true]);
                                }, itemsHeight);
                            }

                            $(document).trigger('loadmore:contentAdded',[$items]);
                            if ($dataSource.length){
                                options = $.extend(true, {}, options, $dataSource.data());
                                offset = options.offset;
                            } else {
                                offset += options.limit;
                            }
                        },
                        error: function (data, status, error) {
                            console.log(status, error);
                            $this.addClass('hidden').trigger('loadmore:reset', [true]);
                        },
                        complete: function () {
                            loading = false;
                        }
                    });

                });
            } else {
                $this.addClass('hidden');
            }
        });

    };

    $('.loadmore-btn').loadMore();
})(jQuery);
