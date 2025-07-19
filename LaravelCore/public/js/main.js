
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