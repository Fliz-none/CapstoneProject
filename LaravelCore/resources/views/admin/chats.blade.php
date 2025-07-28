@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.chat.chat_management') }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.chat.chat_management') }}</li>
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

            .bg-chat-secondary {
                background-color: #f0eff6 !important;
            }

            /* mobile ẩn sender-avatar */
            @media (max-width: 767px) {
                .sender-avatar {
                    display: none;
                }
            }
        </style>
        <button class="btn btn-sm btn-outline-primary float-end" id="toggle-fullscreen">
            <i class="bi bi-arrows-fullscreen"></i>
        </button>
        <section>
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-6 col-lg-5 col-xl-4 mb-lg-4 mb-md-0">
                        <h5 class="font-weight-bold mb-3 text-center text-lg-start">{{ __('messages.chat.conversations') }}</h5>
                        <div class="card">
                            <div class="card-body d-flex flex-column" style="height: 100vh;">
                                <!-- Input search: cố định -->
                                <div class="form-outline position-relative p-0 mb-3 gap-2 d-flex">
                                    <i class="bi bi-search position-absolute" style="top: 45%; left: 10px; transform: translateY(-50%); z-index: 2;"></i>
                                    <input class="form-control ps-5" id="search" type="search" placeholder="{{ __('messages.chat.search') }}" />
                                    <button class="btn btn-link btn-select-user-conversation text-muted px-3 ms-auto" type="button" title="Add conversation"><i class="bi bi-person-plus"></i></button>
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
                        {{-- Preview file --}}
                        <div class="gap-2" id="preview-attachments"></div>
                        <form class="border-top bg-white p-2" id="send-message" method="POST" action="{{ route('admin.chat.broadcast') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Dòng icon trên đầu -->
                            <div class="d-flex align-items-center gap-2 mb-2 px-2">
                                <button class="btn btn-link text-muted p-1" type="button" title="Emoji">
                                    <i class="bi bi-emoji-smile fs-5"></i>
                                </button>
                                <label class="btn btn-link text-muted p-1 m-0" for="attachments" title="Attachment">
                                    <i class="bi bi-paperclip fs-5"></i>
                                </label>
                                <input class="d-none" id="attachments" name="attachments[]" type="file" multiple />
                                <!-- Thêm các icon khác nếu cần -->
                            </div>
                            <!-- Textarea + nút gửi -->
                            <div class="d-flex align-items-end gap-2 px-3 pb-3">
                                <textarea class="form-control border-0 rounded-3 bg-light px-3 py-2" id="message" name="message" style="resize: none;" rows="2" placeholder="{{ __('messages.chat.@') }}"></textarea>
                                <button class="btn btn-primary" type="submit">
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
    {{-- Laravel Mix --}}
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('js/pusher.min.js') }}"></script> --}}
    <script>
        let conversationId = null;
        let offset = 0;
        let loading = false;

        function createAvatar(sender, align = 'start') {
            const avatarClass = config.canUpdateUser ? 'btn-update-user cursor-pointer' : '';
            return `<img src="${sender.avatarUrl}" alt="avatar" width="50" height="50"
            class="rounded-circle d-flex align-self-${align} shadow-1-strong ${sender.id == config.auth_id ? 'sender-avatar' : ''} ${avatarClass}"
            ${config.canUpdateUser ? `data-id="${sender.id}"` : ''}>`;
        }

        function renderAttachment(attachment) {
            const isImage = attachment.mime_type.startsWith('image/');
            return isImage ?
                `<img src="${attachment.file_url}" alt="attachment" class="rounded border ratio-1-1 object-fit-cover thumb img-fluid">` :
                `<a href="${attachment.file_url}" target="_blank"
                class="text-decoration-none text-truncate border p-1 d-inline-block"
                style="max-width: 150px;" title="${attachment.file_name}">
                <i class="bi bi-file-earmark-fill"></i> ${attachment.file_name}</a>`;
        }

        function renderMessage(message, type = 'receive') {
            const isSender = type === 'broadcast';
            const align = isSender ? 'end' : 'start';
            const bg = isSender ? 'bg-chat-primary' : 'bg-chat-secondary';
            const avatar = createAvatar(message.sender, isSender ? 'end' : 'start');
            let html = '';
            if (message.attachments && message.attachments.length > 0) {
                message.attachments.forEach(att => {
                    const fileBlock = renderAttachment(att);
                    html += `<li class="d-flex justify-content-${align} mb-1">
                        <div style="max-width: 50%; width: fit-content;" class="${isSender ? 'ms-auto' : ''}">
                            <div class="card ${bg} mb-0 cursor-pointer d-inline-block" style="border: 1px solid rgba(133, 133, 244, 0.841)">
                                <div class="card-body p-1">
                                    <div class="d-flex flex-wrap gap-2">
                                        ${fileBlock}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>`;
                });
            }

            html += `<li class="d-flex justify-content-${align} mb-4">
                    ${!isSender ? avatar : ''}
                    <div style="max-width: 50%; width: fit-content;" class="${isSender ? 'me-3' : ''}">
                        <div class="card mb-0 cursor-pointer ${bg}">
                            <div class="card-header d-flex justify-content-between px-3 py-1 ${bg}">
                                <p class="mb-0">${message.sender.name}</p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0 p-1">${message.content}</p>
                            </div>
                        </div>
                        <small class="text-muted ${isSender ? 'ms-3 float-end' : 'me-3 float-start'} mt-1 d-block">
                            <i class="bi bi-clock"></i> ${moment(message.created_at).fromNow()}
                        </small>
                    </div>
                    ${isSender ? avatar : ''}
                </li>`;
            return html;
        }

        function previewAttachments(files) {
            const previewContainer = $('#preview-attachments');
            previewContainer.empty();
            for (const file of files) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img =
                            `<img src="${e.target.result}" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">`;
                        previewContainer.append(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.append(`<a class="border px-2 bg-light align-items-end">${file.name}</a>`);
                }
            }
        }

        function updateFullscreenButton() {
            const isFull = document.fullscreenElement || document.webkitFullscreenElement ||
                document.mozFullScreenElement || document.msFullscreenElement;
            $('#toggle-fullscreen').html(isFull ?
                '<i class="bi bi-fullscreen-exit"></i>' :
                '<i class="bi bi-arrows-fullscreen"></i>');
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

        // -----------------------------
        // Core chat functions
        // -----------------------------
        function loadConversations(keyword = '', activeId = false) {
            $.get(config.routes.chat.conversations, {
                search: keyword,
                active_id: activeId
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
            $.get(config.routes.chat.messages, {
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
            }).always(() => {
                loading = false;
            });
        }

        // -----------------------------
        // Event bindings
        // -----------------------------
        function setupEventListeners() {
            $('#search').on('input', debounce(() => {
                loadConversations($('#search').val());
            }, 500));

            $(document).on('click', '.conversations li', function() {
                conversationId = $(this).data('conversation_id');
                offset = 0;
                loadMessages(true);
                loadConversations('', conversationId);
            });

            $('.messages-container').on('scroll', function() {
                if ($(this).scrollTop() == 0) loadMessages(false);
            });

            $('#send-message').on('submit', function(e) {
                e.preventDefault();
                if (!conversationId) return;

                const message = $('#message').val().trim();
                const files = $('#attachments')[0].files;
                const $form = $(this);

                if (!message && files.length === 0) return;
                if (files.length > 5) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Just upload 5 files at a time',
                        confirmButtonText: 'Close'
                    }).then(() => {
                        $('#attachments').val('');
                        $('#preview-attachments').empty();
                    });
                    return;
                }

                $form.append(`<input type="hidden" name="conversation_id" value="${conversationId}">`);
                submitForm($form).done(() => {
                    $('#message').val('');
                    $('#attachments').val('');
                    $('#preview-attachments').empty();
                    $form.find('[type="submit"]').prop('disabled', false).html(
                        '<i class="bi bi-send"></i>');
                });
            });

            $('#message').on('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    $('#send-message').submit();
                }
            });

            $('#attachments').on('change', function() {
                previewAttachments(this.files);
            });

            $('#toggle-fullscreen').on('click', toggleFullscreen);
            $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange',
                updateFullscreenButton);
        }

        // -----------------------------
        // Echo setup
        // -----------------------------
        function setupEcho() {
            window.Echo.channel('public')
                .listen('.chat', (data) => {
                    if (data.message.conversation_id !== conversationId) {
                        loadConversations('', conversationId);
                        return;
                    } else {
                        loadConversations('', data.message.conversation_id);
                        const html = config.auth_id == data.message.sender_id ?
                            renderMessage(data.message, 'broadcast') :
                            renderMessage(data.message, 'receive');
                        if (config.auth_id != data.message.sender_id) {
                            new Notification('You have a new message', {
                                body: message.content,
                                icon: '/icon.png'
                            });
                        }
                        $('.messages').append(html);
                        $('#preview-attachments').empty();
                        $('#attachments').val('');
                        $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
                    }
                });
        }

        // -----------------------------
        // Add conversation
        // -----------------------------
        $(document).on('click', '.btn-select-user-conversation', async function() {
            $(`<div class="modal fade" id="add-conversation-modal" tabindex="-1" aria-labelledby="addConversationLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h5 class="modal-title fs-5 text-white" id="addConversationLabel">Select users to start a conversation</h5></br>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3 px-3 row form-group name-user-conversation-container">
                                    <label for="name">Conversation name</label>
                                    <input type="text" class="form-control" id="conversationName" placeholder="Conversation name">
                                </div>
                                <div class="px-3 row selected-user-conversation-container">
                                </div>
                                <div class="mb-3 px-3 row form-group search-user-conversation-container">
                                    <label for="search-user-conversation">Search users</label>
                                    <input type="text" class="form-control" id="search-user-conversation" placeholder="Search users">
                                    <ul id="search-user-conversation-results" class="list-group gap-1" style="max-height: 300px; overflow-y: scroll; height: 300px;"></ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-add-conversation">Add a conversation</button>
                            </div>
                        </div>
                    </div>
                </div>
            `).prependTo('body').modal('show');
        });

        $(document).on('input', '#search-user-conversation', debounce(function() {
            const keyword = $(this).val();
            const html = getUsers(keyword);
        }, 300));

        let selected_ids = [];
        $(document).on('click', '.user-conversation-item', function() {
            if (selected_ids.length > 5) {
                Swal.fire({
                    icon: 'info',
                    title: 'Infomation',
                    text: 'You can select up to 6 users',
                    confirmButtonText: 'Close'
                });
                return;
            }
            if (!$('.selected-user-conversation-container').length) {
                selected_ids = [];
            }
            if (selected_ids.includes($(this).data('id'))) {
                return;
            };
            const html = `<div class="col-2 mb-3 selected-user-conversation-item position-relative" data-id="${$(this).data('id')}">
                            <img src="${$(this).data('avatar')}" class="rounded-circle me-2" alt="avatar" width="40" height="40">
                            <div class="pt-1">
                                <p class="text-muted text-wrap mb-0" style="font-size: 10px;">${$(this).data('name')}</p>
                            </div>
                            <button class="selected-user-conversation-item-delete" data-id="${$(this).data('id')}" title="Delete" onclick="deleteSelectedUserConversationItem(this)" type="button">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>`;
            $('.selected-user-conversation-container').append(html);
            selected_ids.push($(this).data('id'));
            $(this).remove();
        });

        function getUsers(q = '') {
            $.ajax({
                url: `{{ route('admin.user', ['key' => 'conversation']) }}`,
                data: {
                    q: q,
                    selected: selected_ids,
                },
                success: function(users) {
                    $('#search-user-conversation-results').empty();
                    $('#search-user-conversation-results').html(users.join(''));
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        $(document).on('click', '.btn-add-conversation', function() {
            $.ajax({
                url: `{{ route('admin.chat.create_conversation') }}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    selected_ids: selected_ids,
                    name: $('#conversationName').val(),
                },
                success: function(res) {
                    $('#add-conversation-modal').modal('hide');
                    loadConversations();
                    pushToastify(res.msg, 'success');
                    console.log(res);
                    
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        function deleteSelectedUserConversationItem(item) {
            $(item).parent().remove();
            selected_ids = selected_ids.filter(id => id !== $(item).data('id'));
        }
        // -----------------------------
        // Init
        // -----------------------------
        $(document).ready(function() {
            loadConversations();
            setupEventListeners();
            setupEcho();
        });
    </script>
@endpush
