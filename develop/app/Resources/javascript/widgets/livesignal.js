$(function () {
    var $livesignal_widget = $('[data-livesignal]');
    if ($livesignal_widget) {

      $.ajax({
        url: 'https://www.livesignal.ru/urban/ru.js',
        type: 'GET',
        dataType: 'text json',
        success: function(data){ 
          var data_ru = data;
          $.ajax({
            url: 'https://www.livesignal.ru/urban/en.js',
            type: 'GET',
            dataType: 'text json',
            success: function(data){ 
              var data_en = data;
              initLivesignalWidget(data_ru, data_en);
            }
          });
        }
      });
    }

    function initLivesignalWidget(data_ru, data_en) {
      var names_ru = ['Щусев', 'Осман', 'Мозес', 'Рен', 'Лe Корбюзье', 'Нимейер', 'Серда', 'Ли Куан Ю'];
      var names_en = ['Shchusev', 'Haussmann', 'Moses', 'Wren', 'Le Corbusier', 'Niemeyer', 'Cerda', 'Lee Kuan Yew'];

      var stream_data = [];

      $.each(names_ru, function(index, item) {
        stream_data.push({
          'name_ru': names_ru[index],
          'name_en': names_en[index],
          'url_ru': data_ru['ru']['room_'+(index+1)],
          'url_en': data_en['en']['room_'+(index+1)]
        });
      });

      $livesignal_widget.addClass('livesignal-widget');
      $livesignal_widget.append('<div class="livesignal-widget__lang"><span class="livesignal-widget__lang-item active" data-livesignal-lang="ru"><img src="/images/icons/flag-ru.png" alt=""> ru</span><span class="livesignal-widget__lang-item" data-livesignal-lang="en"><img src="/images/icons/flag-en.png" alt=""> en</span><div>');
      $livesignal_widget_lang = $livesignal_widget.find('.livesignal-widget__lang');
      $livesignal_widget.append('<ul class="livesignal-widget__tabs"></ul>');
      $livesignal_widget_tabs = $livesignal_widget.find('.livesignal-widget__tabs');
      $.each(stream_data, function(index, item) {
        $livesignal_widget_tabs.append('<li class="livesignal-widget__tab" data-livesignal-tab="ru" data-livesignal-tab-url="' + item['url_ru'] + '"  data-livesignal-tab-index="' + index + '">' + item['name_ru'] + '</li>');
        $livesignal_widget_tabs.append('<li class="livesignal-widget__tab" data-livesignal-tab="en" data-livesignal-tab-url="' + item['url_en'] + '" data-livesignal-tab-index="' + index + '">' + item['name_en'] + '</li>');
      });
      $livesignal_widget.append('<div class="livesignal-widget__content"></div>');
      $livesignal_widget_content = $livesignal_widget.find('.livesignal-widget__content');

      $(document).on('click tap', '[data-livesignal-lang]', function(e) {
        e.preventDefault();
        updateLivesignalWidgetLang($(this).data('livesignal-lang'));
      });

      $(document).on('click tap', '[data-livesignal-tab]', function(e) {
        e.preventDefault();
        updateLivesignalWidgetContent($(this).data('livesignal-tab-index'), $(this).data('livesignal-tab'));
      });

      updateLivesignalWidgetLang('ru');
    }

    function updateLivesignalWidgetLang(lang) {
      $livesignal_widget_lang.find('[data-livesignal-lang]').removeClass('active');
      $livesignal_widget_lang.find('[data-livesignal-lang="' + lang + '"]').addClass('active');

      $livesignal_widget_tabs.find('li').removeClass('active').hide();
      $livesignal_widget_tabs.find('li[data-livesignal-tab="' + lang + '"]').show();

      updateLivesignalWidgetContent(0, lang);
    }

    function updateLivesignalWidgetContent(tab, lang) {
      $livesignal_widget_tabs.find('li').removeClass('active');
      var $active_tab = $livesignal_widget_tabs.find('li[data-livesignal-tab="' + lang + '"][data-livesignal-tab-index="' + tab + '"]');
      $($active_tab).addClass('active');

      $livesignal_widget_content.html('');
      $livesignal_widget_content.html('<iframe width="685" height="385" src="' + $($active_tab).data('livesignal-tab-url') + '?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>')
      
    }

    

})
