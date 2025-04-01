function PolygonEditor(mapContainerId, $geoPolygonInput, COORDS = [37.64, 55.76]) {
    var DEFAULT_COORDS = COORDS,
        map = new ymaps.Map(mapContainerId, {controls: ['fullscreenControl', 'zoomControl'], center: DEFAULT_COORDS, zoom: 10}),
        polygonEditModeBtn = new ymaps.control.Button({data: {content: 'Редактировать полигон'}, options: {selectOnClick: true, visible: false, maxWidth: 200}}),
        polygonDeleteBtn = new ymaps.control.Button({data: {content: 'Удалить полигон'}, options: {selectOnClick: false, visible: false, maxWidth: 200}}),
        polygon;

    function init() {
        map.events.add('click', onMapClick);
        map.events.add('sizechange', zoomToObject);

        polygonEditModeBtn.events.add('select', onPolygonEditModeBtnSelect, this);
        polygonEditModeBtn.events.add('deselect', onPolygonEditModeBtnDeselect, this);
        map.controls.add(polygonEditModeBtn);

        polygonDeleteBtn.events.add('press', onPolygonDeleteBtnPress, this);
        map.controls.add(polygonDeleteBtn);

        if ($geoPolygonInput.val()) {
            createPolygon(JSON.parse($geoPolygonInput.val()));
            zoomToObject();
        }
    }

    function createPolygon(geometry) {
        var props = {};
        var options = {fillColor: '#00FF0088', strokeWidth: 5, visible: true};

        polygon = new ymaps.Polygon(geometry, props, options);
        map.geoObjects.add(polygon);

        showBtns(polygonEditModeBtn, polygonDeleteBtn);
    }

    function zoomToObject() {
        if (polygon) {
            map.setBounds(polygon.geometry.getBounds(), {checkZoomRange: true, zoomMargin: 50})
        }
    }

    function onMapClick(e) {
        var coords = e.get('coords');

        if (polygon) return true;

        createPolygon([[coords],[]]);

        polygon.editor.state.set('editing', true);
        polygonEditModeBtn.state.set('selected', true);
    }

    function onPolygonEditModeBtnSelect() {
        polygon.editor.state.set('editing', true);
    }

    function onPolygonEditModeBtnDeselect() {
        polygon.editor.state.set('editing', false);

        $geoPolygonInput.val(JSON.stringify(polygon.geometry.getCoordinates()));
    }

    function onPolygonDeleteBtnPress() {
        $geoPolygonInput.val('');

        map.geoObjects.remove(polygon);
        polygon = null;

        hideBtns(polygonEditModeBtn, polygonDeleteBtn);
    }

    function hideBtns() {
        Array.prototype.slice.call(arguments).forEach(function (btn) {
            btn.options.set('visible', false);
        })
    }

    function showBtns() {
        Array.prototype.slice.call(arguments).forEach(function (btn) {
            btn.options.set('visible', true);
        })
    }

    return {
        init: init
    };
}
