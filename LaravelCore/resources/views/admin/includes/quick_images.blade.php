<!-- Quick Images -->
<div class="card mb-0">
    <div class="card-header">
        @if (!empty(Auth::user()->can(App\Models\User::CREATE_IMAGE)))
            <a class="btn btn-primary btn-upload-quick_images cursor-pointer" type="button">
                <i class="bi bi-plus-circle-dotted"></i> Add
            </a>
        @endif
        @if (!empty(Auth::user()->can(App\Models\User::DELETE_IMAGES)))
            <a class="btn btn-danger btn-delete-images ms-2 d-none" type="button">
                <i class="bi bi-trash"></i> Delete
            </a>
        @endif
    </div>
    <div class="card-body">
        @if (!empty(Auth::user()->can(App\Models\User::CREATE_IMAGE)))
            <div id="quick_images-dropzone">
                <i class="bi bi-cloud-upload position-absolute fs-2"></i>
                <input id="quick_images-input" name="images[]" type="file" accept="image/*" multiple>
            </div>
            <div id="quick_images-progress">
                <div class="quick_images-progress-bar" id="quick_images-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        @endif
        @if (!empty(Auth::user()->can(App\Models\User::READ_IMAGES)))
            <form id="quick_images-form" method="post">
                @csrf
                <table class="display" id="quick_images-table" style="display: none;" cellspacing="0" width="100%"></table>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-insert-images d-none" type="button">Add image</button>
                    <button class="btn btn-primary btn-select-images d-none" type="button">Select images</button>
                </div>
            </form>
        @else
            @include('admin.includes.access_denied')
        @endif
    </div>
</div>
<!-- END Quick Images -->

@push('quick_images')
    <script src="{{ asset('admin/js/quick_images.js') }}?v={{ cache()->get('version')->name }}"></script>
    <script type="text/javascript">
        /**
         * IMAGE DATATABLE
         */

        $('body').on('shown.bs.modal', '#quick_images-modal', function() {
            showQuickImages()
        })

        // $('#quick_images-table').on('destroy.dt', function(e, settings) {
        //     setTimeout(() => {
        //         $('#quick_images-grid-view').remove()
        //         $('#quick_images-table').empty().after('<div class="row quick_images-grid-view" id="quick_images-grid-view"> </div>');
        //     }, 1000);
        // });

        function showQuickImages() {
            const table = $('#quick_images-table').DataTable({
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.image') }}`,
                },
                columns: [{
                    data: "id",
                    name: 'id'
                }, {
                    data: "name",
                    name: 'name'
                }, {
                    data: "caption",
                    name: 'caption'
                }, {
                    data: "alt",
                    name: 'alt'
                }, {
                    data: "author",
                    name: 'author'
                }, {
                    data: "link",
                    name: 'link'
                }, {
                    data: "created_at",
                    name: 'created_at'
                }],
                initComplete: function(settings, json) {
                    // show new container for data
                    // $('#quick_images-grid-view').insertBefore('#quick_images-table');
                    // $('#quick_images-grid-view').show();
                },
                rowCallback: function(row, data) {
                    let text = `<div class="col-6 col-md-3 col-lg-2 my-2">
                        <input class="d-none quick_images-choice" type="checkbox" value="${data.id}" data-name="${data.name}" id="image-${data.id}" name="choices[]" />
                        <label for="image-${data.id}" class="d-block choice-label">
                        <div class="card card-image mb-0">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_IMAGE)))
                        <form action="{{ route('admin.image.delete') }}" method="post" class="save-form">
                            @csrf
                            <input type="hidden" name="choices[]" value="${data.id}">
                            <button type="submit" class="btn-close btn-delete-image" aria-label="Close">
                            </button>
                        </form>
                        @endif
                                <div class="ratio ratio-1x1">
                                    <img src="${data.link}" class="card-img-top object-fit-cover p-1" alt="${(data.alt) ? data.alt : ''}">
                                </div>
                                <div class="p-3">
                                    <h6 class="card-title fs-6" data-bs-toggle="tooltip" data-bs-title="${data.name}">${data.name}</h6>
                                    {{-- <p class="card-text">${(data.caption) ? data.caption : ''}</p> --}}
                                    {{-- <p class="card-text"><small class="text-body-secondary">${(data.alt) ? data.alt : ''}</small></p> --}}
                                    <div class="row justify-content-between">
                                        <div class="col-auto card-text mb-0 me-3"><small class="text-body-secondary">${(data.author) ? data.author.name : ''}</small></div>
                                        <div class="col-auto card-text mb-0"><small class="text-body-secondary">${(data.created_at) ? moment(data.created_at).format('DD/MM/YY HH:mm') : ''}</small></div>
                                    </div>
                                    {{-- <div class="row justify-content-between">
                                        <div class="col-auto card-text mb-0 me-3"><small class="text-body-secondary">${(data.size) ? data.size : ''}</small></div>
                                        <div class="col-auto card-text mb-0"><small class="text-body-secondary">${(data.dimension) ? data.dimension : ''}</small></div>
                                    </div> --}}
                                </div>
                            @if (!empty(Auth::user()->can(App\Models\User::READ_IMAGE)))
                            <div class="d-grid">
                                <a class="btn btn-link text-decoration-none btn-sm btn-update-image" data-id="${data.id}">View details</a>
                            </div>
                            @endif
                            </div>
                        </label>
                    </div>`
                    $('#quick_images-grid-view').append(text)
                },
                preDrawCallback: function(settings) {
                    $('.quick_images-grid-view').remove()
                    $('#quick_images-table').empty().after('<div class="row quick_images-grid-view" id="quick_images-grid-view"> </div>');
                },
                language: config.datatable.lang,
                pageLength: 24,
                aLengthMenu: [
                    [6, 12, 24, 48],
                    [6, 12, 24, 48]
                ],
                order: [
                    [0, 'DESC']
                ],
            });
        }
    </script>
@endpush
