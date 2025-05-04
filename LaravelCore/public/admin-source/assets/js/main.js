function slideToggle(t, e, o) { 0 === t.clientHeight ? j(t, e, o, !0) : j(t, e, o) } function slideUp(t, e, o) { j(t, e, o) } function slideDown(t, e, o) { j(t, e, o, !0) } function j(t, e, o, i) { void 0 === e && (e = 400), void 0 === i && (i = !1), t.style.overflow = "hidden", i && (t.style.display = "block"); var p, l = window.getComputedStyle(t), n = parseFloat(l.getPropertyValue("height")), a = parseFloat(l.getPropertyValue("padding-top")), s = parseFloat(l.getPropertyValue("padding-bottom")), r = parseFloat(l.getPropertyValue("margin-top")), d = parseFloat(l.getPropertyValue("margin-bottom")), g = n / e, y = a / e, m = s / e, u = r / e, h = d / e; window.requestAnimationFrame(function l(x) { void 0 === p && (p = x); var f = x - p; i ? (t.style.height = g * f + "px", t.style.paddingTop = y * f + "px", t.style.paddingBottom = m * f + "px", t.style.marginTop = u * f + "px", t.style.marginBottom = h * f + "px") : (t.style.height = n - g * f + "px", t.style.paddingTop = a - y * f + "px", t.style.paddingBottom = s - m * f + "px", t.style.marginTop = r - u * f + "px", t.style.marginBottom = d - h * f + "px"), f >= e ? (t.style.height = "", t.style.paddingTop = "", t.style.paddingBottom = "", t.style.marginTop = "", t.style.marginBottom = "", t.style.overflow = "", i || (t.style.display = "none"), "function" == typeof o && o()) : window.requestAnimationFrame(l) }) }

let sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
for (var i = 0; i < sidebarItems.length; i++) {
    let sidebarItem = sidebarItems[i];
    sidebarItems[i].querySelector('.sidebar-link').addEventListener('click', function (e) {
        e.preventDefault();

        let submenu = sidebarItem.querySelector('.submenu');
        if (submenu.classList.contains('active')) submenu.style.display = "block"

        if (submenu.style.display == "none") submenu.classList.add('active')
        else submenu.classList.remove('active')
        slideToggle(submenu, 300)
    })
}

window.addEventListener('DOMContentLoaded', (event) => {
    var w = window.innerWidth;
    if (w < 1200) {
        document.getElementById('sidebar').classList.remove('active');
    }
});
window.addEventListener('resize', (event) => {
    var w = window.innerWidth;
    if (w < 1200) {
        document.getElementById('sidebar').classList.remove('active');
    } else {
        document.getElementById('sidebar').classList.add('active');
    }
});

document.querySelector('.burger-btn').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('active');
})
document.querySelector('.sidebar-hide').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('active');

})


// Perfect Scrollbar Init
if (typeof PerfectScrollbar == 'function') {
    const container = document.querySelector(".sidebar-wrapper");
    const ps = new PerfectScrollbar(container, {
        wheelPropagation: false
    });
}

// Scroll into active sidebar
// document.querySelector('.sidebar-item.active').scrollIntoView(false)

$(".submenu-item.active")
    .parents(".submenu")
    .addClass("d-block active")
    .parents(".sidebar-item")
    .addClass("active");


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

$(".save-form").on("submit", function (e) {
    e.preventDefault();
    form = $(this);
    submitForm(form).done(function (response) {
        form.find("[type=submit]").prop("disabled", false).html("Lưu");
    });
});

function submitForm(frm) {
    var btn = frm.find("[type=submit]:last");
    frm.find("input")
        .add("select")
        .add("textarea")
        .removeClass("is-invalid")
        .prop("disabled", false)
        .next()
        .remove("span");
    let str = `<span class="${btn.text() == "" ? "" : "text-white"
        }"><i class="bi bi-exclamation-circle-fill mt-1"></i>${btn.text() == "" ? "" : " Thử lại"
        }</span>`;
    btn.prop("disabled", true).html(
        '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>'
    );
    const processing = setTimeout(() => {
        Swal.fire({
            title: "Vẫn đang hoạt động...",
            text: "Thao tác của bạn cần nhiều thời gian hơn để xử lý. Xin hãy kiên nhẫn!",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading();
            },
        });
    }, 3000);
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
                // updateOptions();
                $(".dataTable").each(function () {
                    $(this).DataTable().clear().draw();
                });
            } else {
                Swal.fire(
                    "THẤT BẠI!",
                    "Lỗi không xác định. Vui lòng liên hệ nhà phát triển phần mềm để khắc phục.",
                    response.status
                );
                btn.prop("disabled", false).html(str);
            }
            clearTimeout(processing);
            Swal.close();
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
                        Swal.fire("Thông báo!", error[0], "info");
                    }
                });
            } else {
                Toastify({
                    text: "Lỗi không xác định. Vui lòng liên hệ nhà phát triển phần mềm để khắc phục.",
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

$(document).on("click", ".btn-remove", function (e) {
    e.preventDefault();
    const form = $(this).parent();
    Swal.fire({
        title: "Lưu ý!",
        text: "Bạn có chắc chắn xóa?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Vâng, xóa đi!",
        cancelButtonText: "Không, hủy bỏ!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm(form);
        }
    });
});
