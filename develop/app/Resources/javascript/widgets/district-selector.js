$(function () {
  $('[data-district-selector]').each(function(index) {
    var t = this;

    var $container = this;
    var $dropdown = $(this).find('[data-district-selector-dropdown]');
    var $districtSelectorBtn = $(this).find('[data-district-selector-btn]');
    var $districtList = $(this).find('[data-district-selector-district-list]');
    var $municipalityList = $(this).find('[data-district-selector-municipality-list]');
    var municipality = [];

    function sortByField(field) {
      return function(a, b) {
        var nameA = a[field].toUpperCase();
        var nameB = b[field].toUpperCase();
        if (nameA < nameB) { return -1; }
        if (nameA > nameB) { return 1; }
        return 0;
      }
    }

    function getJson() { return $.ajax({ 'dataType': 'json', 'url': '/api/v1/administrative_areas' }); }

    function initDistrictSelector(data) {

      data.sort(sortByField('abbriviation'));

      $.each(data, function(index, item) {
        $($districtList).append('<li class="district-selector__dropdown-district-item"><a href class="district-selector__dropdown-district-item-link" data-district-selector-district-item-link>' + item.abbriviation + '</a></li>');
        $($municipalityList).append('<li class="district-selector__dropdown-municipality-item"><a href="' + item.url + '" class="district-selector__dropdown-municipality-item-link" data-district-selector-municipality-item-link=' + item.abbriviation + '>Перейти к округу ' + item.abbriviation + '</a></li>');
        $.each(item.districts, function(index, municipality_item) {
          municipality.push({'id': municipality_item.id, 'title': municipality_item.title, 'district': item.abbriviation, 'url': municipality_item.url});
        });
      });

      municipality.sort(sortByField('title'));

      $.each(municipality, function(index, municipality_item) {
        $($municipalityList).append('<li class="district-selector__dropdown-municipality-item"><a href="' + municipality_item.url + '" class="district-selector__dropdown-municipality-item-link" data-district-selector-municipality-item-link=' + municipality_item.district + '>' + municipality_item.title + '</a></li>');
      });

      $($container).on('click tap', '[data-district-selector-district-item-link]', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var t = this;
        $($municipalityList).addClass('active');
        $($container).find('[data-district-selector-municipality-item-link]').parent().removeClass('active');
        $($container).find('[data-district-selector-municipality-item-link="' + $(t).text() + '"]').parent().addClass('active');
        $($container).find('[data-district-selector-district-item-link]').removeClass('active');
        $(t).addClass('active');
      });

      $($districtSelectorBtn).on('click tap', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $($dropdown).toggleClass('active');
      });

      // $($dropdown).on('click tap', function(e){
      //   e.stopPropagation();
      // });

      $(document).on('click tap', function(){
        $($dropdown).removeClass('active');
      });
    }

    $.when(getJson()).done(function(data){ initDistrictSelector(data) });
  });
})
