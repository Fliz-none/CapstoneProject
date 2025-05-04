$(document).ready(function () {
    const dropArea = document.getElementById('quick_images-dropzone');
    const imageInput = document.getElementById('quick_images-input');

    // Prevent default drag behaviors
    ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Show drop area when item is dragged over the document
    ;['dragenter', 'dragover'].forEach(eventName => {
        document.body.addEventListener(eventName, showDropArea, false);
    });

    // Hide drop area when item is dragged away from the document or dropped
    ;['dragleave', 'drop'].forEach(eventName => {
        document.body.addEventListener(eventName, hideDropArea, false);
    });

    // Handle dropped files
    if(dropArea && imageInput) {
        dropArea.addEventListener('drop', handleDrop, false);
        imageInput.addEventListener('change', handleFiles, false);
    
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
    
        function showDropArea() {
            dropArea.style.display = 'block';
        }
    
        function hideDropArea() {
            setTimeout(() => {
                dropArea.style.display = 'none';
            }, 10000);
        }
    
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles({ target: { files } });
            hideDropArea();
        }
    
        function handleFiles(event) {
            const files = event.target.files;
            if (files.length > 0) {
                let totalFiles = files.length;
                let processedFiles = 0;
                let uploadedFiles = 0;
    
                Array.from(files).forEach(file => {
                    new Compressor(file, {
                        quality: 0.8,
                        maxWidth: 800,
                        maxHeight: 800,
                        success(result) {
                            // Fix: Preserve original file name and type
                            const fileName = file.name;
                            const fileType = file.type;
                            const blob = result.slice(0, result.size, fileType);
                            const newFile = new File([blob], fileName, { type: fileType });
                            uploadImage(newFile, totalFiles);
                        },
                        error(err) {
                            console.error(err.message);
                        },
                        progress(progress) {
                            updateProgress(index, totalFiles, progress);
                        },
                    });
                });
    
                function updateProgress(index, totalFiles, progress) {
                    const percentComplete = Math.round(((index + progress) / totalFiles) * 100);
                    $('#quick_images-progress-bar').width(percentComplete + '%');
                    $('#quick_images-progress-bar').attr('aria-valuenow', percentComplete);
                }
    
                function uploadImage(file, totalFiles) {
                    const formData = new FormData();
                    formData.append('image', file);
    
                    $.ajax({
                        url: config.routes.uploadImage,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name = "csrf-token"]').attr("content"),
                        },
                        xhr: function () {
                            const xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function (evt) {
                                if (evt.lengthComputable) {
                                    const percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                    $('#quick_images-progress-bar').width(percentComplete + '%');
                                    $('#quick_images-progress-bar').attr('aria-valuenow', percentComplete);
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (response) {
                            uploadedFiles++;
                            if (uploadedFiles === totalFiles) {
                                Toastify({
                                    text: response.msg,
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: 'var(--bs-' + response.status + ')',
                                }).showToast();
                                $('#quick_images-dropzone').fadeOut();
                                $('#quick_images-progress-bar').width('0%');
                                if ($('#quick_images-table').length) {
                                    $('#quick_images-table').DataTable().clear().draw()
                                }
                            }
                        },
                        error: function (err) {
                            console.error('Upload failed:', err);
                            Toastify({
                                text: 'Upload thất bại! Hãy thử lại',
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: 'var(--bs-danger)',
                            }).showToast();
                        },
                        complete: function () {
                            processedFiles++;
                            const overallProgress = Math.round((processedFiles / totalFiles) * 100);
                            $('#quick_images-progress-bar').width(overallProgress + '%');
                            $('#quick_images-progress-bar').attr('aria-valuenow', overallProgress);
                            $('#quick_images-dropzone').fadeOut();
                        }
                    });
                }
            }
        }
    }
});

function selectFile(obj) {
    obj.querySelector('input[type="file"]').click()
}

/**
 * Xử lý cho quick_images
 */
$(".btn-upload-quick_images").click(function () {
    $("#quick_images-input").trigger("click");
});