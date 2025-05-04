<form class="save-form" id="animal-form" method="post">
    @csrf
    <div class="modal fade" id="animal-modal" data-bs-backdrop="static" aria-labelledby="animal-modal-label">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="animal-modal-label">Động vật</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-g">
                        <label class="form-label" for="animal-specie" data-bs-toggle="tooltip" data-bs-title="Loại động vật mà thú cưng thuộc về">Loài</label>
                        <input class="form-control" id="animal-specie" name="specie" type="text" placeholder="Nhập tên loài vật">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="animal-lineage" data-bs-toggle="tooltip" data-bs-title="Phân loại nhỏ hơn trong loài">Giống</label>
                        <input class="form-control" id="animal-lineage" name="lineage" type="text" placeholder="Nhập giống (chủng)">
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ANIMAL, App\Models\User::CREATE_ANIMAL)))
                                    <input name="id" type="hidden">
                                    <button class="btn btn-primary" type="submit">Lưu</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
