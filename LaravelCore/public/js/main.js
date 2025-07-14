
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
        .remove("span");
    btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>');
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
            if (response.status == "success") {
                Toastify({
                    text: response.msg,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "var(--bs-".concat(response.status, ")"),
                }).showToast();
                resetForm(frm);
            } else {
                btn.prop("disabled", false);
            }
        },
        error: function error(errors) {            
            if (btn.hasClass('just-icon')) {
                btn.prop("disabled", false).html('<i class="bi bi-arrow-repeat"></i>');
            } else {
                btn.prop("disabled", false).html('<i class="bi bi-arrow-repeat"></i> Thử lại');
            }
            if (errors.status == 419 || errors.status == 401) {
                window.location.href = config.routes.login;
            } else if (errors.status == 422) {
                frm.find(".is-invalid")
                    .removeClass("is-invalid")
                    .next()
                    .remove("span");
                $.each(errors.responseJSON.errors, function (i, error) {
                    var el = frm.find('[name="' + i + '"]');
                    if (el.length) {
                        el.addClass("is-invalid").next().remove("span");
                        el.after(
                            $(
                                '<span class="text-danger">' +
                                error[0] +
                                "</span>"
                            )
                        );
                    } else {
                        Toastify({
                            text: error[0],
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "var(--bs-info)",
                        }).showToast();
                    }
                });
            } else {
                Toastify({
                    text: errors.statusText ?? "Có lỗi xảy ra! Vui lòng thử lại sau.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "var(--bs-danger)",
                }).showToast();
            }
        },
    });
}