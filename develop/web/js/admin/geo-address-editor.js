function AddressEditor(mapContainerId, $geoPointInput, $textInput) {
    var DEFAULT_COORDS = [37.64, 55.76],
        MOSCOW_BOUNDS = [[37.32624,55.491126],[37.967682,55.957565]],
        map = createMap(),
        deletePlacemarkBtn = new ymaps.control.Button({data: {content: 'Удалить метку'}, options: {selectOnClick: false, visible: false, maxWidth: 200}}),
        acceptFoundAddressBtn = $textInput.length ? new ymaps.control.Button({data: {content: 'Принять найденный адрес'}, options: {selectOnClick: false, visible: false, maxWidth: 200}}) : null,
        suggestView = $textInput.length ? new ymaps.SuggestView($textInput.attr('id'), {boundedBy: MOSCOW_BOUNDS}) : null,
        placemark,
        foundAddressPending;

    function init() {
        map.events.add('click', onMapClick);
        map.events.add('sizechange', zoomToObject);

        deletePlacemarkBtn.events.add('press', onDeletePlacemarkBtnPress, this);
        map.controls.add(deletePlacemarkBtn);

        if (acceptFoundAddressBtn) {
            acceptFoundAddressBtn.events.add('press', onAcceptFoundAddressBtnPress, this);
            map.controls.add(acceptFoundAddressBtn);
        }

        if (suggestView) {
            suggestView.events.add('select', onSuggestViewSelect, this);
        }

        $geoPointInput.on('keydown,keypress,keyup', function (e) {
            if (e.which === 13) {
                $geoPointInput.trigger('change');
                return false;
            }
        });

        $geoPointInput.on('change', onGeoPointInputChange);

        createPlacemark();
    }

    function onGeoPointInputChange(e) {
        e.preventDefault();

        var coords = e.target.value.split(',').reverse();

        createPlacemark();

        queryForAddress(coords);
    }

    function getAddress(){
        return $textInput.length && $textInput.val().replace(/^Россия, Москва, /, '') || '';
    }

    function createMap() {
        var mapState = {controls: ['fullscreenControl', 'zoomControl'], center: DEFAULT_COORDS, zoom: 10};

        return new ymaps.Map(mapContainerId, mapState);
    }

    function zoomToObject() {
        if (placemark) {
            map.setBounds(placemark.geometry.getBounds(), {checkZoomRange: true, zoomMargin: 100});
        }
    }

    function createPlacemark() {
        var coords = $geoPointInput.val();

        if (placemark && map.geoObjects.indexOf(placemark) > -1) {
            map.geoObjects.remove(placemark);
        }
        
        if (coords) {
            placemark = new ymaps.Placemark(coords.split(','), {
                iconContent: getAddress(),
                balloonContent: [getAddress(), coords].filter(function (v) { return !!v; }).join('\n')
            }, {
                preset: 'islands#violetStretchyIcon',
                draggable: false
            });
            map.geoObjects.add(placemark);
            showDeletePlacemarkBtn();

            zoomToObject();
        }
    }

    function onAcceptFoundAddressBtnPress() {
        if ($textInput.length) {
            $textInput.val(foundAddressPending);
        }

        hideAcceptFoundAddressBtn();
    }

    function onDeletePlacemarkBtnPress() {
        if (placemark) {
            hideAcceptFoundAddressBtn();
            $geoPointInput.val('');
            //$textInput.val(''); // don't delete manually typed text!
            map.geoObjects.remove(placemark);
        }

        hideDeletePlacemarkBtn();
    }

    function hideDeletePlacemarkBtn() {
        deletePlacemarkBtn.options.set('visible', false);
    }

    function showDeletePlacemarkBtn() {
        deletePlacemarkBtn.options.set('visible', true);
    }

    function onSuggestViewSelect(e) {
        var item = e.get('item');

        ymaps.geocode(item.value).then(onGeocoderQuerySuccess, function () {}, function () {}, this);
    }

    function onGeocoderQuerySuccess(res) {
        var foundGeoObject = res.geoObjects.get(0),
            lonLat = foundGeoObject.geometry.getCoordinates(),
            bounds = foundGeoObject.properties.get('boundedBy');

        $geoPointInput.val(lonLat);

        createPlacemark();

        placemark.properties.set({
            iconContent: foundGeoObject.properties.get('name'),
            balloonContent: [foundGeoObject.properties.get('name'), lonLat].join('\n')
        });

        map.setBounds(bounds, {checkZoomRange: true});

        // we don't need to confirm address selected from suggestion — the user can always adjust it by clicking the map
    }

    function onMapClick(e) {
        var coords = e.get('coords');

        $geoPointInput.val(coords);

        createPlacemark();

        queryForAddress(coords);
    }

    function queryForAddress(coords) {
        ymaps.geocode(coords).then(onQueryForAddressSuccess, function () {}, function () {}, this);
    }

    function onQueryForAddressSuccess(res) {
        var foundGeoObject = res.geoObjects.get(0);

        placemark.properties.set({
            iconContent: foundGeoObject.properties.get('name'),
            balloonContent: [foundGeoObject.properties.get('name'), res.metaData.geocoder.request.split(',').reverse().join(',')].join('\n')
        });

        foundAddressPending = foundGeoObject.properties.get('text') || '';
        showAcceptFoundAddressBtn();
    }

    function showAcceptFoundAddressBtn() {
        if (acceptFoundAddressBtn) {
            acceptFoundAddressBtn.options.set('visible', true);
        }
    }

    function hideAcceptFoundAddressBtn() {
        if (acceptFoundAddressBtn) {
            acceptFoundAddressBtn.options.set('visible', false);
        }
    }

    //function switchToPlacemark() {
        //polygon.options.set('visible', false);
        //placemark.options.set('visible', true);

        //hidePolygonEditModeBtn();
        //showAcceptFoundAddressBtn();
        //polygonEditModeBtn.deselect();
        //zoomToObject();
    //}

    //function switchToPolygon() {
    //    polygon.options.set('visible', true);
    //    placemark.options.set('visible', false);
    //
    //    showPolygonEditModeBtn();
    //    hideAcceptFoundAddressBtn();
    //    placemark.balloon.close();
    //    zoomToObject();
    //}

    //function hidePolygonEditModeBtn() {
    //    polygonEditModeBtn.options.set('visible', false);
    //}

    //function showPolygonEditModeBtn() {
    //    polygonEditModeBtn.options.set('visible', true);
    //}

    //function onPolygonEditModeBtnSelect() {
    //    polygon.editor.state.set('editing', true);
    //}

    //function onPolygonEditModeBtnDeselect() {
    //    polygon.editor.state.set('editing', false);
    //
    //    $geoPolygonInput.val(ymaps.geometry.Polygon.toEncodedCoordinates(polygon.geometry));
    //}

    return {
        init: init
        //switchToPolygon: switchToPolygon,
        //switchToPlacemark: switchToPlacemark
    };
}
