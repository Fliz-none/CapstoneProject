@php
    $settings = cache()->get('settings');
@endphp
<div class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="row">
                <div class="col-lg-3 col-12 text-white">
                    <a href="{{ url('/') }}" title=" {{ $settings['company_name'] }}">
                        <img class="img-fluid" src="{{ asset('storage/' . $settings['favicon']) }}" alt="{{ $settings['company_name'] }}">
                    </a>
                </div>
                <div class="col-lg-7 col-12 text-white">
                    <div class="company-short-Info">
                        <h5 class="company-name">
                            {{ $settings['company_name'] }}
                        </h5>
                        <p class="company-des">
                            {{ $settings['company_description'] }}
                        </p>
                    </div>
                    <div class="footer-menu mx-0">
                        <div class="footer-menu-item f-width">
                            <h5 class="fw-semibold">{{ __('lang_web.header.contact') }}</h5>

                            <ul class="menu-list ic-list">
                                <li>
                                    <img class="img-fluid" src="{{ asset('images/img/map-pin.png') }}" alt="">
                                    <p>
                                        {{ $settings['company_address'] }}
                                    </p>
                                </li>
                                <li>
                                    <img class="img-fluid" src="{{ asset('images/img/mail.png') }}" alt="">
                                    <a href="mailto:truongthithuydung98@gmail.com" title="">
                                        Email: {{ $settings['company_email'] }}
                                    </a>
                                </li>
                                @php
                                    $company_name = $settings['company_name'] ?? 'SM Solution';
                                @endphp
                                <li class="align-items-start">
                                    <img class="img-fluid" src="{{ asset('images/img/phone.png') }}" alt="">
                                    <p>
                                        <span>{{ __('lang_web.footer.phone') }}: {{ $settings['company_hotline'] }}</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-12">
                    <div class="footer-menu">
                        <div class="footer-menu-item w-100">
                            <h5 class="menu-item-name">{{ __('lang_web.footer.category') }}</h5>
                            <ul class="menu-list">
                                <li>
                                    <a href="{{ route('home') }}" title=" Trang chủ">
                                        {{ __('lang_web.header.home') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('post', ['sub' => 'about-us']) }}" title=" Giới thiệu">
                                        {{ __('lang_web.footer.about_us') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('post', ['sub' => 'posts']) }}" title=" Tin tức truyền thông">
                                        {{ __('lang_web.header.posts') }}
                                    </a>
                                <li>
                                    <a href="{{ route('post', ['sub' => 'about-us']) }}" title=" Liên hệ">
                                        {{ __('lang_web.header.contact') }}
                                    </a>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="fixed-ele">
            {{-- <a class="hotline-btn" href="tel:0344333586" title="">
                <img class="img-fluid" src="{{ asset('images/img/hotline-btn.png') }}" alt="">
            </a> --}}
            <a class="backtop-btn" id="backTop" href="#" title="">
                <img src="{{ asset('images/img/backtotop.png') }}" alt="">
            </a>
        </div>
        <button class="chatbot-toggler">
            <span class="material-symbols-rounded fs-5 pt-1"><i class="bi bi-chat-left-text"></i></span>
            <span class="material-symbols-outlined fs-4"><i class="bi bi-x"></i></span>
        </button>
        <div class="chatbot">
            <header>
                <h2>{{ __('lang_web.footer.chat_with_us') }}</h2>
                <span class="close-btn material-symbols-outlined"><i class="bi bi-x"></i></span>
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
                <p class="btn btn-select-attachments fw-bold my-auto" onclick="document.querySelector('#chatAttachments').click()" style="color: rgb(66, 91, 237)"><i class="bi bi-paperclip"></i></p>
                <textarea name="message" id="message" placeholder="Enter a message..." spellcheck="false" required></textarea>
                <span class="material-symbols-rounded" id="send-btn"><i class="bi bi-send"></i></span>
            </div>
        </div>
    </div>
</div>
