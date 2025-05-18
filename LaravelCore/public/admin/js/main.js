function slideToggle(t, e, o) {
    0 === t.clientHeight ? j(t, e, o, !0) : j(t, e, o);
}
function slideUp(t, e, o) {
    j(t, e, o);
}
function slideDown(t, e, o) {
    j(t, e, o, !0);
}
function j(t, e, o, i) {
    void 0 === e && (e = 400),
        void 0 === i && (i = !1),
        (t.style.overflow = "hidden"),
        i && (t.style.display = "block");
    var p,
        l = window.getComputedStyle(t),
        n = parseFloat(l.getPropertyValue("height")),
        a = parseFloat(l.getPropertyValue("padding-top")),
        s = parseFloat(l.getPropertyValue("padding-bottom")),
        r = parseFloat(l.getPropertyValue("margin-top")),
        d = parseFloat(l.getPropertyValue("margin-bottom")),
        g = n / e,
        y = a / e,
        m = s / e,
        u = r / e,
        h = d / e;
    window.requestAnimationFrame(function l(x) {
        void 0 === p && (p = x);
        var f = x - p;
        i
            ? ((t.style.height = g * f + "px"),
              (t.style.paddingTop = y * f + "px"),
              (t.style.paddingBottom = m * f + "px"),
              (t.style.marginTop = u * f + "px"),
              (t.style.marginBottom = h * f + "px"))
            : ((t.style.height = n - g * f + "px"),
              (t.style.paddingTop = a - y * f + "px"),
              (t.style.paddingBottom = s - m * f + "px"),
              (t.style.marginTop = r - u * f + "px"),
              (t.style.marginBottom = d - h * f + "px")),
            f >= e
                ? ((t.style.height = ""),
                  (t.style.paddingTop = ""),
                  (t.style.paddingBottom = ""),
                  (t.style.marginTop = ""),
                  (t.style.marginBottom = ""),
                  (t.style.overflow = ""),
                  i || (t.style.display = "none"),
                  "function" == typeof o && o())
                : window.requestAnimationFrame(l);
    });
}

let sidebarItems = document.querySelectorAll(".sidebar-item.has-sub");
for (var i = 0; i < sidebarItems.length; i++) {
    let sidebarItem = sidebarItems[i];
    sidebarItems[i]
        .querySelector(".sidebar-link")
        .addEventListener("click", function (e) {
            e.preventDefault();

            let submenu = sidebarItem.querySelector(".submenu");
            if (submenu.classList.contains("active"))
                submenu.style.display = "block";

            if (submenu.style.display == "none")
                submenu.classList.add("active");
            else submenu.classList.remove("active");
            slideToggle(submenu, 50);
        });
}

window.addEventListener("DOMContentLoaded", (event) => {
    var w = window.innerWidth;
    if (w <= 1920) {
        document.getElementById("sidebar").classList.remove("active");
        $(".tabbar").removeClass("sidebar-active");
    }
});
window.addEventListener("resize", (event) => {
    var w = window.innerWidth;
    if (w <= 1920) {
        document.getElementById("sidebar").classList.remove("active");
        $(".tabbar").removeClass("sidebar-active");
    } else {
        document.getElementById("sidebar").classList.add("active");
        $(".tabbar").addClass("sidebar-active");
    }
});

document.querySelector(".burger-btn").addEventListener("click", () => {
    setTimeout(() => {
        document.getElementById("sidebar").classList.toggle("active");
        $(".tabbar").toggleClass("sidebar-active");
    }, 100);
});

document.querySelector(".sidebar-hide").addEventListener("click", () => {
    document.getElementById("sidebar").classList.toggle("active");
    $(".tabbar").toggleClass("sidebar-active");
});

$("#main").click(function () {
    if ($("#sidebar").hasClass("active")) {
        $("#sidebar").removeClass("active");
    }
});

// Perfect Scrollbar Init
if (typeof PerfectScrollbar == "function") {
    const container = document.querySelector(".sidebar-wrapper");
    const ps = new PerfectScrollbar(container, {
        wheelPropagation: false,
    });
}

// Scroll into active sidebar
// document.querySelector('.sidebar-item.active').scrollIntoView(false)

/**
 * Thêm class active cho sidebar
 */
$(".submenu-item > a").each(function () {
    if ($(this).attr("href") === window.location.href) {
        $(this)
            .parents()
            .addClass("active")
            .parents(".submenu")
            .addClass("active")
            .parents(".sibdebar-item")
            .addClass("active");
    }
});

$(".sidebar-link").each(function () {
    if ($(this).attr("href") === window.location.href) {
        $(this).parent().addClass("active");
    }
});

$("#navbar-select").keyup(function () {
    if ($(this).val()) {
        $(this).parent().next().find("ul.submenu").addClass("active");
        setTimeout(() => {
            $(this)
                .parent()
                .next()
                .find("ul.submenu")
                .find("li.submenu-item")
                .each(function () {
                    if ($(this).css("display") !== "none") {
                        $(this).closest(".has-sub").show();
                    }
                });
        }, 500);
    } else {
        $(this).parent().next().find("ul.submenu").removeClass("active");
    }
});
moment.updateLocale("vi", {
    week: {
        dow: 1, // Thứ Hai là ngày đầu tuần (0 là Chủ nhật, 1 là Thứ Hai)
        doy: 7, // Ngày đầu tiên của năm được coi là ở tuần có ngày 7 tháng 1 (điều này liên quan đến quy tắc ISO)
    },
});

//Thiết lập ajax chung cho toàn hệ thống
$(document).ajaxStart(function () {
    $(".loading").removeClass("d-none");
});
$(document).ajaxStop(function () {
    $(".loading").addClass("d-none");
});
$.ajaxSetup({
    error: function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status == 419 || jqXHR.status == 401) {
            showLoginForm();
        } else if (jqXHR.status == 0 && textStatus == "abort") {
            console.warn(errorThrown);
        } else {
            Swal.fire(textStatus, jqXHR.responseText, "error");
        }
    },
});

//Cập nhật CSRF cho website khi logout ajax
function updateCsrfToken(token) {
    $('meta[name="csrf-token"]').attr("content", token);
    $('input[name="_token"]').val(token);
}

function showLoginForm() {
    const form = $("#login-form");
    form.attr("action", config.routes.login);
    form.find(".modal").modal("show");
}

function submitLogoutForm() {
    const form = $("#logout-form");
    form.attr("action", "/logout");
    submitForm(form).done(function (response) {
        showLoginForm();
        updateCsrfToken(response.token);
    });
}

//Tổ hợp phím Ctrl + End
$(document).on("keydown", function (e) {
    if (e.ctrlKey && e.key === "End") {
        e.preventDefault();
        submitLogoutForm();
    }
});

//Ngăn chặn phím Enter khi đang nhập input
$(document).on("keydown", "input", function (event) {
    if (event.key === "Enter") {
        if (!$(this).closest("form").hasClass("symptom-item-form")) {
            event.preventDefault();
            return false;
        }
    }
});

//Sắp xếp checked box lên trên đầu danh sách
function sortCheckedInput(form) {
    form.find(".list-group").each(function () {
        $(this)
            .find("input:checked")
            .each(function () {
                $(this).closest("li").prependTo($(this).closest(".list-group"));
            });
    });
}

//Input mask money
$(document).on("focus", ".money", function () {
    $(".money").mask("#,##0", {
        reverse: true,
    });
});
$(document).on("blur", ".money", function () {
    $(".money").unmask();
});

/**
 * Select2 Init()
 */
$("#main-content").find(".select2").select2(config.select2);
$("body").on("shown.bs.modal", ".modal", function () {
    $(".local-select").each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) {
            $(this).select2("destroy");
        }
    });
    $(this).find(".select2").select2(config.select2);
});

function initLocalSelect(
    dropdownParent,
    tags = true,
    placeholder = "Type more or choose from the list"
) {
    return {
        theme: "bootstrap-5",
        width: "100%",
        placeholder: placeholder,
        closeOnSelect: false,
        tags: tags, // Điều kiện tags dựa trên lớp CSS
        dropdownParent: dropdownParent, // Điều kiện dropdownParent dựa trên phần tử cha
    };
}

$("body").on("hidden.bs.modal", ".modal", function () {
    $(this)
        .find(".dataTable")
        .each(function () {
            $(this).DataTable().destroy();
        });
    if ($(".modal.show").length) {
        $(".modal.show").find(".select2").select2(config.select2);
    } else {
        $("#main-content")
            .find(".select2")
            .each(function () {
                $(this).select2(config.select2);
            });
        $(".local-select").each(function () {
            if (!$(this).hasClass("select2-hidden-accessible")) {
                $(this)
                    .select2(
                        initLocalSelect(
                            $(this).parent(),
                            $(this).hasClass("tags"),
                            $(this).attr("placeholder")
                        )
                    )
                    .trigger("change");
            }
        });
    }
});

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
 * Xử lý tooltip cho toàn trang
 */
$(document).on("mouseenter", '[data-bs-toggle="tooltip"]', function () {
    $(this).tooltip("show");
});

$(document).on("mouseleave", '[data-bs-toggle="tooltip"]', function () {
    // $("[data-toggle='tooltip']").tooltip("destroy");
    $(".tooltip").remove();
});

$(document).on("click", ".quantity-group .btn", function () {
    let input = $(this).closest(".quantity-group").find("input"),
        value = !isNaN(parseInt(input.val().split(",").join("")))
            ? parseInt(input.val().split(",").join(""))
            : 1;
    if ($(this).hasClass("btn-dec")) {
        if (value > 1) {
            input.val(value - 1).change();
        } else {
            input.val(1).change();
        }
    } else {
        input.val(value + 1).change();
    }
});

/**
 * Xử lý preview
 */
$(document).on("click", ".btn-preview", function () {
    const id = $(this).attr("data-id"),
        url = $(this).attr("data-url"),
        modal = $("#preview-modal");
    $.get(`${url}/${id}/preview`, function (template) {
        modal.html(template).modal("show");
    });
});

/**
 * Định dạng số
 */
// function number_format(nStr) {
//     nStr += '';
//     x = nStr.split('.');
//     x1 = x[0];
//     x2 = x.length > 1 ? '.' + x[1] : '';
//     var rgx = /(\d+)(\d{3})/;
//     while (rgx.test(x1)) {
//         x1 = x1.replace(rgx, '$1' + ',' + '$2');
//     }
//     return x1 + x2;
// }
function number_format(nStr) {
    const formatter = new Intl.NumberFormat("en-US", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    });
    return formatter.format(nStr);
}

/**
 * Loại bỏ dấu tiếng Việt khỏi chuỗi
 */
function string_to_slug(str) {
    // remove accents
    var from =
            "àáãảạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệđùúủũụưừứửữựòóỏõọôồốổỗộơờớởỡợìíỉĩịäëïîöüûñçýỳỹỵỷ",
        to =
            "aaaaaaaaaaaaaaaaaeeeeeeeeeeeduuuuuuuuuuuoooooooooooooooooiiiiiaeiiouuncyyyyy";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(RegExp(from[i], "gi"), to[i]);
    }
    str = str
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\-]/g, "-")
        .replace(/-+/g, "-");
    return str;
}

// Xử lý khi người dùng click vào hình ảnh bất kỳ
$(document).on("click", "img.thumb", function () {
    Swal.fire({
        imageUrl: $(this).attr("src"),
        padding: 0,
        showConfirmButton: false,
        background: "transparent",
    });
});

/**
 * Check choice
 */
$(document).on("change", ".all-choices", function (e) {
    $(".choice").prop("checked", $(this).prop("checked")).change();
});
$(document).on("change", ".choice", function (e) {
    e.preventDefault();
    if ($(".choice:checked").length) {
        $(".process-btns").removeClass("d-none");
    } else {
        $(".process-btns").addClass("d-none");
    }
});

/**
 * Sắp xếp dữ liệu
 */
$("body").on("click", ".btn-sort", function () {
    var form = $(this).closest("section").find(".batch-form");
    var checkedValues = JSON.stringify(
        form
            .find('input[name="choices[]"]:checked')
            .map(function () {
                return $(this).val();
            })
            .get()
    );
    sortOrder(
        config.routes.get + "/list?ids=" + checkedValues,
        config.routes.sort
    );
});

function sortOrder(routeGet, routeSort) {
    $.get(routeGet, function (objs) {
        $("#sortable").empty();
        $("#sort-modal").find(".alert").remove();
        $.each(objs, function (index, obj) {
            $("#sort-modal").find("#sortable").append(`
            <li class="list-group-item d-flex justify-content-start align-items-center border" data-name="${string_to_slug(
                obj.name
            )}" data-time="${new Date(obj.created_at).getTime()}" data-id="${obj.id}">
                <i class="bi bi-grip-vertical"></i> <span>${obj.name}</span>
            </li>`);
        });
        $("#sort-modal").modal("show");
        $("#sortable").sortable({
            update: function (event, ui) {
                var sortedIDs = $("#sortable").sortable("toArray", {
                    attribute: "data-id",
                });
                saveOrder(sortedIDs, routeSort);
            },
        });
        $("#sortable").disableSelection();
    });
}

$(document).on("change", "#sort-type", function (e) {
    e.preventDefault();
    var sortable = $("#sortable");
    var items = sortable.children("li").get();
    switch ($(this).val()) {
        case "time-az":
            items.sort(function (a, b) {
                var timeA = $(a).attr("data-time");
                var timeB = $(b).attr("data-time");
                return timeA - timeB;
            });
            break;
        case "time-za":
            items.sort(function (a, b) {
                var timeA = $(a).attr("data-time");
                var timeB = $(b).attr("data-time");
                return timeB - timeA;
            });
            break;
        case "title-az":
            items.sort(function (a, b) {
                var textA = $(a).attr("data-name");
                var textB = $(b).attr("data-name");
                return textA < textB ? -1 : textA > textB ? 1 : 0;
            });
            break;
        case "title-za":
            items.sort(function (a, b) {
                var textA = $(a).attr("data-name");
                var textB = $(b).attr("data-name");
                return textA > textB ? -1 : textA < textB ? 1 : 0;
            });
            break;

        default:
            break;
    }
    $.each(items, function (index, item) {
        sortable.append(item);
    });
    var sortedIDs = $("#sortable").sortable("toArray", {
        attribute: "data-id",
    });
    saveOrder(sortedIDs, config.routes.sort);
});

function saveOrder(sortedIDs, routeSort) {
    $.ajax({
        type: "POST",
        url: routeSort,
        data: {
            sort: sortedIDs,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name = "csrf-token"]').attr("content"),
        },
        success: function (response) {
            pushToastify(response.msg, "success");
            $(".dataTable").DataTable().clear().draw();
        },
    });
}
//END Sắp xếp dữ liệu

/**
 * Xử lý tìm kiếm ajax-search
 */
$(".search-form input")
    .on(
        "keyup",
        debounce(function () {
            handleSearch($(this));
        }, 300)
    )
    .on("blur", function () {
        setTimeout(() => {
            const search_result = $(this)
                .closest(".ajax-search")
                .find(".search-result");
            search_result.removeClass("show");
        }, 500);
    });

function handleSearch(input) {
    const searchTerm = input.val(),
        search_result = input.closest(".ajax-search").find(".search-result"),
        result = input.closest(".row").find(".search-result");
    if (searchTerm != "") {
        $.get(`${input.attr("data-url")}&q=${searchTerm}`, function (response) {
            if (response.length) {
                search_result.html(response).addClass("show");
                setupArrowNavigation();
            } else {
                search_result
                    .html(
                        `
                    <li>
                        <div class="row p-0 mx-0">
                            <div class="col-12 py-3 text-center">
                                No matching results found
                            </div>
                        </div>
                    </li>`
                    )
                    .addClass("show");
            }
        });
    } else {
        search_result.removeClass("show");
    }
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

function setupArrowNavigation() {
    const items = $(".search-result .dropdown-item");
    let selectedIndex = -1;

    $(document)
        .off("keydown")
        .on("keydown", function (e) {
            switch (e.key) {
                case "ArrowDown":
                    if (selectedIndex < items.length - 1) {
                        selectedIndex++;
                        items.removeClass("active");
                        items.eq(selectedIndex).addClass("active");
                    }
                    break;
                case "ArrowUp":
                    if (selectedIndex > 0) {
                        selectedIndex--;
                        items.removeClass("active");
                        items.eq(selectedIndex).addClass("active");
                    }
                    break;
                case "Enter":
                    if (selectedIndex >= 0) {
                        items.eq(selectedIndex)[0].click();
                    }
                    break;
                case "Escape":
                    $(".search-form input").val("").focus();
                    $(".search-result").removeClass("show");
                    break;
                default:
                    break;
            }
        });
}

//LOCAL SEARCH
$(".search-input").on("keyup", function (e) {
    const $container = $(this).closest(".search-container"),
        $list = $container.siblings(".search-item").find(".search-list");
    switch (e.key) {
        case "Escape":
            $(this).val("").change().focus();
            filterList($(this), $list);
            break;
        default:
            filterList($(this), $list);
            break;
    }
});

// Hàm lọc danh sách
function filterList($input, $list) {
    var filter = string_to_slug($input.val().toLowerCase());

    $list.find("li").each(function () {
        var textValue = string_to_slug(
                $(this).find("label").text().toLowerCase()
            ),
            dataKeyword = $(this).attr("data-keyword")
                ? string_to_slug($(this).attr("data-keyword").toLowerCase())
                : "";

        if (textValue.indexOf(filter) > -1 || dataKeyword.includes(filter)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

/**
 * Nén và hiển thị hình ảnh
 */
$(".select-avatar").on("dragenter dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass("dragging");
});

$(".select-avatar").on("dragleave drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass("dragging");
});

// Xử lý sự kiện khi thả ảnh vào
$(".select-avatar").on("drop", function (e) {
    var dt = e.originalEvent.dataTransfer;
    var files = dt.files;

    // Kiểm tra nếu file là ảnh
    if (files.length > 0 && files[0].type.startsWith("image/")) {
        // Cập nhật file cho input[type="file"]
        $(this).closest("form").find("[name=avatar]")[0].files = files;

        // Tùy chọn: Hiển thị preview ảnh vừa thả
        var imgURL = URL.createObjectURL(files[0]);
        var img = $("<img>", {
            src: imgURL,
            css: {
                "max-width": "100%",
                "max-height": "200px",
            },
        });
        $(this).empty().append(img); // Xóa nội dung cũ và hiển thị ảnh mới
    } else {
        alert("Please drag and drop an image file.");
    }
});

$(document).on("change", "input[type=file][name=avatar]", function (event) {
    const file = event.target.files[0],
        input = $(this);
    if (file) {
        new Compressor(file, {
            quality: 0.8,
            maxWidth: 600,
            maxHeight: 600,
            mimeType: "image/webp",
            success(result) {
                const compressedFile = new File(
                    [result],
                    file.name.replace(/\.\w+$/, ".webp"),
                    {
                        type: "image/webp",
                        lastModified: Date.now(),
                    }
                );
                // Tạo lại input với file đã nén
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(compressedFile);
                input[0].files = dataTransfer.files;
                // Hiển thị hình ảnh đã nén
                const previewURL = URL.createObjectURL(compressedFile);
                input.prev().find("img").attr("src", previewURL);
                input.next().find("[type=button]").removeClass("d-none");
            },
            error(err) {
                pushToastify(err.message, "danger");
            },
        });
    }
});

/**
 * Xử lý hình ảnh
 */

//Tạo nút Thêm hình ảnh cho summernote
var selectImage = function () {
    var ui = $.summernote.ui;
    var button = ui.button({
        contents: '<i class="note-icon-picture"></i>',
        // tooltip: 'Add Image',
        click: function () {
            $("#quick_images-modal").modal("show");
            $(".btn-insert-images").removeClass("d-none");
            $(".btn-select-images").addClass("d-none");
        },
    });
    return button.render();
};

//Chèn hình ảnh đã chọn vào summernote
$(document).on("click", ".btn-insert-images", function () {
    $(".quick_images-choice:checked").each(function () {
        $(".summernote").summernote(
            "insertImage",
            config.routes.storage + "/" + $(this).attr("data-name"),
            function (image) {
                image.addClass("img-article rounded-4");
            }
        );
    });
    $(this).addClass("d-none").parents(".modal").modal("hide");
    $(".quick_images-choice").prop("checked", false);
});
//END xử lý hình ảnh đưa vào thẻ summernote

//Chọn hình ảnh
$(document).on("click", ".btn-select-images", function () {
    let imagesName = [];
    if ($(this).attr("data-select") == "single") {
        imagesName.length = 0;
    } else {
        imagesName = $("#" + $(this).attr("data-target"))
            .val()
            .split("|");
    }
    $(".quick_images-choice:checked").each(function () {
        imagesName.push($(this).attr("data-name"));
    });
    $("#" + $(this).attr("data-target"))
        .val(imagesName.join("|"))
        .change();
    $(this)
        .addClass("d-none")
        .parents(".modal")
        .modal("hide")
        .find(".quick_images-choice")
        .attr("type", "checkbox")
        .prop("checked", false); //reset
});

//Xử lý hiển thị hình ảnh cho module gallery_images
function viewImage(input) {
    if (input.val() != "") {
        $(`label[for='${input.attr("id")}']`)
            .find("img")
            .attr("src", config.routes.storage + "/" + input.val());
        input.next().find(".btn-remove-image").removeClass("d-none");
    } else {
        $(`label[for='${input.attr("id")}']`)
            .find("img")
            .attr("src", config.routes.placeholder);
        input.next().find(".btn-remove-image").addClass("d-none");
    }
}

function openQuickImages(target, isSingle = true) {
    $("#quick_images-modal").modal("show");
    $(".quick_images-choice").attr("type", isSingle ? "radio" : "checkbox");
    $(".btn-select-images")
        .removeClass("d-none")
        .attr("data-target", target)
        .attr("data-select", isSingle ? "single" : "multiple");
    $(".btn-insert-images").addClass("d-none");
}
//END xử lý hình ảnh đưa vào thẻ input

// Xử lý hiển thị hình ảnh từ module feature_image
$(".hidden-image").each(function () {
    viewImage($(this));
});

$(document).on("change", ".hidden-image", function () {
    viewImage($(this));
});

$(document).on("click", "label.select-image", function () {
    openQuickImages($(this).attr("for"));
});

//Xoá ảnh nổi bật
$(document).on("click", ".btn-remove-image", function () {
    const btn = $(this),
        form = btn.closest("form"),
        url = btn.attr("data-url"),
        id = form.find("[name=id]").val(),
        input = btn.parent().prev();
    Swal.fire(config.sweetAlert.confirm).then((result) => {
        if (result.isConfirmed) {
            if (id && !(input.files && input.files.length)) {
                const form = $(
                    `<form action="${url}" method="POST"><input name="id" value="${id}"></form>`
                );
                submitForm(form).done(function (response) {
                    if (response.status == "success") {
                        btn.addClass("d-none");
                        btn.closest(".sticky-top")
                            .find("img")
                            .attr("src", config.routes.placeholder);
                        input.val("").change();
                    }
                });
            } else {
                btn.addClass("d-none");
                btn.closest(".sticky-top")
                    .find("img")
                    .attr("src", config.routes.placeholder);
                input.val("").change();
            }
        }
    });
});

//Xoá gallery
$(document).on("click", ".btn-remove-images", function () {
    imagesName = $(this).parents(".gallery").prev().val().split("|");
    imagesName.splice($(this).attr("data-index"), 1);
    $(this).parents(".gallery").prev().val(imagesName.join("|")).change();
});
//END Xử lý hiển thị hình ảnh từ module feature_image

// Bật tắt nút XÓA khi thay đổi trạng thái checkbox
$(document).on("change", ".quick_images-choice", function (e) {
    if (
        $("#quick_images-grid-view").find(".quick_images-choice:checked").length
    ) {
        $(".btn-delete-images").removeClass("d-none");
    } else {
        $(".btn-delete-images").addClass("d-none");
    }
});
// END bật tắt nút xóa khi thay đổi trạng thái checkbox

//Bật modal sửa thông tin ảnh
$(document).on("click", ".btn-update-image", function () {
    const id = $(this).attr("data-id"),
        form = $("#quick_images-update-form");
    $.get(config.routes.getImage + "/" + id, function (image) {
        form.find("[name=name]").val(image.name.split(".")[0]);
        form.find("[name=alt]").val(image.alt);
        form.find("[name=caption]").val(image.caption);
        form.find("[name=id]").val(image.id);
        form.find(".card-img").attr("src", image.link);
        form.find(".btn-delete-image").attr("data-id", image.id);
        form.find(".modal").modal("show");
    });
});
//END Bật modal sửa thông tin ảnh

//Xoá ảnh đơn lẻ
$(document).on("click", ".btn-delete-image", function (e) {
    e.preventDefault();
    Swal.fire(config.sweetAlert.confirm).then((result) => {
        if (result.isConfirmed) {
            submitForm($(this).parents("form"));
        }
    });
});

//Xoá hàng loạt ảnh
$(".btn-delete-images").click(function () {
    $("#quick_images-form").attr("action", config.routes.deleteImage);
    Swal.fire(config.sweetAlert.confirm).then((result) => {
        if (result.isConfirmed) {
            submitForm($("#quick_images-form")).done(function () {
                $(".btn-delete-images").addClass("d-none");
            });
        }
    });
});
// END Xóa hàng loạt ảnh

/*********************************** Xử lý hình ảnh trong các phiếu chỉ định **************************************/
$(document).on("click", ".btn-upload-images", function () {
    const id = $(this).data("id"); // Lấy ID của vùng hiện tại (phiếu chỉ định)
    const gallery = $(`div[data-gallery="${id}"]`); // Lấy gallery tương ứng với ID
    const currentImages = gallery.find(".col-6.col-lg-2").length; // Đếm số lượng hình ảnh hiện tại

    if (currentImages < 11) {
        // Kiểm tra số lượng hình ảnh có nhỏ hơn 10 không
        $(`input[data-id="${id}"]`).click(); // Nếu nhỏ hơn 10, kích hoạt sự kiện click cho input file tương ứng
    } else {
        pushToastify("Maximum of 10 images allowed.", "danger"); // Thông báo nếu đã đạt giới hạn
    }
});

$(document).on("change", ".imageInput", function (event) {
    const id = $(this).data("id"); // Lấy ID của input hiện tại (phiếu chỉ định)
    const files = event.target.files; // Lấy tất cả các file được chọn
    const gallery = $(`div[data-gallery="${id}"]`); // Lấy gallery tương ứng với ID
    const currentImages = gallery.find(".col-6.col-lg-2").length; // Đếm số lượng hình ảnh hiện tại
    let imageNames = []; // Mảng để lưu tên hình ảnh

    // Lấy tên hình ảnh đã lưu trước đó từ input ẩn
    const existingImageNames = $(`#imgName-${id}`).val();
    if (existingImageNames) {
        imageNames = existingImageNames.split("|");
    }

    if (files.length > 0) {
        // Kiểm tra tổng số hình ảnh sau khi thêm có vượt quá 10 hay không
        if (currentImages + files.length > 11) {
            pushToastify("Maximum of 10 images allowed.", "danger"); // Thông báo nếu vượt quá giới hạn
            return;
        }

        // Đọc và thêm từng file ảnh vào gallery
        Array.from(files).forEach((file) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const imageUrl = e.target.result;
                const imageName = file.name; // Lấy tên file

                // Thêm tên file vào danh sách tên hình ảnh
                imageNames.push(imageName);

                // Tạo phần tử mới chứa hình ảnh
                const imageDiv = $(`
                    <div class="col-6 col-lg-2 mt-2">
                        <div class="card card-image mb-1">
                            <button class="btn-close" type="button" aria-label="Close"></button>
                            <div class="ratio ratio-1x1">
                                <img src="${imageUrl}" class="thumb img-fluid object-fit-cover rounded">
                            </div>
                        </div>
                    </div>
                `);

                // Thêm hình ảnh vào gallery tương ứng
                gallery.append(imageDiv);

                // Gắn sự kiện click cho nút "Xóa" (btn-close)
                imageDiv.find(".btn-close").on("click", function () {
                    imageDiv.remove(); // Xóa phần tử hình ảnh
                    const index = imageNames.indexOf(imageName);
                    if (index > -1) {
                        imageNames.splice(index, 1); // Xóa tên file khỏi danh sách
                        updateImageNamesInput(id, imageNames); // Cập nhật input ẩn
                    }
                });

                // Cập nhật input ẩn với danh sách tên hình ảnh
                updateImageNamesInput(id, imageNames);
            };

            reader.readAsDataURL(file); // Đọc file ảnh dưới dạng URL
        });
    }
});

// Xử lý load hình ảnh lên cho các phiếu con
$(document).on("change", ".image-array", function (event) {
    const input = $(this),
        id = input.data("id"),
        files = event.target.files,
        gallery = $(`div[data-gallery="${id}"]`);

    if (files.length > 0) {
        if (files.length > 10) {
            pushToastify("Maximum of 10 images allowed.", "danger");
            return;
        }
        gallery.children().not(":first").remove();

        const dataTransfer = new DataTransfer();
        let filesProcessed = 0;
        Array.from(files).forEach((file) => {
            new Compressor(file, {
                quality: 0.8,
                maxWidth: 1600,
                maxHeight: 1600,
                success(result) {
                    const fileName = file.name;
                    const fileType = file.type;
                    const blob = result.slice(0, result.size, fileType);
                    const newFile = new File([blob], fileName, {
                        type: fileType,
                    });

                    dataTransfer.items.add(newFile);

                    filesProcessed++;
                    if (filesProcessed === files.length) {
                        input[0].files = dataTransfer.files;
                    }
                },
                error(err) {
                    console.error(err.message);
                },
            });

            // Đọc và thêm từng file ảnh vào gallery
            const reader = new FileReader();

            reader.onload = function (e) {
                const imageUrl = e.target.result,
                    imageDiv = $(`
                        <div class="col-6 col-lg-2 mt-2">
                            <div class="card card-image mb-1">
                                <div class="ratio ratio-1x1">
                                    <img src="${imageUrl}" class="thumb img-fluid object-fit-cover cursor-pointer rounded">
                                </div>
                            </div>
                        </div>
                    `);
                gallery.append(imageDiv);
            };

            reader.readAsDataURL(file); // Đọc file ảnh dưới dạng URL
        });
    }
});

// Hàm cập nhật input ẩn với tên hình ảnh
function updateImageNamesInput(id, imageNames) {
    $(`#imgName-${id}`).val(imageNames.join("|"));
}
/*********************************** Hết xử lý hình ảnh phiếu chỉ định **************************************/

/**
 * Reset form
 */
function resetForm(frm) {
    frm.trigger("reset")
        .removeAttr("action")
        .find(".modal")
        .modal("hide")
        .find("img")
        .attr("src", config.routes.placeholder)
        .end()
        .find("[type=submit]")
        .prop("disabled", false)
        .html("Save")
        .removeClass("d-none")
        .end()
        .find("[type=hidden]")
        .val("")
        .change()
        .end()
        .find("textarea")
        .val("")
        .end()
        .find("[type=checkbox]")
        .prop("checked", false)
        .end()
        .find(".select2")
        .each(function () {
            $(this).val(null);
        })
        .end()
        .find("input")
        .add("select")
        .add("textarea")
        .removeClass("is-invalid")
        .prop("disabled", false)
        .next()
        .remove("span.text-danger");
}

$(".save-form").on("submit", function (e) {
    e.preventDefault();
    form = $(this);
    submitForm(form).done(function (response) {
        const btn = form.find("[type=submit]"),
            text = btn.data("text");
        btn.prop("disabled", false).html(text !== undefined ? text : "Save");
        switch (form.attr("id")) {
            case "user-form":
                if (response.user) {
                    //Đối với select2[name=customer_id]
                    let option = new Option(
                        response.user.name + " - " + response.user.phone,
                        response.user.id,
                        true,
                        true
                    );
                    $("[name=customer_id]").html(option).trigger({
                        type: "select2:select",
                    });
                    // //Đối với ajax-search
                    // fillCustomer(
                    //     response.user.id,
                    //     response.user.name + " - " + response.user.phone
                    // );
                    // fillListPet(response.user.id);
                }
                break;
            case "pet-form":
                if (response.pet) {
                    fillListPet(response.pet.customer_id, response.pet.id);
                }
                break;
            case "info-service-form":
                reloadIndication(response.objs);
                break;
            case "login-form":
                updateCsrfToken(response.token);
                $("nav.navbar .user-name h6")
                    .text(response.user.name)
                    .next()
                    .text(
                        response.main_branch != null
                            ? response.main_branch.name
                            : "No branches found"
                    );
                break;
            case "booking-form":
                if ($(".calendar").length) {
                    const date = moment(response.obj.appointment_at).format(
                        "DD/MM/YYYY"
                    );
                    fillData(date + " - " + date);
                }
                break;
            case "room-form":
                $(".btn-read-rooms").trigger("click");
                break;
            case "accommodation-form":
                $(".modal#accommodation-modal").modal("hide");
                break;
            case "export-form":
                const path = window.location.pathname;
                if (path.startsWith("/quantri/info")) {
                    location.reload();
                }
                break;
            case "tracking-form":
                fillTracking(response.obj.accommodation.tracking_groups);
                break;
            case "render_stock-form":
                $(".btn-sync-stock").attr("disabled", false);
                break;
            case "branch_user-form":
                location.reload(); 
                break;
            default:
                break;
        }
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
        .remove("span.response");
    let str = `<span class="${
        btn.text() == "" ? "" : "text-white"
    }"><i class="bi bi-exclamation-circle-fill mt-1"></i>${
        btn.text() == "" ? "" : " Try again"
    }</span>`;
    btn.prop("disabled", true).html(
        '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>'
    );
    const processing = setTimeout(() => {
        Swal.fire(config.sweetAlert.delay);
    }, 5000);
    $(".local-select").each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) {
            $(this).select2("destroy");
        }
    });
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
                const formId = frm.attr("id");
                resetForm(frm);
                if (!response.token) {
                    $(".dataTable").each(function () {
                        $(this).DataTable().ajax.reload(null, false);
                    });
                }
            } else if (
                response.status == "danger" ||
                response.status == "error"
            ) {
                Swal.fire("FAILED!", response.msg, response.status);
                $("input.select2-search__field").removeAttr("style");
                btn.prop("disabled", false).html(str);
            }
            if (!frm.find(".modal").length) {
                $(`.select2`).select2(config.select2);
                $(".local-select").each(function () {
                    if (!$(this).hasClass("select2-hidden-accessible")) {
                        $(this).select2(
                            initLocalSelect(
                                $(this).parent(),
                                $(this).hasClass("tags"),
                                $(this).attr("placeholder")
                            )
                        );
                    }
                });
            }
        },
        error: function error(errors) {
            clearTimeout(processing);
            Swal.close();
            $("input.select2-search__field").removeAttr("style");
            btn.prop("disabled", false).html(str);
            if (errors.status == 419 || errors.status == 401) {
                showLoginForm();
            } else if (errors.status == 422) {
                frm.find(".is-invalid")
                    .removeClass("is-invalid")
                    .next()
                    .remove("span");
                $.each(errors.responseJSON.errors, function (i, error) {
                    var el = frm.find('[name="' + i + '"]');
                    if (
                        el.length &&
                        !el.hasClass("d-none") &&
                        el.attr("type") != "hidden" &&
                        el.attr("type") != "radio" &&
                        !el.prop("hidden")
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

                pushToastify(
                    "Unknown error. Please contact the software developer for assistance.",
                    "danger"
                );
            }
            if (!frm.find(".modal").length) {
                $(`.select2`).select2(config.select2);
                $(".local-select").each(function () {
                    if (!$(this).hasClass("select2-hidden-accessible")) {
                        $(this).select2(
                            initLocalSelect(
                                $(this).parent(),
                                $(this).hasClass("tags"),
                                $(this).attr("placeholder")
                            )
                        );
                    }
                });
            }
        },
    });
}

$(document).on("click", ".btn-remove", function (e) {
    e.preventDefault();
    const form = $(this).parent();
    Swal.fire(config.sweetAlert.confirm).then((result) => {
        if (result.isConfirmed) {
            submitForm(form);
        }
    });
});

$(document).on("click", ".btn-removes", function () {
    var form = $(this).closest("section").find(".batch-form");
    form.attr("action", config.routes.remove);
    Swal.fire(config.sweetAlert.confirm).then((result) => {
        if (result.isConfirmed) {
            $(this)
                .prop("disabled", true)
                .html(
                    '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>'
                );
            submitForm(form)
                .done(function () {
                    resetForm(form);
                    $(".btn-removes")
                        .prop("disabled", false)
                        .html('<i class="bi bi-trash"></i> Delete')
                        .parent()
                        .addClass("d-none");
                })
                .fail(function () {
                    $(".btn-removes")
                        .prop("disabled", false)
                        .html(
                            '<span class="text-white""><i class="bi bi-exclamation-circle-fill mt-1"></i> Try again</span>'
                        );
                });
        }
    });
});

/**
 * Xử lý xóa các chi tiết phiếu có sử dụng bảng
 */
$(document).on("click", ".btn-remove-detail", function (e) {
    e.preventDefault();
    const btn = $(this),
        id = btn.attr("data-id"),
        url = btn.attr("data-url");
    if (id && url) {
        Swal.fire(config.sweetAlert.confirm).then((result) => {
            if (result.isConfirmed) {
                const form = $(
                    `<form action="${url}" method="POST"><input name="choices[]" value="${id}"></form>`
                );
                submitForm(form).done(function (response) {
                    if (response.status == "success") {
                        if (btn.hasClass("remove-card")) {
                            btn.closest(".detail").remove();
                            btn.closest(".receipt-order").length
                                ? totalOrder()
                                : null;
                        } else {
                            btn.closest("tr").remove();
                        }
                    }
                });
            }
        });
    } else {
        if (btn.hasClass("remove-card")) {
            const detail_parent = btn.closest(".detail").parent();
            btn.closest(".detail").remove();
            if (btn.hasClass("remove-criterial")) {
                detail_parent.find(".detail").each(function (index) {
                    $(this)
                        .find("input, textarea")
                        .each(function () {
                            const name = $(this).attr("name");
                            if (name) {
                                const updatedName = name.replace(
                                    /\[([0-9]+)\]/,
                                    `[${index}]`
                                );
                                $(this).attr("name", updatedName);
                            }
                        });
                });
            }
            btn.closest(".receipt-order").length ? totalOrder() : null;
        } else {
            btn.closest("tr").remove();
        }
    }
});

/**
 * Xử lý summernote editor
 */
$(".air").summernote({
    airMode: true,
    popover: {
        link: [["link", ["linkDialogShow", "unlink"]]],
        table: [
            ["add", ["addRowDown", "addRowUp", "addColLeft", "addColRight"]],
            ["delete", ["deleteRow", "deleteCol", "deleteTable"]],
        ],
        air: [
            ["font", ["bold", "underline", "clear"]],
            ["para", ["ul", "ol", "paragraph", "height"]],
            ["insert", ["hr", "link", "table"]],
            ["misc", ["undo", "redo"]],
        ],
    },
});

$(".summernote").summernote({
    tabsize: 2,
    height: 500,
    disableDragAndDrop: true,
    codemirror: {
        theme: "monokai",
    },
    toolbar: [
        // [groupName, [list of button]]
        ["style", ["style", "bold", "italic", "underline", "clear"]],
        ["font", ["strikethrough", "superscript", "subscript"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["height", ["height"]],

        ["table", ["table"]],
        ["insert", ["link", "image", "video"]],
        ["view", ["fullscreen", "codeview"]],
    ],
    buttons: {
        image: selectImage,
    },
    popover: {
        image: [
            [
                "image",
                ["resizeFull", "resizeHalf", "resizeQuarter", "resizeNone"],
            ],
            ["float", ["floatLeft", "floatRight", "floatNone"]],
            ["remove", ["removeMedia"]],
        ],
        link: [["link", ["linkDialogShow", "unlink"]]],
        table: [
            ["add", ["addRowDown", "addRowUp", "addColLeft", "addColRight"]],
            ["delete", ["deleteRow", "deleteCol", "deleteTable"]],
        ],
    },
});
//END xử lý summernote editor

// Tạo ô tìm kiếm cho từng cột dữ liệu datatables, và ô input nhập số trang để chuyển.
function initDataTable(tableId, col = "", hiddenCols = "") {
    const table = $(`#${tableId}`).DataTable();
    const hiddenInputs = col.split(",").map((c) => parseInt(c.trim()) - 1);
    const hiddenCol = hiddenCols.split(",").map((c) => parseInt(c.trim()) - 1);
    table.on("init", function () {
        if (!$(this).find("thead tr.d-none").length) {
            $(this)
                .find("thead")
                .append('<tr class="d-none"></tr>')
                .end()
                .find("thead tr:first th")
                .each(function () {
                    $(this)
                        .closest("thead")
                        .find("tr:nth-child(2)")
                        .append(`<th></th>`);
                });
        }
        table.columns().every(function (index) {
            const column = this;
            if (!hiddenInputs.includes(index)) {
                const $headerRow = $(`#${tableId} thead tr:nth-child(2)`);
                const $headerCell =
                    $headerRow.length > 0
                        ? $headerRow.find("th").eq(index)
                        : null;

                if ($headerCell) {
                    if (hiddenCol.includes(index)) {
                        $headerCell.addClass("d-none");
                    } else {
                        let $input = $("<input>")
                            .addClass("form-control form-control-plaintext")
                            .attr("placeholder", "Search")
                            .on("keyup", function () {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                        $headerCell.empty().append($input);
                    }
                }
            }
        });
        $(`#${tableId}_wrapper`).find(".btn-clear-state").remove();
        $(`#${tableId}_wrapper`).find(".btn-advanced-search").remove();
        $(`#${tableId}_wrapper`)
            .find(".dataTables_paginate")
            .parent()
            .find("input")
            .remove();

        // Thêm icon slide để hiển thị các cột tìm kiếm chi tiết và reset lại trạng thái của bảng
        $(`#${tableId}_wrapper`).find(".dataTables_filter").append(`
            <button type="button" class="btn btn-link btn-advanced-search">
                <i class="bi bi-sliders"></i>
            </button>
            <button type="button" class="btn btn-link btn-clear-state">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        `);

        $(document).on(
            "click",
            `#${tableId}_wrapper .btn-clear-state`,
            function () {
                table.state.clear();
                table.search("");
                table.columns().search("").draw();
                table.ajax.reload();
            }
        );

        $(`#${tableId}_wrapper .btn-advanced-search`)
            .off("click")
            .on("click", function (e) {
                e.preventDefault();
                const searchColumnRow = $(`#${tableId} thead tr:nth-child(2)`);
                searchColumnRow.toggleClass("d-none");
            });

        // Thêm ô input nhập số trang để chuyển trang
        $(`#${tableId}_wrapper`)
            .find(".dataTables_paginate")
            .parent()
            .addClass("d-flex justify-content-end").prepend(`
            <div>
                <input style="width: 55px; margin-top: 2px; height: 36px" type="text" class="form-control input-paging me-2" min="1"/>
            </div>`);

        // Xử lý sự kiện nhập số trang
        $(`#${tableId}_wrapper`)
            .find(".dataTables_paginate")
            .parent()
            .find("input")
            .on("keydown", function (e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const pageNum = parseInt($(this).val(), 10) - 1;
                    const pageInfo = table.page.info();
                    if (
                        !isNaN(pageNum) &&
                        pageNum >= 0 &&
                        pageNum < pageInfo.pages
                    ) {
                        table.page(pageNum).draw("page");
                    } else {
                        pushToastify("Invalid page number!", "danger");
                    }
                }
            });
    });
}
// End xứ lý.
