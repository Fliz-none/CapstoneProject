let userMessage = null;
let selectedFiles = [];

// Gửi tin nhắn và file đính kèm lên server
function sendChatMessageToServer(message, attachments, onSuccess, onError) {
    const formData = new FormData();
    formData.append("message", message);
    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

    attachments.forEach((file) => {
        formData.append("attachments[]", file);
    });

    $.ajax({
        url: config.routes.pusher.broadcast,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: onSuccess,
        error: onError,
    });
}

// Render preview file
function renderPreview() {
    const previewBox = $("#previewAttachments").empty();
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const fileUrl = e.target.result;
            let preview = `<div class="preview-item position-relative" data-index="${index}">
                                <button class="btn-remove-file position-absolute top-0 end-0 btn btn-sm btn-danger"><i class="bi bi-x"></i></button>`;

            if (file.type.startsWith("image/")) {
                preview += `<img src="${fileUrl}" class="thumb img-fluid" title="${file.name}">`;
            } else if (file.type.startsWith("video/")) {
                preview += `<video controls style="max-width:100px; max-height:100px;" title="${file.name}">
                                <source src="${fileUrl}" type="${file.type}">
                                Video not supported
                            </video>`;
            } else {
                preview += `<div class="border p-2 rounded bg-light d-flex align-items-center" style="max-width:100px;">
                                <i class="bi bi-file-earmark me-2"></i>
                                <span class="text-truncate fs-6" title="${file.name}">${file.name}</span>
                            </div>`;
            }

            preview += `</div>`;
            previewBox.append(preview);
        };

        reader.readAsDataURL(file);
    });
}

// Khi chọn file
$(document).on("change", "#chatAttachments", function (e) {
    const files = Array.from(e.target.files);

    if (files.length + selectedFiles.length > 5) {
        alert("Chỉ được chọn tối đa 5 tệp.");
        this.value = "";
        return;
    }

    selectedFiles = selectedFiles.concat(files);
    renderPreview();
});

// Xoá file đã chọn
$(document).on("click", ".btn-remove-file", function () {
    const previewItem = $(this).closest(".preview-item");
    const index = parseInt(previewItem.data("index"), 10);

    selectedFiles.splice(index, 1);

    previewItem.fadeOut(200, function () {
        $(this).remove();
        $(".preview-item").each((i, el) => {
            $(el).attr("data-index", i);
        });
    });
});

// Gửi tin nhắn (Enter hoặc click)
function handleChat() {
    userMessage = $(".chat-input textarea").val().trim();
    if (!userMessage && selectedFiles.length === 0) return;

    const attachments = [...selectedFiles];

    $(".chat-input textarea").val("");
    $("#chatAttachments").val("");
    selectedFiles = [];
    $("#previewAttachments").empty();

    const sendingEl = $(`
        <li class="chat outgoing temp-sending">
            <p><i>Sending...</i></p>
        </li>
    `);
    $(".chatbox").append(sendingEl);
    sendChatMessageToServer(
        userMessage,
        attachments,
        function (response) {
            sendingEl.remove();
        },
        function (errors) {
            sendingEl.remove();
            if (errors.status == 419 || errors.status == 401) {
                window.location.href = config.routes.login;
            } else {
                Toastify({
                    text: errors.responseJSON || "Có lỗi xảy ra",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "var(--bs-danger)",
                }).showToast();
            }
        }
    );
}

// Bind các sự kiện gửi
$(".chat-input textarea").on("keydown", function (e) {
    if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleChat();
    }
});

$(".chat-input span").on("click", handleChat);
$(".close-btn").on("click", () => $("body").removeClass("show-chatbot"));
$(".chatbot-toggler").on("click", () => $("body").toggleClass("show-chatbot"));
