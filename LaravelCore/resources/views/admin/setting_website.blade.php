<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thiết kế - About Us</title>
    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
    <!-- Bootstrap + jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #gjs {
            height: 100vh;
        }
    </style>
    {{-- jquery --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/grapesjs"></script>
</head>

<body>
    {{-- Spinner loading --}}
    <div class="spinner-border text-primary" id="loading-spinner" role="status" style="display: none; position: fixed; top: 50%; left: 50%; z-index: 9999;">
        <span class="visually-hidden">Loading...</span>
    </div>
    <div id="gjs">
        @include('web.about-us', ['pageName' => 'Thiết kế - About Us'])
    </div>

    <div id="blocks"></div>

    <style>
        .wrapper-container {
            height: 100px;
            background-color: green;
            display: flex;
            justify-content: center;
        }

        .wrapper-container:hover {
            content: "Bao quanh";
            color: red;
            background-color: yellow;
        }
    </style>
    <script>
        const editor = grapesjs.init({
            container: '#gjs',
            fromElement: true,
            height: '100%',
            storageManager: false,
            canvas: {
                scripts: [],
                styles: [],
                scriptsTimeout: 5000,
                allowScripts: true
            }
        });

        // Thêm các block Bootstrap
        editor.BlockManager.add('btn', {
            label: 'Nút Bootstrap',
            category: 'Bootstrap',
            content: '<button class="key-btn-dark">Nhấn vào tôi</button>'
        });

        editor.BlockManager.add('alert', {
            label: 'Cảnh báo',
            category: 'Bootstrap',
            content: '<div class="alert alert-warning" role="alert">Thông báo Bootstrap!</div>'
        });

        editor.BlockManager.add('card', {
            label: 'Thẻ Bootstrap',
            category: 'Bootstrap',
            content: `
                <div class="card" style="width: 18rem;">
                    <img src="https://via.placeholder.com/300x150" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Tiêu đề</h5>
                        <p class="card-text">Mô tả nội dung trong thẻ.</p>
                        <a href="#" class="btn btn-primary">Hành động</a>
                    </div>
                </div>
            `
        });

        // Thêm các block cơ bản (có thể bao quanh card)
        editor.BlockManager.add('wrapper', {
            label: 'Bao quanh',
            category: 'Cơ bản',
            content: '<div class="container gap-2 wrapper-container"></div>'
        });

        editor.BlockManager.add('image', {
            label: 'Hình ảnh',
            category: 'Cơ bản',
            content: '<img src="https://via.placeholder.com/300x150" alt="Hình ảnh">'
        });

        editor.BlockManager.add('heading', {
            label: 'Tiêu đề',
            category: 'Cơ bản',
            content: '<h2 class="text-center">Tiêu đề chỉnh sửa</h2>'
        });

        editor.BlockManager.add('text', {
            label: 'Đoạn văn',
            category: 'Cơ bản',
            content: '<p>Đây là đoạn văn bản có thể chỉnh sửa.</p>'
        });

        // Thêm nút lưu và nút thoát vào Panels
        editor.Panels.addButton('options', [{
            id: 'save-button',
            className: 'fa fa-save',
            label: '',
            command: 'save',
            attributes: {
                title: 'Lưu'
            }
        }]);

        editor.Commands.add('save', {
            run(editor, sender) {
                sender && sender.set('active', false);
                $('#loading-spinner').show();
                const html = editor.getHtml();
                const css = editor.getCss();
                const title = $('title').text();
                $.ajax({
                    url: `{{ route('admin.setting.website') }}`,
                    method: 'POST',
                    data: {
                        html: html,
                        css: css,
                        title: title,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#loading-spinner').hide(); 
                        alert(response.msg ?? '✅ Lưu thành công!');
                    },
                    error: function(xhr, status, error) {
                        $('#loading-spinner').hide(); 
                        alert(error);
                    }
                });
            }
        });

        editor.Panels.addButton('options', [{
            id: 'exit-button',
            className: 'fa fa-times',
            label: '',
            command: 'exit',
            attributes: {
                title: 'Thoát'
            }
        }]);

        editor.Commands.add('exit', {
            run(editor, sender) {
                sender && sender.set('active', false);
                if (confirm('Bạn có chắc chắn muốn thoát không? Mọi thay đổi chưa lưu sẽ mất.')) {
                    window.location.href = "{{ route('admin.setting') }}";
                }
            }
        });

        editor.Panels.addButton('options', [{
            id: 'open-custom-modal',
            className: 'fa fa-plus',
            label: '',
            command: 'open-custom-modal',
            attributes: {
                title: 'Mở modal cấu hình'
            }
        }]);

        editor.Commands.add('open-custom-modal', {
            run() {
                const modalHtml = `
            <div class="modal fade" id="myCustomModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Phần tử tùy chỉnh</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="html-input" class="fw-semibold">Dán hoặc nhập HTML phần tử vào đây</label>
                            <textarea class="form-control" id="html-input" rows="3"></textarea>
                            <label for="css-input" class="fw-semibold mt-2">Dán hoặc nhập CSS phần tử vào đây</label>
                            <textarea class="form-control" id="css-input" rows="3"></textarea>
                            <label for="js-input" class="fw-semibold mt-2">Dán hoặc nhập JS phần tử vào đây</label>
                            <textarea class="form-control" id="js-input" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="save-custom-element" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>`;

                const wrapper = document.createElement('div');
                wrapper.innerHTML = modalHtml;
                document.body.appendChild(wrapper);

                const modal = new bootstrap.Modal(document.getElementById('myCustomModal'));
                modal.show();

                // ⚠️ GẮN SỰ KIỆN SAU KHI CHÈN VÀO DOM
                setTimeout(() => {
                    document.getElementById('save-custom-element')?.addEventListener('click', () => {
                        const html = document.getElementById('html-input')?.value || '';
                        const css = document.getElementById('css-input')?.value || '';
                        const js = document.getElementById('js-input')?.value || '';

                        // ✅ Chèn HTML vào canvas
                        if (html) {
                            editor.DomComponents.addComponent(html);
                        }

                        // ✅ Chèn CSS vào canvas
                        if (css) {
                            const cssAsset = `<style>${css}</style>`;
                            editor.CssComposer.addRules(css);
                            editor.addComponents(cssAsset); // hoặc inject thẳng nếu cần
                        }

                        // ✅ Chèn JS nếu cần
                        if (js) {
                            const iframe = editor.Canvas.getFrameEl();
                            const script = iframe.contentDocument.createElement('script');
                            script.innerHTML = js;
                            iframe.contentDocument.body.appendChild(script);
                        }

                        modal.hide();
                        alert('✅ Đã thêm phần tử tùy chỉnh!');
                    });
                }, 300); // Đợi modal render xong
            }
        });
    </script>

</body>

</html>
