@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
        <style>
            .conversations .active {
                background-color: #00b7ff17;
                /* Màu nền nhẹ để highlight */
                border-left: 4px solid #0d6efd;
                /* Viền trái nổi bật */
                transition: background-color 0.3s ease;
            }

            .conversations li:hover {
                background-color: #00b7ff17;
                /* Màu khi hover */
                cursor: pointer;
            }

            .bg-chat-primary {
                background-color: #00b7ff17 !important;
            }
        </style>
        <button id="toggle-fullscreen" class="btn btn-sm btn-outline-primary float-end">
            <i class="bi bi-arrows-fullscreen"></i>
        </button>
        <section>
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-6 col-lg-5 col-xl-4 mb-lg-4 mb-md-0">
                        <h5 class="font-weight-bold mb-3 text-center text-lg-start">Conversations</h5>
                        <div class="card">
                            <div class="card-body d-flex flex-column" style="height: 100vh;">
                                <!-- Input search: cố định -->
                                <div class="form-outline position-relative p-0 mb-3">
                                    <i class="bi bi-search position-absolute"
                                        style="top: 45%; left: 10px; transform: translateY(-50%); z-index: 2;"></i>
                                    <input type="search" id="search" class="form-control ps-5"
                                        placeholder="Search conversations..." />
                                </div>

                                <!-- Danh sách conversations-->
                                <div class="flex-grow-1 overflow-auto">
                                    <ul class="list-unstyled mb-0 conversations"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-7 col-xl-8 pt-xl-5 rounded d-flex flex-column" style="height: 100vh;">
                        <div class="flex-grow-1 overflow-auto messages-container" style="background: #f1f3f6;">
                            <ul class="list-unstyled mb-0 messages px-3 pt-3">
                                <!-- JS append messages here -->
                            </ul>
                        </div>
                        <form id="send-message" class="border-top bg-white p-2" enctype="multipart/form-data">
                            @csrf
                            <!-- Dòng icon trên đầu -->
                            <div class="d-flex align-items-center gap-2 mb-2 px-2">
                                <button type="button" class="btn btn-link text-muted p-1" title="Emoji">
                                    <i class="bi bi-emoji-smile fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-link text-muted p-1" title="Hình ảnh">
                                    <i class="bi bi-image fs-5"></i>
                                </button>
                                <label for="attachment" class="btn btn-link text-muted p-1 m-0" title="Tệp đính kèm">
                                    <i class="bi bi-paperclip fs-5"></i>
                                </label>
                                <input type="file" id="attachment" name="attachment" class="d-none" />
                                <!-- Thêm các icon khác nếu cần -->
                            </div>

                            <!-- Textarea + nút gửi -->
                            <div class="d-flex align-items-end gap-2 px-3 pb-3">
                                <textarea class="form-control border-0 rounded-3 bg-light px-3 py-2" id="message" name="message" rows="2"
                                    placeholder="Nhập @, tin nhắn tới..." style="resize: none;"></textarea>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/pusher.min.js') }}"></script>
    <script>
        let conversationId = null;
        let offset = 0;
        let loading = false;

        function loadConversations(keyword = '', active_id = false) {
            $.get(`{{ route('admin.chat', ['key' => 'conversations']) }}`, {
                search: keyword,
                active_id: active_id
            }, function(html) {
                $('.conversations').html(html);

                const first = $('.conversations li').first();
                if (first.length > 0 && !conversationId) {
                    first.addClass('active');
                    conversationId = first.data('conversation_id');
                    offset = 0;
                    loadMessages(true);
                }
            });
        }

        function loadMessages(reset = false) {
            if (loading || !conversationId) return;
            loading = true;

            $.get(`{{ route('admin.chat', ['key' => 'messages']) }}`, {
                conversation_id: conversationId,
                offset: offset
            }, function(html) {
                const container = $('.messages-container');
                const messageList = $('.messages');

                if (reset) {
                    messageList.html(html);
                    offset = 20;
                    requestAnimationFrame(() => {
                        container.scrollTop(container[0].scrollHeight);
                    });
                } else {
                    const scrollPos = container[0].scrollHeight;
                    messageList.prepend(html);
                    offset += 20;
                    container.scrollTop(container[0].scrollHeight - scrollPos);
                }

                loading = false;
            });
        }

        function toggleFullscreen() {
            const el = document.documentElement;
            if (!document.fullscreenElement) {
                el.requestFullscreen?.() || el.webkitRequestFullscreen?.() || el.mozRequestFullScreen?.() || el
                    .msRequestFullscreen?.();
            } else {
                document.exitFullscreen?.() || document.webkitExitFullscreen?.() || document.mozCancelFullScreen?.() ||
                    document.msExitFullscreen?.();
            }
        }

        function updateFullscreenButton() {
            const isFull = document.fullscreenElement || document.webkitFullscreenElement || document
                .mozFullScreenElement || document.msFullscreenElement;
            const $btn = $('#toggle-fullscreen');
            $btn.html(isFull ? '<i class="bi bi-fullscreen-exit"></i>' : '<i class="bi bi-arrows-fullscreen"></i>');
        }

        $(document).ready(function() {
            loadConversations();

            //Search
            $('#search').on('input', function() {
                const keyword = $(this).val();
                loadConversations(keyword);
            });

            // Click chọn conversation
            $(document).on('click', '.conversations li', function() {
                conversationId = $(this).data('conversation_id');
                offset = 0;
                loadMessages(true);
                loadConversations('', conversationId);
            });

            // Scroll để load thêm tin nhắn
            $('.messages-container').on('scroll', function() {
                if ($(this).scrollTop() === 0) {
                    loadMessages(false);
                }
            });

            // Gửi tin nhắn
            $('#send-message').on('submit', function(e) {
                e.preventDefault();
                if (!conversationId) return;

                const message = $('#message').val();
                if (!message.trim()) return;

                $.post("{{ route('pusher.broadcast') }}", {
                    message: message,
                    conversation_id: conversationId,
                    _token: '{{ csrf_token() }}'
                }, function() {
                    $('#message').val('').focus();
                    $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
                });
            });

            // Enter để gửi
            $('#message').on('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    $('#send-message').submit();
                }
            });

            // Toàn màn hình
            $('#toggle-fullscreen').on('click', function() {
                toggleFullscreen();
            });

            $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange',
                function() {
                    updateFullscreenButton();
                });
        });

        // Pusher config
        const pusher = new Pusher(@json(config('broadcasting.connections.pusher.key')), {
            cluster: @json(config('broadcasting.connections.pusher.options.cluster')),
            encrypted: true
        });

        const channel = pusher.subscribe('public');
        const auth_id = @json(auth()->id());

        channel.bind('pusher:subscription_succeeded', function() {
            console.log('✅ Subscribed to Pusher channel.');
        });

        channel.bind('chat', function(data) {
            if (data.conversation_id !== conversationId) {
                loadConversations('', conversationId);
                return;
            } else {
                loadConversations('', data.conversation_id);
                const html = auth_id == data.sender_id ? data.broadcast : data.receive;
                $('.messages').append(html);
                $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
            }
        });
    </script>
@endpush
