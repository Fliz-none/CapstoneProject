<form class="save-form" id="branch_user-form" method="post">
    @csrf
    <div class="card mb-3">
        <div class="modal fade" id="branch_user-modal" aria-labelledby="branch_user-modal-label">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h1 class="modal-title fs-5 text-white" id="branch_user-modal-label">Change Branch</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <select class="form-select form-control-lg" name="branches_user" type="text">
                                @foreach (cache()->get('branches')->whereIn('id', Auth::user()->branches->pluck('id')) as $branch)
                                    <option value="{{ $branch->id }}" {{ Auth::user()->main_branch == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <hr class="px-5">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                </div>
                                <div class="col-12 col-lg-6 text-end">
                                    @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_USER)))
                                        <input name="id" type="hidden">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>