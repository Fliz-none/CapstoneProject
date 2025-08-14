<button class="chatbot-toggler">
    <span class="material-symbols-rounded fs-5 pt-1"><i class="bi bi-chat-left-text"></i></span>
    <span class="material-symbols-outlined fs-4"><i class="bi bi-x"></i></span>
</button>
<div class="chatbot">
    <header>
        <div class="d-flex align-items-center justify-content-center gap-2">
            <h2>{{ __('lang_web.footer.chat_with_us') }}</h2>
            <button class="active" id="aiToggle" title="Đang chat với AI">
                <i class="bi bi-robot"></i>
            </button>
            <span class="close-btn material-symbols-outlined"><i class="bi bi-x"></i></span>
        </div>
    </header>
    <ul class="chatbox">
    </ul>
    <div class="px-3" id="previewAttachments"></div>
    <div class="chat-input d-flex position-relative">
        <input class="d-none" id="chatAttachments" type="file" name="attachments[]" multiple accept="image/*,video/*,audio/*,application/*,text/*,doc">
        <button class="btn btn-link text-muted p-1" id="toggleEmojiPicker" type="button" title="Emoji">
            <i class="bi bi-emoji-smile fs-5"></i>
        </button>
        <!-- Danh sách Emoji (dropdown) -->
        <div class="border bg-white p-2 rounded shadow-sm position-absolute" id="emojiPicker" style="display: none; bottom: 100%; left: 0; z-index: 10000; max-height: 200px; overflow-y: auto; width: 260px;">
            <span class="emoji">❤️</span>
            <span class="emoji">👍</span>
            <span class="emoji">😘</span>
            <span class="emoji">👏</span>
            <span class="emoji">🎉</span>
            <span class="emoji">🤣</span>
            <span class="emoji">🥲</span>
            <span class="emoji">🤭</span>
            <span class="emoji">🤔</span>
            <span class="emoji">🫡</span>
            <span class="emoji">🤐</span>
            <span class="emoji">🤨</span>
            <span class="emoji">💅</span>
            <span class="emoji">🤳</span>
            <span class="emoji">💪</span>
            <span class="emoji">🦻</span>
            <span class="emoji">👃</span>
            <span class="emoji">👄</span>
            <span class="emoji">🫦</span>
            <span class="emoji">🫧</span>
            <span class="emoji">🫥</span>
            <span class="emoji">🫢</span>
            <span class="emoji">🫣</span>
            <span class="emoji">🤪</span>
            <span class="emoji">🤑</span>
            <span class="emoji">🤗</span>
            <span class="emoji">🤩</span>
            <span class="emoji">😛</span>
        </div>
        <p class="btn btn-select-attachments fw-bold my-auto" style="color: rgb(66, 91, 237)"><i class="bi bi-paperclip"></i></p>
        <textarea id="message" name="message" placeholder="Enter a message..." spellcheck="false" required></textarea>
        <span class="material-symbols-rounded" id="send-btn"><i class="bi bi-send"></i></span>
    </div>
</div>
<audio id="chatSound" src="{{ asset('/sounds/sound_notification.mp3') }}" class="d-" preload="auto"></audio>

