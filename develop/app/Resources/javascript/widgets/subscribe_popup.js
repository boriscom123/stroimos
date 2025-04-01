$(function () {
    if (!window.Selectize.prototype.positionDropdownOriginal) {
        window.Selectize.prototype.positionDropdownOriginal =
            window.Selectize.prototype.positionDropdown;
        window.Selectize.prototype.positionDropdown = function () {
            if (this.settings.dropdownDirection === "up") {
                let $control = this.$control;
                this.$dropdown.css({
                    width: $control.outerWidth(),
                    bottom: $control.outerHeight(),
                    left: $control.position().left,
                });
                this.$dropdown.addClass(
                    "direction-" + this.settings.dropdownDirection
                );
                this.$control.addClass(
                    "direction-" + this.settings.dropdownDirection
                );
                this.$wrapper.addClass(
                    "direction-" + this.settings.dropdownDirection
                );
            } else {
                window.Selectize.prototype.positionDropdownOriginal.apply(
                    this,
                    arguments
                );
            }
        };
    }

    // if ($.cookie("subscribePopupSubscribed") == undefined) {
    //     var $wrapper = $(".subscribe-popup__wrapper");
    //     var $popup = $(".subscribe-popup__popup");
    //     var $form = $(".subscribe-popup__content-form");
    //     var $form_email = $(".subscribe-popup__content-inputfield");
    //     var $form_error = $(".subscribe-popup__content-error");
    //     var $form_button = $(".subscribe-popup__content-btn");
    //     var $form_private = $("#subscribe_popup_private_data");
    //     var $form_aud_tmp = $(
    //         ".subscribe-popup__wrapper .subscribe-popup__content-select select"
    //     );
    //     var $form_aud = $(
    //         ".subscribe-popup__wrapper .subscribe-popup__content-select-data select"
    //     );
    //     var $content_form = $(".subscribe-popup__content_form");
    //     var $content_success = $(".subscribe-popup__content_success");
    //     var $content_success_title = $(
    //         ".subscribe-popup__content_success .subscribe-popup__content-title"
    //     );
    //     var $content_success_subtitle = $(
    //         ".subscribe-popup__content_success .subscribe-popup__content-subtitle"
    //     );
    //     var $close = $(".subscribe-popup__close");
    //
    //     var aud_data = {};
    //     $form_aud.find("optgroup").each(function () {
    //         var aud_au = $(this)[0].label;
    //         aud_data[aud_au] = {};
    //         $(this)
    //             .find("option")
    //             .each(function () {
    //                 aud_data[aud_au][$(this)[0].label] = $(this)[0].value;
    //             });
    //     });
    //
    //     var aud_select2_data = [];
    //     Object.keys(aud_data).forEach((au_key) => {
    //         aud_select2_data.push({
    //             id: "au_" + au_key,
    //             text: au_key,
    //             level: 1,
    //         });
    //         Object.keys(aud_data[au_key]).forEach((d_key) => {
    //             aud_select2_data.push({
    //                 id: aud_data[au_key][d_key],
    //                 text: d_key,
    //                 level: 2,
    //             });
    //         });
    //     });
    //
    //     $form_aud_tmp.selectize({
    //         plugins: ["remove_button"],
    //         placeholder: "Выберите округ или район",
    //         options: aud_select2_data,
    //         labelField: "text",
    //         valueField: "id",
    //         highlight: false,
    //         hideSelected: false,
    //         closeAfterSelect: true,
    //         maxItems: 20,
    //         dropdownDirection: "up",
    //         onInitialize: function () {
    //             var t = this;
    //             this.$control.on("mousedown", function () {
    //                 t.isOpen ? t.close() : t.open();
    //             });
    //         },
    //         onDropdownClose: function ($dropdown) {
    //             $($dropdown)
    //                 .find(".selected")
    //                 .not(".active")
    //                 .removeClass("selected");
    //         },
    //         render: {
    //             option: function (item, escape) {
    //                 return (
    //                     '<div class="option"><span style="padding-left:' +
    //                     10 * item.level +
    //                     'px;">' +
    //                     item.text +
    //                     "</span></div>"
    //                 );
    //             },
    //         },
    //     });
    //
    //     if (previousTimeShownCheck()) {
    //         if ($.cookie("subscribePopupVisitStartedAt") == undefined)
    //             $.cookie("subscribePopupVisitStartedAt", moment(), {
    //                 path: "/",
    //                 expires: 365,
    //             });
    //         var diff = moment().diff(
    //             moment($.cookie("subscribePopupVisitStartedAt")),
    //             "seconds"
    //         );
    //         var timeout =
    //             diff >= 15 * 60
    //                 ? 60
    //                 : diff < 15 * 60 && diff > 60
    //                 ? 0
    //                 : 60 - diff;
    //         setTimeout(function () {
    //             if ($.cookie("subscribePopupEmail")) {
    //                 $.ajax($form.attr("action"), {
    //                     data: $.param({
    //                         "form[email]": $.cookie("subscribePopupEmail"),
    //                     }),
    //                     type: "post",
    //                     dataType: "json",
    //                     success: function (data) {
    //                         if (!data.errors) {
    //                             if (data.confirmed) {
    //                                 $.cookie("subscribePopupSubscribed", true, {
    //                                     path: "/",
    //                                     expires: 365,
    //                                 });
    //                             } else {
    //                                 showPopup();
    //                             }
    //                         }
    //                     },
    //                 });
    //             } else {
    //                 showPopup();
    //             }
    //         }, timeout * 1000);
    //     }
    // }

    // function showPopup() {
    //     if (previousTimeShownCheck()) {
    //         $.cookie("subscribePopupPreviousTimeShownAt", moment(), {
    //             path: "/",
    //             expires: 365,
    //         });
    //         $.removeCookie("subscribePopupVisitStartedAt", {
    //             path: "/",
    //             expires: 365,
    //         });
    //
    //         // if ($.cookie('subscribePopupEmail') && $.cookie('subscribePopupSubscribed') == undefined) {
    //         // If user returns and still unsubscribed?
    //         // }
    //
    //         if (document.body.clientWidth > 1000) $wrapper.fadeIn(300);
    //
    //         $popup.on("click tap", function (e) {
    //             e.stopPropagation();
    //         });
    //         $wrapper.on("click tap", function () {
    //             closePopup();
    //         });
    //         $close.on("click tap", function (e) {
    //             e.preventDefault();
    //             closePopup();
    //         });
    //         $(document).on("keyup", closePopupIfEsc);
    //
    //         $form_email.on("keyup change", function () {
    //             closePopupError();
    //         });
    //
    //         $form_private.on("change", function () {
    //             $form_button.prop("disabled", !$(this).prop("checked"));
    //         });
    //
    //         $form.on("submit", function (e) {
    //             e.preventDefault();
    //
    //             if (checkPopupEmail($form_email.val())) {
    //                 if ($form_aud_tmp.val()) {
    //                     var aud_val = [];
    //                     $form_aud_tmp.val().forEach((v) => {
    //                         if (v.startsWith("au_")) {
    //                             Object.keys(aud_data[v.substr(3)]).forEach(
    //                                 (d_key) => {
    //                                     aud_val.push(
    //                                         aud_data[v.substr(3)][d_key]
    //                                     );
    //                                 }
    //                             );
    //                         } else {
    //                             aud_val.push(v);
    //                         }
    //                     });
    //                     aud_val = aud_val.filter(
    //                         (v, i) => aud_val.indexOf(v) === i
    //                     );
    //                     $form_aud.val(aud_val).change();
    //                 } else {
    //                     $form_aud.val("").change();
    //                 }
    //
    //                 $.ajax($form.attr("action"), {
    //                     data: $form.serialize(),
    //                     type: "post",
    //                     dataType: "json",
    //                     success: function (data) {
    //                         if (!data.errors) {
    //                             closePopupError();
    //                             if (
    //                                 data.confirmed &&
    //                                 data.confirmed == "true"
    //                             ) {
    //                                 showPopupSuccess(
    //                                     "Спасибо<br/> за подписку!",
    //                                     "Указанный адрес электронной почты уже есть списке рассылки."
    //                                 );
    //                             } else if (
    //                                 data.message ==
    //                                 "На указанный электронный адрес ранее было отправлено письмо со ссылкой на страницу управления рассылкой. Пожалуйста, перейдите по этой ссылке и подтвердите получение рассылки"
    //                             ) {
    //                                 showPopupSuccess(
    //                                     "Подтвердите<br/> получение<br/> рассылки",
    //                                     "На указанный электронный адрес ранее было отправлено письмо со ссылкой на страницу управления рассылкой. Пожалуйста, перейдите по этой ссылке и подтвердите получение рассылки."
    //                                 );
    //                             } else {
    //                                 showPopupSuccess(
    //                                     "Спасибо<br/> за подписку!",
    //                                     "На указанный электронный адрес было отправлено<br/> письмо со ссылкой на страницу управления рассылкой"
    //                                 );
    //                             }
    //                             setTimeout(function () {
    //                                 closePopup();
    //                             }, 10000);
    //                             $.cookie(
    //                                 "subscribePopupEmail",
    //                                 $form_email.val(),
    //                                 {
    //                                     path: "/",
    //                                     expires: 365,
    //                                 }
    //                             );
    //                             if (data.confirmed) {
    //                                 $.cookie("subscribePopupSubscribed", true, {
    //                                     path: "/",
    //                                     expires: 365,
    //                                 });
    //                             }
    //                             if (typeof yaCounter20919760 !== "undefined") {
    //                                 yaCounter20919760.reachGoal(
    //                                     "subscribe_popup_send"
    //                                 );
    //                             }
    //                         } else {
    //                             showPopupError(
    //                                 "Что-то пошло не так. Попробуйте ещё раз."
    //                             );
    //                         }
    //                     },
    //                     error: function () {
    //                         showPopupError(
    //                             "Что-то пошло не так. Попробуйте ещё раз."
    //                         );
    //                     },
    //                 });
    //             } else {
    //                 showPopupError(
    //                     "Введён некорректный адрес электронной почты"
    //                 );
    //             }
    //         });
    //     }
    // }

    function closePopup() {
        $wrapper.fadeOut(300);
        $close.unbind();
        $wrapper.unbind();
        $popup.unbind();
        $form_email.unbind();
        $form_private.unbind();
        $form.unbind();
        $(document).unbind("keyup", closePopupIfEsc);
    }

    function closePopupIfEsc(e) {
        if (e.keyCode == 27 && $wrapper.find("input:focus").length == 0) {
            closePopup();
        }
    }

    function showPopupError($error_text) {
        с.html("<span>" + $error_text + "</span>");
        $form_error.addClass("active");
    }

    function showPopupSuccess(title, subtitle) {
        $content_form.hide();
        $content_success.css("display", "flex");
        $content_success_title.html(title);
        $content_success_subtitle.html(subtitle);
    }

    function closePopupError() {
        if ($form_error.hasClass("active")) {
            $form_error.removeClass("active");
            $form_error.text("");
        }
    }

    // function previousTimeShownCheck() {
    //     return (
    //         $.cookie("subscribePopupPreviousTimeShownAt") == undefined ||
    //         moment().diff(
    //             moment($.cookie("subscribePopupPreviousTimeShownAt")),
    //             "days"
    //         ) > 30
    //     );
    // }

    function checkPopupEmail(email) {
        var regex =
            /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
});

// $(function () {
//     var tgpopup = $(".js-subscribe-telegram");
//     var activeClass = "subscribe-telegram_active";
//     var btns = $(".js-tgl-popup");
//     var link = $(".js-link");
//     var COOKIE_KEY24 = "TG_COOKIE_24";
//     var COOKIE_KEY365 = "TG_COOKIE_365";
//
//     function getCookie(name) {
//         var matches = document.cookie.match(
//             new RegExp(
//                 "(?:^|; )" +
//                     name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
//                     "=([^;]*)"
//             )
//         );
//         return matches ? decodeURIComponent(matches[1]) : undefined;
//     }
//
//     function setCookie(name, value, options) {
//         // eslint-disable-next-line no-param-reassign
//         options = options || {};
//         var expires = options.expires;
//         // eslint-disable-next-line eqeqeq
//         if (typeof expires == "number" && expires) {
//             var d = new Date();
//             d.setTime(d.getTime() + expires * 1000);
//             // eslint-disable-next-line no-multi-assign
//             expires = options.expires = d;
//         }
//         if (expires && expires.toUTCString) {
//             options.expires = expires.toUTCString();
//         }
//         // eslint-disable-next-line no-param-reassign
//         value = encodeURIComponent(value);
//         var updatedCookie = name + "=" + value;
//         // eslint-disable-next-line no-restricted-syntax, guard-for-in
//         for (var propName in options) {
//             updatedCookie += "; " + propName;
//             var propValue = options[propName];
//             if (propValue !== true) {
//                 updatedCookie += "=" + propValue;
//             }
//         }
//         document.cookie = updatedCookie;
//     }
//     var cookieSubscribed = getCookie(COOKIE_KEY365);
//
//     if (cookieSubscribed) {
//         return;
//     }
//     // console.log('no subs');
//
//     var cookie24 = getCookie(COOKIE_KEY24);
//
//     if (!cookie24) {
//         setTimeout(function () {
//             if (document.body.clientWidth > 1000) tgpopup.addClass(activeClass);
//         }, 45000);
//     }
//
//     btns.on("click", function (evt) {
//         if (evt.target === evt.currentTarget) {
//             // console.log('24');
//             evt.preventDefault();
//             evt.stopPropagation();
//             tgpopup.removeClass(activeClass);
//             var expDate = new Date();
//             expDate.setTime(expDate.getTime() + 24 * 60 * 60 * 1000);
//             setCookie(COOKIE_KEY24, COOKIE_KEY24, {
//                 expires: expDate,
//                 path: "/",
//             });
//         }
//     });
//
//     link.on("click", function () {
//         // console.log('365');
//         tgpopup.removeClass(activeClass);
//         var expDate = new Date();
//         expDate.setTime(expDate.getTime() + 365 * 5 * 24 * 60 * 60 * 1000);
//         setCookie(COOKIE_KEY365, COOKIE_KEY365, {
//             expires: expDate,
//             path: "/",
//         });
//     });
// });
