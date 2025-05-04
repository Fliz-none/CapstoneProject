<div class="modal fade" id="room-list-modal" data-bs-backdrop="static" aria-labelledby="room-list-modal-label">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title fs-5 text-white" id="room-list-modal-label">Danh sách chuồng</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-10">
                        @if (!empty(Auth::user()->can(App\Models\User::CREATE_ROOM)))
                            <a class="btn k-btn-info mb-3 block btn-create-room">
                                <i class="bi bi-plus-circle"></i>
                                Thêm
                            </a>
                        @endif
                    </div>
                    <div class="col-12 col-lg-2">
                        @if (Auth::user()->branches->count())
                            <select class="form-control form-control-lg form-control-plaintext bg-transparent text-start room-list-branches" required autocomplete="off">
                                <option selected hidden disabled>Chi nhánh của bạn</option>
                                @foreach (Auth::user()->branches as $branch)
                                    <option value="{{ $branch->id }}" {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row grid-view" id="grid-view"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
