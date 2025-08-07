
//Input mask money
$(document).on('focus', '.money', function () {
    $(this).mask("#,##0", {
        reverse: true
    });
});
$(document).on('blur', '.money', function () {
    $(this).unmask();
})

function number_format(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

/**
 * Reset form
 */
function resetForm(frm) {
    frm.trigger("reset")
        .find(".modal")
        .modal("hide")
        .end()
        .find("[type=submit]")
        .prop("disabled", false)
         .html(frm.find("[type=submit]").attr('data-text') ?? 'OK').addClass("px-4")
        .find("input")
        .add("select")
        .add("textarea")
        .removeClass("is-invalid")
        .prop("disabled", false)
        .next()
        .remove("span")
        .end()
        .find("[type=hidden]")
        .val("")
        .end()
        .find("[type=checkbox]")
        .prop("checked", false);
}

/**
 * Xử lý toastify cho toàn trang
 */
function pushToastify(msg, stt) {
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "center",
        backgroundColor: `var(--bs-${stt})`,
    }).showToast();
}
/**
 * Submit form
 */

function submitForm(frm) {
    var btn = frm.find("[type=submit]:last");
    frm.find("input")
        .add("select")
        .add("textarea")
        .removeClass("is-invalid")
        .prop("disabled", false)
        .next()
        .remove("span.response");
    let str = `<span class="${btn.text() == "" ? "" : "text-white"
        }"><i class="bi bi-arrow-repeat"></i></i>${btn.text() == "" ? "" : " Try again"
        }</span>`;
    btn.prop("disabled", true).html(
        '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>'
    );
    const processing = setTimeout(() => {
        Swal.fire(config.sweetAlert.delay);
    }, 5000);
    return $.ajax({
        data: new FormData(frm[0]),
        url: frm.attr("action"),
        method: frm.attr("method"),
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name = "csrf-token"]').attr("content"),
        },
        success: function success(response) {
            clearTimeout(processing);
            Swal.close();
            if (response.status == "success") {
                pushToastify(response.msg, response.status);
                resetForm(frm);
            } else if (response.status == "danger" || response.status == "error") {
                Swal.fire("FAILED!", response.msg, response.status);
                btn.prop("disabled", false).html(str);
            }
        },
        error: function error(errors) {
            clearTimeout(processing);
            Swal.close();
            btn.prop("disabled", false).html(str);
            if (errors.status == 419 || errors.status == 401) {
                window.location.href = config.routes.login;
            } else if (errors.status == 422) {
                frm.find(".is-invalid")
                    .removeClass("is-invalid")
                    .next()
                    .remove("span");
                $.each(errors.responseJSON.errors, function (i, error) {
                    var el = frm.find('[name="' + i + '"]');
                    if (
                        el.length && !el.hasClass("d-none") && el.attr("type") != "hidden" && el.attr("type") != "radio" && !el.prop("hidden")
                    ) {
                        el.addClass("is-invalid")
                            .next()
                            .remove("span.response");
                        el.after(
                            $(
                                `<span class="text-danger response">${error[0]}</span>`
                            )
                        );
                    } else {
                        Swal.fire("Alert!", error[0], "info");
                    }
                });
            } else {
                console.log(errors);

                pushToastify("Unknown error. Please contact the software developer for assistance.", 'danger')
            }
        },
    });
}

function debounce(func, delay) {
    let timeoutId;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function () {
            func.apply(context, args);
        }, delay);
    };
}

function initGoongMap({
    containerId,
    defaultLat = 10.0451618,
    defaultLng = 105.7468535,
    onLocationSelected = () => {},
    addressInputSelector = null,
    addressPreviewSelector = null
}) {
    goongjs.accessToken = GOONG_MAP_API_KEY;

    const map = new goongjs.Map({
        container: containerId,
        style: 'https://tiles.goong.io/assets/goong_map_web.json',
        center: [defaultLng, defaultLat],
        zoom: 14,
    });

    let marker = new goongjs.Marker({ draggable: true })
        .setLngLat([defaultLng, defaultLat])
        .addTo(map);

    function reverseGeocode(lat, lng, callback) {
        $.ajax({
            url: 'https://rsapi.goong.io/Geocode',
            method: 'GET',
            data: {
                latlng: `${lat},${lng}`,
                api_key: GOONG_REST_API_KEY
            },
            success: function (res) {
                const address = res.results[0]?.formatted_address || '';
                callback(address);
            }
        });
    }

    function geocodeAddress(address, callback) {
        $.ajax({
            url: 'https://rsapi.goong.io/Geocode',
            method: 'GET',
            data: {
                address: address,
                api_key: GOONG_REST_API_KEY
            },
            success: function (res) {
                if (res.results.length > 0) {
                    const { lat, lng } = res.results[0].geometry.location;
                    const formatted_address = res.results[0].formatted_address;
                    callback({ lat, lng, address: formatted_address });
                }
            }
        });
    }

    function updateAddressInput(lat, lng, address) {
        if (addressInputSelector) {
            const input = document.querySelector(addressInputSelector);
            const jsonValue = JSON.stringify({ address, lat, lng });
            input.value = jsonValue;
        }
    }

    function updatePreviewAddressInput(address) {
        if (addressPreviewSelector) {
            const input = document.querySelector(addressPreviewSelector);
            input.value = address;
        }
    }

    function updateMarkerAndCenter(lat, lng) {
        marker.setLngLat([lng, lat]);
        map.flyTo({ center: [lng, lat], zoom: 16 });
    }

    map.on('click', function (e) {
        const { lat, lng } = e.lngLat;
        updateMarkerAndCenter(lat, lng);
        reverseGeocode(lat, lng, function (address) {
            onLocationSelected({ lat, lng, address });
            updateAddressInput(lat, lng, address);
            updatePreviewAddressInput(address);
        });
    });

    marker.on('dragend', function () {
        const lngLat = marker.getLngLat();
        reverseGeocode(lngLat.lat, lngLat.lng, function (address) {
            onLocationSelected({ lat: lngLat.lat, lng: lngLat.lng, address });
            updateAddressInput(lngLat.lat, lngLat.lng, address);
            updatePreviewAddressInput(address);
        });
    });

    if (addressPreviewSelector) {
        const $input = $(addressPreviewSelector);
        const $suggestions = $('<ul id="suggestions" class="autocomplete-list w-auto"></ul>');
        $input.after($suggestions);

        const defaultLocation = `${defaultLat},${defaultLng}`;
        const radius = 20000;

        // DEBOUNCED AUTOCOMPLETE
        const handleAutocomplete = debounce(function () {
            const inputValue = $input.val();
            if (inputValue.length < 2) {
                $suggestions.empty();
                return;
            }

            $.ajax({
                url: 'https://rsapi.goong.io/place/autocomplete',
                method: 'GET',
                data: {
                    input: inputValue,
                    location: defaultLocation,
                    radius: radius,
                    limit: 10,
                    api_key: GOONG_REST_API_KEY
                },
                success: function (res) {
                    $suggestions.empty();

                    if (res.predictions && res.predictions.length > 0) {
                        res.predictions.forEach(function (place) {
                            const $item = $('<li></li>').text(place.description);
                            $item.on('click', function () {
                                const address = place.description;

                                // Vì autocomplete không trả về lat/lng, phải gọi geocode
                                geocodeAddress(address, function ({ lat, lng, address }) {
                                    console.log('Selected address:', address, lat, lng);

                                    $input.val(address);
                                    $suggestions.empty();
                                    updateMarkerAndCenter(lat, lng);
                                    onLocationSelected({ lat, lng, address });
                                    updateAddressInput(lat, lng, address);
                                    updatePreviewAddressInput(address);
                                });
                            });
                            $suggestions.append($item);
                        });
                    } else {
                        $suggestions.append('<li class="text-muted">Không tìm thấy kết quả</li>');
                    }
                },
                error: function () {
                    $suggestions.html('<li class="text-danger">Lỗi khi gọi API</li>');
                }
            });
        }, 300); // 300ms debounce

        $input.on('input', handleAutocomplete);

        // chọn ngoài thì ẩn
        $(document).on('click', function (e) {
            if (!$(e.target).closest(addressPreviewSelector).length) {
                $suggestions.empty();
            }
        });
    }

    return { map, marker };
}
