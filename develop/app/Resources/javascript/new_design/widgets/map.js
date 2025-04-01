$(function () {
    var $map = $("#map"),
        myMap, objectManager,
        $funcTypeCheckboxes = $('.object-types__list input[type=checkbox]'),
        $searchInput = $('#search-query'),
        mapPadding = 150,
        mapOffset,
        MAP_CENTER = [37.6128308105, 55.755360233];
    var $mapAtlas = $('#mapAtlas');

    $('select').selectBoxIt();

    var $countySelect = $('#county-select'),
        $districtSelect = $('#district-select');

    var $submenuBtn = $('#searchAdvance');
    var $tagsBtn = $('#searchTags');
    var $subMenuClose = $('.search-from__submenu-wrap-close');
    var $submenu = $('.search-form__submenu-wrap');
    var $submenuChildren = $submenu.children();
    var submenuChildrenLength = $submenuChildren.length;
    var $tags = $('.documents-page__document-tags');

    var showMapObjects = function ($queryInput, $countySelect, $districtSelect, $funcTypeInputs) {
        var requestData = {},
            types = [];

        if (!$map.length) return;

        requestData.search = $queryInput.val();

        if ($countySelect && $districtSelect) {
            requestData.adm_unit = $districtSelect.val() || $countySelect.val();
        }

        if ($funcTypeInputs) {
            $funcTypeInputs.filter(':checked').not(':disabled').each(function () {
                types.push($(this).attr('id').replace('type-', ''));
            });

            requestData.func_type = types;
        }

        if ($timelineInput) {
            requestData.finish_year = $timelineInput.val();
        }

        $.ajax({
            'url': '/api/construction',
            'data': requestData,
            'dataType': 'json',
            'type': 'get',
            'success': function (data) {
                var l, omData = {
                    "type": "FeatureCollection",
                    "features": []
                };
                l = data.length;
                $('#search__more_results').attr('data-count', l).removeClass('hidden');
                for (; l--;) {
                    omData.features.push({
                        "type": "Feature",
                        "id": data[l].id,
                        "geometry": {
                            "type": "Point",
                            "coordinates": $.parseJSON(data[l].coords)
                        },
                        "properties": {
                            "iconContent": '<i class="checkbox-icon checkbox-' + data[l].func + '"></i>',
                            "balloonContentHeader": '<a href="' + data[l].url + '">' + data[l].name + '</a>',
                            "balloonContentBody": data[l].address,
                            "hintContent": data[l].name
                        },
                        "options": {
                            "iconLayout": 'default#imageWithContent',
                            "iconImageHref": '/images/icons/map_marker__' + data[l].status + '.png',
                            "iconImageSize": [30, 50],
                            "iconImageOffset": [-15, -49],
                            "hideIconOnBalloonOpen": false
                        }
                    });
                }

                objectManager.removeAll().add(omData);
                if (omData.features.length) {
                    myMap.setBounds(objectManager.getBounds(), {checkZoomRange: true, zoomMargin: 100}).then(function () {
                        mapOffset = myMap.getGlobalPixelCenter();
                        myMap.setGlobalPixelCenter([mapOffset[0], mapOffset[1] - mapPadding]);
                    }, function (err) {
                        console.log(err)
                    }, this);
                } else {
                    myMap.setCenter(MAP_CENTER, 11).then(function () {
                        mapOffset = myMap.getGlobalPixelCenter();
                        myMap.setGlobalPixelCenter([mapOffset[0], mapOffset[1] - mapPadding]);
                    }, function (err) {
                        console.log(err)
                    }, this);
                }
            }
        });

        $.ajax({
            'url':$('#data-map').data('source'),
            'data': requestData,
            'dataType': 'html',
            'type':'get',
            'success':function(data){
                var target = '#objects-block-wrapper',
                    newHTML = $(data).filter(target).html();

                $(target).empty().append(newHTML);
                $('.loadmore-btn').loadMore();
            }
        })

    };

    /* ARCGIS */

    function loaded() {
        if (atlas_version == '1.5.2') {
            gcapi.gcFuncs.MakeButton.Zoom({
                idmap: 'mapAtlas',
                top:20,
                left:20
            });
        }

        gcapi.AddPointLayer({
            idlayer: 'constructionObjects'
        });

        showAtlasPoints($searchInput);
    }

    function initAtlas() {
        gcapi.MapContainer="mapAtlas";
        gcapi.Zoom=1;
        gcapi.Center.x=MAP_CENTER[0];
        gcapi.Center.y=MAP_CENTER[1];
        gcapi.OnMapLoad = function() {
            loaded();
        };
    }

    var showAtlasPoints = function($queryInput, $countySelect, $districtSelect, $funcTypeInputs) {
        var requestData = {},
            types = [];

        if (!$mapAtlas.length) {
            return;
        }

        requestData.search = $queryInput.val();

        if ($countySelect && $districtSelect) {
            requestData.adm_unit = $districtSelect.val() || $countySelect.val();
        }

        if ($funcTypeInputs) {
            $funcTypeInputs.filter(':checked').not(':disabled').each(function () {
                types.push($(this).attr('id').replace('type-', ''));
            });

            requestData.func_type = types;
        }

        if ($timelineInput) {
            requestData.finish_year = $timelineInput.val();
        }

        gcapi.ClearLayer({idlayer:'constructionObjects'});

        $.ajax({
            url: '/api/construction',
            type: 'get',
            dataType: 'json',
            data: requestData,
            success: function(data) {
                var l = data.length;
                $('#search__more_results').attr('data-count', l).removeClass('hidden');
                for(; l--;) {
                    gcapi.AddPoint({
                        idlayer: 'constructionObjects',
                        idpoint: data[l].id,
                        x: $.parseJSON(data[l].coords)[0],
                        y: $.parseJSON(data[l].coords)[1],
                        symbolurl:'/images/icons/atlas-map/map_marker__' + data[l].status + '__' + data[l].func + '.png',
                        symbolwidth:30,
                        symbolheight:50,
                        fontsize:14,
                        fontname:"Arial",
                        fontcolor:"#AA0000",
                        fontbold:1,
                        fontopacity:0.5,
                        pic_x_offset:-15,
                        pic_y_offset:-49,
                        innerhtml: data[l].address,
                        title: '<a href="' + data[l].url + '">' + data[l].name + '</a>'
                    });
                }
                gcapi.AddLayerClickFunction({
                    idlayer:"constructionObjects",
                    click_fnc:function(a){
                        console.log(a);
                        gcapi.InfoWindowShow({
                            crds: {
                                x: a.x,
                                y: a.y
                            },
                            title: a.attributes.title,
                            content: a.attributes.innerhtml,
                            width:400,
                            height: 'auto',
                            InfoWindowClass:"myInfoWindow",
                            InfoWindowContentClass:"myInfoWindowContent",
                            InfoWindowTitleClass:"myInfoWindowTitle",
                            InfoWindowCloseClass:"myInfoWindowClose"
                        });
                    }
                });
                gcapi.showTitle({
                    layerid: "constructionObjects",
                    interval: 500,
                    backgroundColor: "FFFFFF",
                    color: "AAAAAA",
                    borderStyle:"dotted"
                });
            }
        });

        $.ajax({
            'url':$('#data-map').data('source'),
            'data': requestData,
            'dataType': 'html',
            'type':'get',
            'success':function(data){
                var target = '#objects-block-wrapper',
                    newHTML = $(data).filter(target).html();

                $(target).empty().append(newHTML);
                $('.loadmore-btn').loadMore();
            }
        })
    };



    /* ARCGIS */

    if ($map.length) {
        ymaps.ready(init);

        function init() {
            myMap = new ymaps.Map("map", {
                center: MAP_CENTER,
                zoom: 11,
                controls: ['zoomControl']
            });

            objectManager = new ymaps.ObjectManager({
                clusterize: true,
                clusterHasBalloon: false,
                geoObjectDisableClickZoom: false
            });

            objectManager.clusters.options.set('preset', 'islands#invertedDarkGreenClusterIcons');

            myMap.geoObjects.add(objectManager);
            //myMap.behaviors.disable(['scrollZoom']);
            showMapObjects($searchInput, $countySelect, $districtSelect, $funcTypeCheckboxes);
        }

        var keyupDelay = false;

        $districtSelect.add($searchInput).add($funcTypeCheckboxes).on('change keyup', function (e) {
            e.preventDefault();

            if (e.type == 'keyup'){
                if (!!keyupDelay){
                    return;
                } else {
                    keyupDelay = setTimeout(function(){
                        clearTimeout(keyupDelay);
                        keyupDelay = false;
                    }, 500);
                }
            }

            if ($submenuBtn.is('.active')) {
                showMapObjects($searchInput, $countySelect, $districtSelect, $funcTypeCheckboxes);
            } else {
                showMapObjects($searchInput);
            }
        });

        var $timeline = $("#timeline"),
            $timelineInput = $('#timeline-input');

        $timeline.slider({
            min: $timeline.data('range-min'),
            max: $timeline.data('range-max'),
            value: $timeline.data('range-max'),
            step: 1,
            create: function(event, ui) {
                $(event.target).find('.ui-slider-handle:first').attr('data-content', $(event.target).attr('data-value-from'));
                $(event.target).find('.ui-slider-handle:last').attr('data-content', $(event.target).attr('data-value-to'));
            },
            slide: function (event, ui) {
                $(ui.handle).attr('data-content', ui.value);
                $timelineInput.val(ui.values.join(',')).trigger('change');
            }
        });

        $timelineInput.on('change', function (e) {
            e.preventDefault();

            showMapObjects($searchInput, $countySelect, $districtSelect, $funcTypeCheckboxes, $timelineInput);
        });
    }

    if ($mapAtlas.length) {
        gcapi.ready = function() {
            initAtlas();
        };

        $countySelect.on('change', function () {
            var currentCounty = $countySelect.find(':selected').val(),
                $allDistricts = $districtSelect.find('option').addClass('hidden').prop('selected', false),
                $countyDistricts = $allDistricts.filter('[data-county="' + currentCounty + '"]').removeClass('hidden'),
                selectBox;

            if (currentCounty != '') {
                $districtSelect.prop('disabled', false);
            } else {
                $districtSelect.prop('disabled', true);
            }

            $districtSelect.val($countyDistricts.eq(0).val()).trigger('change');

            selectBox = $districtSelect.data('selectBox-selectBoxIt') || $districtSelect.data('selectBox');

            if (selectBox) {
                selectBox.refresh();
            }
        });

        var keyupDelay = false;

        $districtSelect.add($searchInput).add($funcTypeCheckboxes).on('change keyup', function (e) {
            e.preventDefault();
            if (e.type == 'keyup'){
                if (!!keyupDelay){
                    return;
                } else {
                    keyupDelay = setTimeout(function(){
                        clearTimeout(keyupDelay);
                        keyupDelay = false;
                    }, 500);
                }
            }

            if ($submenuBtn.is('.active')) {
                showAtlasPoints($searchInput, $countySelect, $districtSelect, $funcTypeCheckboxes);
            } else {
                showAtlasPoints($searchInput);
            }
        });

        var $timeline = $("#timeline"),
            $timelineInput = $('#timeline-input');

        $timeline.slider({
            min: $timeline.data('range-min'),
            max: $timeline.data('range-max'),
            value: $timeline.data('range-max'),
            step: 1,
            create: function(event, ui) {
                $(event.target).find('.ui-slider-handle:first').attr('data-content', $(event.target).attr('data-value-from'));
                $(event.target).find('.ui-slider-handle:last').attr('data-content', $(event.target).attr('data-value-to'));
            },
            slide: function (event, ui) {
                $(ui.handle).attr('data-content', ui.value);
                $timelineInput.val(ui.values.join(',')).trigger('change');
            }
        });

        $timelineInput.on('change', function (e) {
            e.preventDefault();

            showAtlasPoints($searchInput, $countySelect, $districtSelect, $funcTypeCheckboxes, $timelineInput);
        });
    }

    //var submenuSelect = $('.area-block').outerHeight();
    //var submenuCheck = $('.search-form__object-types').outerHeight();

    $tagsBtn.on('click', function(e) {
        e.preventDefault();
        var tagHeight = $tags.outerHeight();

        if ($tagsBtn.hasClass('active')) {
            $tags.css('display', 'none');
            $submenu.css({'height': 0, 'overflow': 'hidden'}).attr('tabindex', -1);
            $tagsBtn.removeClass('active');
        } else {
            $submenuChildren.not('.documents-page__document-tags').css('display', 'none');
            $tags.css('display', 'block');
            $submenu.css({'height' : tagHeight, 'visibility': 'visible'}).removeAttr('tabindex');
            $tagsBtn.addClass('active');
        }
        $submenuBtn.removeClass('active');
    });

    $subMenuClose.on('click', function() {
        $tags.css('display', 'none');
        $submenu.css({'height': 0, 'overflow': 'hidden'}).attr('tabindex', -1);
        $tagsBtn.removeClass('active');
        $submenuBtn.removeClass('active');
    });

    $submenuBtn.on('click', function (e) {
        var allHeight = 0;
        for (var i = 0; i < submenuChildrenLength; i++) {
            if ($submenuChildren.eq(i).hasClass('active')) {
                allHeight += $submenuChildren.eq(i).outerHeight();
            }
        }
        $submenuChildren.filter('.active').css('display', 'block');
        e.preventDefault();
        if ($submenuBtn.hasClass('active')) {
            $submenuBtn.removeClass('active');
            $submenu.css({'height': 0, 'overflow': 'hidden'}).attr('tabindex', -1);
        } else {
            $submenuBtn.addClass('active');
            $submenu.css({'height': allHeight, 'visibility': 'visible'}).removeAttr('tabindex');
            //$submenu.css({'height': submenuSelect + submenuCheck, 'visibility': 'visible'}).removeAttr('tabindex');
        }
        $tagsBtn.removeClass('active');
        $tags.css('display', 'none');
    });

    $submenu.on('transitionend', function () {
        var height = $submenu.outerHeight();

        if (height) {
            $submenu.css({'overflow': 'visible'});
        } else {
            $submenu.css({'visibility': 'hidden'});
        }
    });

    $countySelect.on('change', function () {
        var currentCounty = $countySelect.find(':selected').val(),
            $allDistricts = $districtSelect.find('option').addClass('hidden').prop('selected', false),
            $countyDistricts = $allDistricts.filter('[data-county="' + currentCounty + '"]').removeClass('hidden'),
            selectBox;

        if (currentCounty != '') {
            $districtSelect.prop('disabled', false);
        } else {
            $districtSelect.prop('disabled', true);
        }

        $districtSelect.val($countyDistricts.eq(0).val()).trigger('change');

        selectBox = $districtSelect.data('selectBox-selectBoxIt') || $districtSelect.data('selectBox');

        if (selectBox) {
            selectBox.refresh();
        }
    });

    var manuallySelectDistrict = function (districtId)
    {
        var county = $districtSelect.find('option[value="' + districtId + '"]').data('county');

        $countySelect.val(county).trigger('change');
        $districtSelect.val(districtId).trigger('change');
    };

    var $selectMyDistrictLink = $('#select-my-district-link');
    $selectMyDistrictLink.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var districtId = $(e.target).data('adm-unit-id');

        manuallySelectDistrict(districtId);
    });

    var $detectMyDistrictLink = $('#detect-my-district-link');
    $detectMyDistrictLink.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var onAdministrativeUnitDetected = function (data) {
            var districtId = data.unit.id;

            manuallySelectDistrict(districtId);
        };

        getAdministrativeUnit(onAdministrativeUnitDetected);
    });
});
