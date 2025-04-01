$(function() {
    var districtDetectionError = function () {
        alert('Ошибка определения района');
    };

    getAdministrativeUnit = function (callback) {
        var geocodePosition = function(position) {
            var geocodeUrl = "/api/geocode?lglt=";

            geocodeUrl = geocodeUrl + position.coords.longitude + ',' + position.coords.latitude;

            $.get(geocodeUrl, callback);
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(geocodePosition, districtDetectionError);
        } else {
            districtDetectionError();
        }
    };

    $('.detect-district').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();

        var target = $(this).data('target');

        getAdministrativeUnit(function(data) {
            if (data.error) {
                districtDetectionError();
                return;
            }
            $(target).val(data.unit.id).change();
        });
    });
});
