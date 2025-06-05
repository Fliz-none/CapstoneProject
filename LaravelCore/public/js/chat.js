let userMessage = null;

function sendChatMessageToServer(message, onSuccess, onError) {
    $.ajax({
        url: config.routes.pusher.broadcast,
        method: 'POST',
        data: {
            message: message,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: onSuccess,
        error: onError
    });
}

function handleChat() {
    userMessage = $('.chat-input textarea').val().trim();
    if (!userMessage) return;

    $('.chat-input textarea').val('');
    const sendingEl = $(`
        <li class="chat outgoing temp-sending">
            <p><i>Sending...</i></p>
        </li>
    `);
    $('.chatbox').append(sendingEl);
    sendChatMessageToServer(
        userMessage,
        function (response) {
            sendingEl.remove();
            return;
        },
        function (errors) {
            sendingEl.remove();
            if (errors.status == 419 || errors.status == 401) {
                window.location.href = config.routes.login;
            } else {
                Toastify({
                    text: errors.responseJSON,
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

$('.chat-input textarea').on('keydown', function (e) {
    if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleChat();
    }
});

$('.chat-input span').on('click', handleChat);
$('.close-btn').on('click', () => $('body').removeClass('show-chatbot'));
$('.chatbot-toggler').on('click', () => $('body').toggleClass('show-chatbot'));
