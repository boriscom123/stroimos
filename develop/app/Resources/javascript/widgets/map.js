$(function () {
    function debounce(func, wait, immediate) {
        var timeout;

        return function executedFunction() {
            var context = this;
            var args = arguments;

            var later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };

            var callNow = immediate && !timeout;

            clearTimeout(timeout);

            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

   function getCookie() {
       var cookie = document.cookie.split("; ").reduce(function (acc, item) {
           var [name, value] = item.split("=");
           acc[name] = value;
           return acc;
       }, {});
       return cookie;
   }

   var knownTypes = [
       "pedestrian-bridge",
       "renov-house",
       "problem-construction",
       "appartement",
       "poezda",
       "admin-center",
       "all",
       "culture",
       "house",
       "road",
       "garage",
       "health",
       "hotels",
       "ironroad",
       "sport",
       "industrial",
       "metro",
       "playschool",
       "school",
       "trade",
       "stay",
       "educational",
       "novaia-moskva",
       "religion",
       "entertainment",
       "tpu",
       "other",
       "renov-industrial",
       "renov-house",
       "pedestrian-bridge",
       "appartement",
       "cinema",
       "park",
   ];

   var $map = $("#map"),
       $near = $("#nearObject"),
       myMap,
       objectManager,
       $funcTypeCheckboxes = $(".object-types__list input[type=checkbox]"),
       $searchInput = $("#search-query"),
       MAP_CENTER = [37.6128308105, 55.755360233];

   var $mapAtlas = $("#mapAtlas");

   $("map-block select").selectBoxIt();

   var $countySelect = $("#county-select"),
       $districtSelect = $("#district-select");

   var $submitBtn = $(".news-search__form-block-btn");
   var $submenuBtn = $("#searchAdvance");
   var $tagsBtn = $("#searchTags");
   var $subMenuClose = $(".search-from__submenu-wrap-close");
   var $submenu = $(".search-form__submenu-wrap");
   var $submenuChildren = $submenu.children();
   var submenuChildrenLength = $submenuChildren.length;
   var $tags = $(".documents-page__document-tags");
   var $mapContainer = $("#map-container");
   var $filterContentContainer = $(".map-block .search-form__wrap");
   var $filterContentContainerInputs = $filterContentContainer.find(
       'input[type="checkbox"], input#timeline-input, select'
   );

   var request1Def = $.Deferred(),
       request2Def = $.Deferred(),
       lastSearchInput = "";

   var showMapSpinner = function () {
       $mapContainer.addClass("loading");
   };

   var hideMapSpinner = function () {
       $mapContainer.removeClass("loading");
   };

   var disableFilter = function () {
       $filterContentContainer.addClass("disabled");
       $filterContentContainerInputs.each(function () {
           $(this).attr("disabled", true);
       });
       $("#timeline").slider("disable");
   };

   var filterTimeout = false;

   var enableFilter = function () {
       filterTimeout && clearTimeout(filterTimeout);
       filterTimeout = setTimeout(function () {
           $filterContentContainer.removeClass("disabled");
           $filterContentContainerInputs.each(function () {
               $(this).removeAttr("disabled");
               var selectBox =
                   $(this).data("selectBox-selectBoxIt") ||
                   $(this).data("selectBox");
               if (selectBox) {
                   selectBox.refresh();
               }
           });
           $("#timeline").slider("enable");
           filterTimeout = false;
       }, 1000);
   };

   var getOmData = function (data, presets, requestDataPreset) {
       var omData = {
           geoObjects: [],
           featureCollection: {
               type: "FeatureCollection",
               features: [],
           },
       };
       var l = data.length;
       $("#search__more_results").attr("data-count", l).removeClass("hidden");
       for (; l--; ) {
           var status;
           if (requestDataPreset == "renovation") {
               status = data[l].func;
           } else if ($.inArray(data[l].func, knownTypes) == -1) {
               status = "default";
           } else {
               status = data[l].func;
           }

           var icon;
           if (requestDataPreset == "problem") {
               icon = "construction";
           } else if (requestDataPreset == "overpasses") {
               if (
                   data[l].status == "documentation" ||
                   data[l].status == "documentation_underdeveloped"
               ) {
                   icon = "overpass" + "-" + "documentation";
               } else if (data[l].status == "operation") {
                   icon = "overpass" + "-" + "complete";
               } else {
                   icon = "overpass" + "-" + data[l].status;
               }
           } else if (
               presets[requestDataPreset] &&
               $.inArray(
                   data[l].func,
                   presets[requestDataPreset]["func_type"]
               ) != -1
           ) {
               icon = data[l].func;
               if (data[l].func == "dhouse" && data[l]?.destroyed == true) {
                   icon = data[l].func + "-destroyed";
               }
           } else {
               icon = data[l].status;
           }
           var functional =
               data[l].functional === undefined
                   ? ""
                   : "<li><strong>Функциональное назначение:</strong> " +
                     data[l].functional +
                     "</li>";
           var finance =
               data[l].finance === undefined
                   ? ""
                   : "<li><strong>Источник финансирования:</strong> " +
                     data[l].finance +
                     "</li>";
           var end_year =
               data[l].end_year === undefined
                   ? ""
                   : "<li><strong>Срок ввода:</strong> " +
                     data[l].end_year +
                     "</li>";
           var address =
               data[l].address === undefined
                   ? ""
                   : "<li><strong>Адрес:</strong> " + data[l].address + "</li>";
           var address_s = data[l].address === undefined ? "" : data[l].address;
           var link =
               data[l].url === undefined
                   ? ""
                   : '<a class="map-block_balloon-link" target="_blank" href="' +
                     data[l].url +
                     '">Перейти к объекту</a>';
           var obj = undefined;
           var polygon = undefined;

           if (
               data[l].func == "renov-industrial" &&
               data[l].polygon != undefined &&
               data[l].polygon != ""
           ) {
               polygon = new ymaps.Polygon(
                   $.parseJSON(data[l].polygon),
                   {
                       balloonContentHeader: data[l].url
                           ? '<a href="' +
                             data[l].url +
                             '" target="_blank">' +
                             data[l].name +
                             "</a>"
                           : data[l].name,
                       balloonContentBody:
                           '<ul class="map_balloonContent>' +
                           address +
                           end_year +
                           "</ul>" +
                           link,
                       hintContent: data[l].name,
                   },
                   {
                       opacity: 0.75,
                       fillColor: "rgba(255,255,255,0.5)",
                       fillImageHref: "/images/icons/idustrial-bg.png",
                       fillMethod: "tile",
                       strokeColor: "#5b5b4f",
                       strokeWidth: 2,
                   }
               );
               //omData.geoObjects.push(polygon);
           }
           if (data[l].func == "polygon") {
               polygon = new ymaps.Polygon(
                   $.parseJSON(data[l].polygon),
                   {
                       balloonContentHeader: data[l].name,
                       hintContent: data[l].name,
                   },
                   {
                       opacity: 0.75,
                       fillColor: "rgba(70,165,205,0.5)",
                       fillMethod: "tile",
                       strokeColor: "#46a5cd",
                       strokeWidth: 10,
                   }
               );
               //omData.geoObjects.push(polygon);
           } else {
               obj = {
                   type: "Feature",
                   id: data[l].id,
                   geometry: {
                       type: "Point",
                       //coordinates: $.parseJSON(data[l].coords)
                       coordinates: JSON.parse(data[l].coords),
                   },
                   properties: {
                       iconContent:
                           requestDataPreset == "overpasses"
                               ? ""
                               : '<i class="checkbox-icon checkbox-' +
                                 status +
                                 '"></i>',
                       balloonContentHeader: data[l].url
                           ? '<a href="' +
                             data[l].url +
                             '" target="_blank">' +
                             data[l].name +
                             "</a>"
                           : data[l].name,
                       balloonContentBody:
                           '<ul class="map_balloonContent">' +
                           address +
                           end_year +
                           "</ul>" +
                           link,
                       hintContent: data[l].name + " <br /> " + address_s,
                   },
                   options: {
                       iconLayout: "default#imageWithContent",
                       iconImageHref:
                           "/images/icons/map_marker__" + icon + ".svg",
                       iconImageSize: [37, 45],
                       iconImageOffset: [-19, -22],
                       hideIconOnBalloonOpen: false,
                   },
               };

               omData.featureCollection.features.push(obj);
           }
       }
       return omData;
   };

   var processMapData = function (data, presets, requestDataPreset) {
       var omData = getOmData(data, presets, requestDataPreset);

       myMap.setZoom(10);

       objectManager.removeAll().add(omData.featureCollection);

       $.each(omData.geoObjects, function (key, item) {
           myMap.geoObjects.add(item);
       });

       if (
           presets[requestDataPreset] &&
           presets[requestDataPreset].customPosition
       ) {
           myMap.setCenter(
               presets[requestDataPreset].customPosition.position,
               presets[requestDataPreset].customPosition.zoom
           );
           myMap
               .panTo(presets[requestDataPreset].customPosition.position, {
                   duration: 1000,
               })
               .then(function () {
                   request1Def.resolve();
               });
       } else if ($mapContainer.data("polygon") && omData.geoObjects.length) {
           var polygon = omData.geoObjects[0];
           myMap
               .setBounds(polygon.geometry.getBounds(), {
                   checkZoomRange: true,
                   zoomMargin: 100,
                   duration: 1000,
               })
               .then(function () {
                   request1Def.resolve();
               });
       } else if (omData.featureCollection.features.length) {
           myMap
               .setBounds(objectManager.getBounds(), {
                   checkZoomRange: true,
                   zoomMargin: 100,
                   duration: 1000,
               })
               .then(function () {
                   request1Def.resolve();
               });
       } else {
           myMap
               .panTo(MAP_CENTER, {
                   duration: 1000,
               })
               .then(function () {
                   request1Def.resolve();
               });
       }
       hideMapSpinner();
       enableFilter();
   };

   var showMapObjects = function (
       $queryInput,
       $countySelect,
       $districtSelect,
       $funcTypeInputs
   ) {
       showMapSpinner();
       disableFilter();

       var requestData = {},
           types = [];

       if (!$map.length) return;

       var presets = [];
       presets["renovation"] = {
           //func_type: ['renov-1719', 'renov-2023', 'renov-22plus', 'dhouse', 'shouse', 'renov-bld']
           func_type: ["renovation", "dhouse", "shouse", "renov-house"],
       };
       presets["renov-industrial"] = {
           func_type: ["renov-industrial"],
           customPosition: {
               position: MAP_CENTER,
               zoom: 11,
           },
       };
       presets["tpu"] = {
           func_type: ["tpu"],
           customPosition: {
               position: MAP_CENTER,
               zoom: 11,
           },
       };
       presets["overpasses"] = {
           func_type: ["road"],
           road_type: ["overpass"],
           customPosition: {
               position: MAP_CENTER,
               zoom: 11,
           },
       };
       presets["problem"] = {
           func_type: ["problem-construction"],
           customPosition: {
               position: MAP_CENTER,
               zoom: 8,
           },
       };

       var requestDataPreset = $mapContainer.data("preset");
       if (presets[requestDataPreset] && requestDataPreset != "renovation") {
           requestData = presets[requestDataPreset];
       } else {
           requestData.search = $queryInput.val();

           if ($countySelect && $districtSelect) {
               requestData.adm_unit =
                   $districtSelect.val() || $countySelect.val();
           }

           if ($funcTypeInputs) {
               $funcTypeInputs.filter(":checked").each(function () {
                   types.push($(this).attr("id").replace("type-", ""));
               });
               requestData.func_type = types;
               if (
                   requestDataPreset == "renovation" &&
                   requestData.func_type.length == 0
               ) {
                   requestData.func_type = presets["renovation"].func_type;
               }
           }

           if ($timelineInput) {
               requestData.finish_year = $timelineInput.val();
           }
       }

       var customData = $mapContainer.data("custom");
       var customPolygon = $mapContainer.data("polygon");
       var customPolygonName = $mapContainer.data("polygon-name");
       var customPolygonNamePrefix = $mapContainer.data("polygon-name-prefix")
           ? $mapContainer.data("polygon-name-prefix") + " "
           : "";
       if (customData) {
           // Lazy? Backend refactoring?
           if (customPolygon) {
               var polygon = {
                   id: "polygon",
                   polygon: JSON.stringify([
                       customPolygon.coordinates[0][0],
                       [],
                   ]),
                   name:
                       customPolygonNamePrefix + "«" + customPolygonName + "»",
                   func: "polygon",
               };
               customData.push(polygon);
           }
           processMapData(customData, presets, requestDataPreset);
       } else {
           $.ajax({
               url: "/api/construction",
               data: requestData,
               dataType: "json",
               type: "get",
               success: function (data) {
                   // KOSTYL???
                   if (requestDataPreset == "renovation") {
                       $.ajax({
                           dataType: "json",
                           url: "/dhouse-destroyed.json",
                           success: function (extraData) {
                               $.ajax({
                                   dataType: "json",
                                   url: "/shouse.json",
                                   success: function (extraData2) {
                                       extraData = $.merge(
                                           extraData,
                                           extraData2
                                       );
                                       var extraDataFiltered = extraData;
                                       if (
                                           typeof requestData.func_type !==
                                               "undefined" &&
                                           requestData.func_type.length > 0
                                       ) {
                                           extraDataFiltered = extraData.filter(
                                               (item) =>
                                                   $.inArray(
                                                       item.func,
                                                       requestData.func_type
                                                   ) != -1
                                           );
                                       }
                                       if (
                                           typeof requestData.adm_unit !==
                                               "undefined" &&
                                           requestData.adm_unit.length > 0
                                       ) {
                                           if ($districtSelect.val()) {
                                               extraDataFiltered =
                                                   extraDataFiltered.filter(
                                                       (item) =>
                                                           item.ID_rayon ==
                                                           $districtSelect.val()
                                                   );
                                           } else {
                                               extraDataFiltered =
                                                   extraDataFiltered.filter(
                                                       (item) =>
                                                           item.ID_okrug ==
                                                           $countySelect.val()
                                                   );
                                           }
                                       }
                                       if (
                                           typeof requestData.search !==
                                               "undefined" &&
                                           requestData.search.length > 0
                                       ) {
                                           extraDataFiltered =
                                               extraDataFiltered.filter(
                                                   (item) =>
                                                       item.address
                                                           .toLowerCase()
                                                           .indexOf(
                                                               requestData.search.toLowerCase()
                                                           ) >= 0
                                               );
                                       }
                                       data = $.merge(extraDataFiltered, data);
                                       processMapData(
                                           data,
                                           presets,
                                           requestDataPreset
                                       );
                                   },
                               });
                           },
                       });
                   } else {
                       processMapData(data, presets, requestDataPreset);
                   }
               },
               error: function (data) {
                   hideMapSpinner();
                   enableFilter();
               },
           });
           $.ajax({
               url: $("#data-map").data("source"),
               data: requestData,
               dataType: "html",
               type: "get",
               success: function (data) {
                   var target = "#objects-block-wrapper",
                       newHTML = $(data).filter(target).html();

                   $(target).empty().append(newHTML);
                   $(document).trigger("data-map:contentAdded");
                   $(".loadmore-btn").loadMore();
                   request2Def.resolve();
               },
           });

           $.when(request1Def, request2Def).then(function (r1d, r2d) {
               var lastSearchRequest =
                   requestData.search === undefined ? "" : requestData.search;
               if (lastSearchInput != lastSearchRequest) {
                   request1Def = $.Deferred();
                   request2Def = $.Deferred();
                   if (
                       $submenuBtn.is(".active") ||
                       $mapContainer.data("preset") == "renovation"
                   ) {
                       showMapObjects(
                           $searchInput,
                           $countySelect,
                           $districtSelect,
                           $funcTypeCheckboxes,
                           $timelineInput
                       );
                   } else {
                       showMapObjects($searchInput);
                   }
               }
           });
       }
   };

   /* ARCGIS */

   function loaded() {
       if (atlas_version == "1.5.2") {
           gcapi.gcFuncs.MakeButton.Zoom({
               idmap: "mapAtlas",
               top: 20,
               left: 20,
           });
       }

       showAtlasPoints($searchInput);
   }

   function initAtlas() {
       gcapi.MapContainer = "mapAtlas";
       gcapi.Zoom = 1;
       gcapi.Center.x = MAP_CENTER[0];
       gcapi.Center.y = MAP_CENTER[1];
       gcapi.OnMapLoad = function () {
           loaded();
       };
   }

   var showAtlasPoints = function (
       $queryInput,
       $countySelect,
       $districtSelect,
       $funcTypeInputs
   ) {
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
           $funcTypeInputs
               .filter(":checked")
               .not(":disabled")
               .each(function () {
                   types.push($(this).attr("id").replace("type-", ""));
               });

           requestData.func_type = types;
       }

       if ($timelineInput) {
           requestData.finish_year = $timelineInput.val();
       }
       $.ajax({
           url: "/api/construction",
           type: "get",
           dataType: "json",
           data: requestData,
           success: function (data) {
               var l = data.length;
               $("#search__more_results")
                   .attr("data-count", l)
                   .removeClass("hidden");
               var elems = [];
               for (; l--; ) {
                   var status;
                   if ($.inArray(data[l].func, knownTypes) == -1) {
                       status = "default";
                   } else {
                       status = data[l].func;
                   }
                   elems.push({
                       //idlayer: 'constructionObjects',
                       idpoint: data[l].id,
                       x: $.parseJSON(data[l].coords)[0],
                       y: $.parseJSON(data[l].coords)[1],
                       icon: {
                           url:
                               "/images/icons/atlas-map/map_marker__" +
                               data[l].status +
                               "__" +
                               status +
                               ".png",
                           width: 30,
                           height: 50,
                           x_offset: -15,
                           y_offset: -49,
                       },
                       attr: {
                           fontsize: 14,
                           fontname: "Arial",
                           fontcolor: "#AA0000",
                           fontbold: 1,
                           fontopacity: 0.5,
                           pic_x_offset: -15,
                           pic_y_offset: -49,
                           innerhtml: data[l].address,
                           // Функциональное назначение
                           functional: data[l].functional,
                           // Источник финансирования
                           finance: data[l].finance,
                           // Застройщик
                           //developer: data[l].developer,
                           title:
                               '<a href="' +
                               data[l].url +
                               '">' +
                               data[l].name +
                               "</a>",
                       },
                   });
               }

               gcapi.RemoveLayer({ idlayer: "constructionObjects" });

               gcapi.GraphicsGroup({
                   idlayer: "constructionObjects",
                   mode: 1,
                   data: elems,
               });

               gcapi.AddLayerClickFunction({
                   idlayer: "constructionObjects",
                   click_fnc: function (a) {
                       var content = "",
                           tableRow =
                               '<tr><td style="text-align: left; vertical-align: top; width: 50%;">%title%</td>' +
                               '<td style="text-align: left; vertical-align: top; width: 50%; color: black;">%value%</td></tr>';

                       if (a.attr.innerhtml !== undefined) {
                           content +=
                               '<span style="color: black;">' +
                               a.attr.innerhtml +
                               "</span>";
                       }

                       content += '<table style="width: 100%;">';

                       if (a.attr.functional !== undefined) {
                           content += tableRow
                               .replace("%title%", "Функциональное назначение:")
                               .replace("%value%", a.attr.functional);
                       }
                       if (a.attr.functional !== undefined) {
                           content += tableRow
                               .replace("%title%", "Источник финансирования:")
                               .replace("%value%", a.attr.finance);
                       }
                       // if (a.attr.developer !== undefined) {
                       //     content += tableRow
                       //         .replace('%title%', 'Застройщик:')
                       //         .replace('%value%', a.attr.developer);
                       // }

                       content += "</table>";

                       gcapi.InfoWindowShow({
                           crds: {
                               x: a.geometry.x,
                               y: a.geometry.y,
                           },
                           title: a.attr.title,
                           content: content,
                           width: 400,
                           height: "auto",
                           InfoWindowClass: "myInfoWindow",
                           InfoWindowContentClass: "myInfoWindowContent",
                           InfoWindowTitleClass: "myInfoWindowTitle",
                           InfoWindowCloseClass: "myInfoWindowClose",
                       });
                   },
               });
               gcapi.showTitle({
                   layerid: "constructionObjects",
                   interval: 500,
                   backgroundColor: "FFFFFF",
                   color: "AAAAAA",
                   borderStyle: "dotted",
               });
           },
       });
       $.ajax({
           url: $("#data-map").data("source"),
           data: requestData,
           dataType: "html",
           type: "get",
           success: function (data) {
               var target = "#objects-block-wrapper",
                   newHTML = $(data).filter(target).html();

               $(target).empty().append(newHTML);
               $(".loadmore-btn").loadMore();
           },
       });
   };

   /* MAPS INITIALIZATION */

   if ($map.length) {
       ymaps.ready(init);

       function init() {
           myMap = new ymaps.Map(
               "map",
               {
                   center: MAP_CENTER,
                   zoom: 11,
                   controls: ["zoomControl"],
               },
               {
                   maxAnimationZoomDifference: 23,
               }
           );

           objectManager = new ymaps.ObjectManager({
               clusterize: true,
               clusterHasBalloon: false,
               geoObjectDisableClickZoom: false,
           });

           objectManager.clusters.options.set(
               "preset",
               "islands#invertedDarkGreenClusterIcons"
           );

           myMap.geoObjects.add(objectManager);
           myMap.behaviors.disable("scrollZoom");
           showMapObjects(
               $searchInput,
               $countySelect,
               $districtSelect,
               $funcTypeCheckboxes,
               $timelineInput
           );

           document.addEventListener("keydown", (evt) => {
               if (evt.key === "Shift") {
                   myMap.behaviors.enable("scrollZoom");
               }
           });

           document.addEventListener("keyup", () => {
               myMap.behaviors.disable("scrollZoom");
           });
       }

       $districtSelect
           .add($searchInput)
           .add($funcTypeCheckboxes)
           .on("change", function (e) {
               e.preventDefault();

               if (e.which == 13) {
                   toggleSubmenu({ state: false });
               }

               if (
                   request1Def.state() == "resolved" &&
                   request2Def.state() == "resolved"
               ) {
                   request1Def = $.Deferred();
                   request2Def = $.Deferred();
                   if (
                       $submenuBtn.is(".active") ||
                       $mapContainer.data("preset") == "renovation"
                   ) {
                       showMapObjects(
                           $searchInput,
                           $countySelect,
                           $districtSelect,
                           $funcTypeCheckboxes,
                           $timelineInput
                       );
                   } else {
                       showMapObjects($searchInput);
                   }
               } else {
                   lastSearchInput = $searchInput.val();
               }
               lastSearchInput = $searchInput.val();
           });

       $searchInput.on(
           "keyup",
           debounce(function (e) {
               e.preventDefault();

               if (e.which == 13) {
                   toggleSubmenu({ state: false });
               }

               if (
                   request1Def.state() == "resolved" &&
                   request2Def.state() == "resolved"
               ) {
                   request1Def = $.Deferred();
                   request2Def = $.Deferred();
                   if (
                       $submenuBtn.is(".active") ||
                       $mapContainer.data("preset") == "renovation"
                   ) {
                       showMapObjects(
                           $searchInput,
                           $countySelect,
                           $districtSelect,
                           $funcTypeCheckboxes,
                           $timelineInput
                       );
                   } else {
                       showMapObjects($searchInput);
                   }
               } else {
                   lastSearchInput = $searchInput.val();
               }
               lastSearchInput = $searchInput.val();
           }, 1000)
       );

       var $timeline = $("#timeline"),
           $timelineInput = $("#timeline-input");

       $timeline.slider({
           range: true,
           min: $timeline.data("range-min"),
           max: $timeline.data("range-max"),
           values: [$timeline.data("value-from"), $timeline.data("value-to")],
           step: 1,
           create: function (event, ui) {
               $(event.target)
                   .find(".ui-slider-handle:first")
                   .attr(
                       "data-content",
                       $(event.target).attr("data-value-from")
                   );
               $(event.target)
                   .find(".ui-slider-handle:last")
                   .attr("data-content", $(event.target).attr("data-value-to"));
           },
           slide: function (event, ui) {
               $(ui.handle).attr("data-content", ui.value);
           },
           stop: function (event, ui) {
               $timelineInput.val(ui.values.join(",")).trigger("change");
           },
       });

       $timelineInput.on("change", function (e) {
           e.preventDefault();
           showMapObjects(
               $searchInput,
               $countySelect,
               $districtSelect,
               $funcTypeCheckboxes,
               $timelineInput
           );
       });
   }

   function loadMapWidgets() {
       ymaps.ready(function () {
           $.each($(".map-widget:not(.loaded)"), function (key, item) {
               item = $(item);
               $(item).addClass("loaded");
               var point = item.data("point").split(",");
               var map = new ymaps.Map(item[0], {
                   center: point,
                   zoom: 16,
                   controls: [],
               });

               if (item[0].hasAttribute("data-polygon")) {
                   const dataGeometry = item.data("polygon");
                   const props = {};
                   const options = {
                       fillColor: "rgba(255,255,255,0.5)",
                       fillMethod: "tile",
                       strokeColor: "#5b5b4f",
                       strokeWidth: 2,
                       visible: true,
                       opacity: 0.5,
                       draggable: false,
                   };

                   map.geoObjects.add(
                       new ymaps.Polygon(dataGeometry, props, options)
                   );
                   map.setBounds(map.geoObjects.getBounds(), {
                       checkZoomRange: true,
                       preciseZoom: true,
                       zoomMargin: 50,
                   }).then(function () {
                       if (map.getZoom() > 15) map.setZoom(15);
                   });
               }
               // if expandable
               if (item[0].hasAttribute("data-expandable")) {
                   // add point
                   if (item[0].hasAttribute("data-point")) {
                       var pointMark = new ymaps.Placemark(
                           point,
                           {},
                           {
                               iconLayout: "default#image",
                               iconImageHref: "/images/icons/red-marker.svg",
                               iconImageSize: [32, 32],
                               iconImageOffset: [-16, -30],
                           }
                       );
                       map.geoObjects.add(pointMark);
                   }
                   // add some controls
                   map.controls.add("zoomControl");
                   map.controls.add("fullscreenControl");
               } else {
                   map.behaviors.disable([
                       "drag",
                       "rightMouseButtonMagnifier",
                       // "scrollZoom",
                   ]);
               }
               // PLACEMARK
               var parent = item.closest(".geo-point");
               if (parent.hasClass("geo-construct")) {
                   var iconClass = item.attr("data-icon");
                   map.behaviors.enable(["scrollZoom", "drag"]);
                   var myIconContentLayout =
                       ymaps.templateLayoutFactory.createClass(
                           `<div class="conctruction-geo-icon"><div class="${iconClass}"></div></div>`
                       );
                   var newPointMark = new ymaps.Placemark(
                       point,
                       {},
                       {
                           iconLayout: "default#imageWithContent",
                           iconImageHref:
                               "/images/icons/map_marker__operation.svg",
                           iconContentLayout: myIconContentLayout,
                           iconImageSize: [38, 47],
                           iconImageOffset: [-19, -47],
                       }
                   );
                   map.geoObjects.add(newPointMark);
               }
           });
       });
   }

   loadMapWidgets();
   $(document).on("data-map:contentAdded", function (event) {
       loadMapWidgets();
   });
   $(document).on("loadmore:contentAdded", function (event) {
       loadMapWidgets();
   });

   if ($mapAtlas.length) {
       gcapi.ready = function () {
           initAtlas();
       };

       $countySelect.on("change", function () {
           var currentCounty = $countySelect.find(":selected").val(),
               $allDistricts = $districtSelect
                   .find("option")
                   .addClass("hidden")
                   .prop("selected", false),
               $countyDistricts = $allDistricts
                   .filter('[data-county="' + currentCounty + '"]')
                   .removeClass("hidden"),
               selectBox;

           if (currentCounty != "") {
               $districtSelect.prop("disabled", false);
           } else {
               $districtSelect.prop("disabled", true);
           }

           $districtSelect.val($countyDistricts.eq(0).val()).trigger("change");

           selectBox =
               $districtSelect.data("selectBox-selectBoxIt") ||
               $districtSelect.data("selectBox");

           if (selectBox) {
               selectBox.refresh();
           }
       });

       var keyupDelay = false;

       $districtSelect
           .add($searchInput)
           .add($funcTypeCheckboxes)
           .on("change keyup", function (e) {
               e.preventDefault();
               if (e.type == "keyup") {
                   if (!!keyupDelay) {
                       return;
                   } else {
                       keyupDelay = setTimeout(function () {
                           clearTimeout(keyupDelay);
                           keyupDelay = false;
                       }, 500);
                   }
               }

               if ($submenuBtn.is(".active")) {
                   showAtlasPoints(
                       $searchInput,
                       $countySelect,
                       $districtSelect,
                       $funcTypeCheckboxes
                   );
               } else {
                   showAtlasPoints($searchInput);
               }
           });

       var $timeline = $("#timeline"),
           $timelineInput = $("#timeline-input");

       $timeline.slider({
           range: true,
           min: $timeline.data("range-min"),
           max: $timeline.data("range-max"),
           values: [$timeline.data("value-from"), $timeline.data("value-to")],
           step: 1,
           create: function (event, ui) {
               $(event.target)
                   .find(".ui-slider-handle:first")
                   .attr(
                       "data-content",
                       $(event.target).attr("data-value-from")
                   );
               $(event.target)
                   .find(".ui-slider-handle:last")
                   .attr("data-content", $(event.target).attr("data-value-to"));
           },
           slide: function (event, ui) {
               $(ui.handle).attr("data-content", ui.value);
           },
           stop: function (event, ui) {
               $timelineInput.val(ui.values.join(",")).trigger("change");
           },
       });

       $timelineInput.on("change", function (e) {
           e.preventDefault();

           showAtlasPoints(
               $searchInput,
               $countySelect,
               $districtSelect,
               $funcTypeCheckboxes,
               $timelineInput
           );
       });
   }

   if ($near.length) {
       $funcTypeCheckboxes.on("change", function (e) {
           e.preventDefault();
           if (e.type == "keyup") {
               if (!!keyupDelay) {
                   return;
               } else {
                   keyupDelay = setTimeout(function () {
                       clearTimeout(keyupDelay);
                       keyupDelay = false;
                   }, 500);
               }
           }

           var requestData = {},
               types = [];

           $funcTypeCheckboxes
               .filter(":checked")
               .not(":disabled")
               .each(function () {
                   types.push($(this).attr("id").replace("type-", ""));
               });

           requestData.func_type = types;

           $("#near_objects_container").load(
               $("#data-map").data("source"),
               requestData,
               function (result) {
                   $("#constructions-near_total").html($(result).data("total"));
                   $(document).trigger("data-map:contentAdded");
                   $(this).find(".loadmore-btn").loadMore();
               }
           );
       });
   }

   $tagsBtn.on("click", function (e) {
       e.preventDefault();
       var tagHeight = $tags.outerHeight();

       if ($tagsBtn.hasClass("active")) {
           $tags.css("display", "none");
           $submenu.css({ height: 0, overflow: "hidden" }).attr("tabindex", -1);
           $tagsBtn.removeClass("active");
       } else {
           $submenuChildren
               .not(".documents-page__document-tags")
               .css("display", "none");
           $tags.css("display", "block");
           $submenu
               .css({ height: tagHeight, visibility: "visible" })
               .removeAttr("tabindex");
           $tagsBtn.addClass("active");
       }
       $submenuBtn.removeClass("active");
   });

   $submitBtn.on("click", function () {
       toggleSubmenu({ state: false });
   });

   $subMenuClose.on("click", function () {
       $tags.css("display", "none");
       $submenu.css({ height: 0, overflow: "hidden" }).attr("tabindex", -1);
       $tagsBtn.removeClass("active");
       $submenuBtn.removeClass("active");
   });

   $submenuBtn.on("click", function (e) {
       e.preventDefault();
       toggleSubmenu();
   });

   $submenu.on("transitionend", function () {
       var height = $submenu.outerHeight();

       if (height) {
           $submenu.css({ overflow: "visible" });
       } else {
           $submenu.css({ visibility: "hidden" });
       }
   });

   $countySelect.on("change", function () {
       var currentCounty = $countySelect.find(":selected").val(),
           $allDistricts = $districtSelect
               .find("option")
               .addClass("hidden")
               .prop("selected", false),
           $countyDistricts = $allDistricts
               .filter('[data-county="' + currentCounty + '"]')
               .removeClass("hidden"),
           selectBox;

       if (currentCounty != "") {
           $districtSelect.prop("disabled", false);
       } else {
           $districtSelect.prop("disabled", true);
       }

       $districtSelect.val($countyDistricts.eq(0).val()).trigger("change");

       selectBox =
           $districtSelect.data("selectBox-selectBoxIt") ||
           $districtSelect.data("selectBox");

       if (selectBox) {
           selectBox.refresh();
       }
   });

   var toggleSubmenu = function (params) {
       var params = params || {};
       var allHeight = 0;
       for (var i = 0; i < submenuChildrenLength; i++) {
           if ($submenuChildren.eq(i).hasClass("active")) {
               allHeight += $submenuChildren.eq(i).outerHeight();
           }
       }
       $submenuChildren.filter(".active").css("display", "block");
       if ($submenuBtn.hasClass("active") || params.state == false) {
           $(".search-form__wrap").addClass("search-compact");
           $submenuBtn.removeClass("active");
           $submenu.css({ height: 0, overflow: "hidden" }).attr("tabindex", -1);
       } else {
           $(".search-form__wrap").removeClass("search-compact");
           $submenuBtn.addClass("active");
           $submenu
               .css({ height: allHeight, visibility: "visible" })
               .removeAttr("tabindex");
           //$submenu.css({'height': submenuSelect + submenuCheck, 'visibility': 'visible'}).removeAttr('tabindex');
       }

       $tagsBtn.removeClass("active");
       $tags.css("display", "none");
   };

   var manuallySelectDistrict = function (districtId) {
       var county = $districtSelect
           .find('option[value="' + districtId + '"]')
           .data("county");

       $countySelect.val(county).trigger("change");
       $districtSelect.val(districtId).trigger("change");
   };

   var $selectMyDistrictLink = $("#select-my-district-link");
   $selectMyDistrictLink.on("click", function (e) {
       e.preventDefault();
       e.stopPropagation();

       var districtId = $(e.target).data("adm-unit-id");

       manuallySelectDistrict(districtId);
   });

   var $detectMyDistrictLink = $("#detect-my-district-link");
   $detectMyDistrictLink.on("click", function (e) {
       e.preventDefault();
       e.stopPropagation();

       var onAdministrativeUnitDetected = function (data) {
           var districtId = data.unit.id;

           manuallySelectDistrict(districtId);
       };

       getAdministrativeUnit(onAdministrativeUnitDetected);
   });

   var mapPopup = $(".js-map-popup");
   var mapPopupCloseBtn = $(".js-map-popup-close");

   var cookie = getCookie();
   if (!cookie.mapPopup) mapPopup.addClass("active");

   mapPopupCloseBtn.on("click", function (evt) {
       evt.preventDefault();
       document.cookie =
           'mapPopup="true"; max-age=604800; expires=604800; path=/';
       mapPopup.removeClass("active");
   });
});
