<form class="save-form" id="role-form" method="post">
    @csrf
    <div class="modal fade text-left" id="role-modal" role="dialog" aria-labelledby="role-modal-label">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header key-bg-primary">
                    <h4 class="modal-title white">Role Details</h4>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="col-form-label text-md-end fw-bold fs-5" data-bs-toggle="tooltip" data-bs-title="Name used to identify the user's permissions and responsibilities in the system" for="role-name">Role name</label>
                        </div>
                        <div class="col-md-9">
                            <input class="form-control" id="role-name" name="name" type="text" required autocomplete="off" placeholder="Please enter role name" value="">
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $permissions = cache()->get('spatie.permission.cache')['permissions'] ?? [];
                            $sections = collect($permissions)->groupBy('d')->map(function ($group, $title) {
                                $html = "<div class='col-12 col-lg-4 col-md-6 mb-4 permission-section'>";
                                $html .= "
                                <fieldset>
                                    <div class='d-flex'>
                                        <div class='form-check form-switch d-flex align-items-center'>
                                            <input class='form-check-input permissions h6 me-3' id='permissions-{$group[0]['a']}' type='checkbox' role='switch'>
                                        </div>
                                        <legend>
                                            <label class='form-check-label' for='permissions-{$group[0]['a']}'>{$title}</label>
                                        </legend>
                                    </div>";

                                $group->each(function ($item) use (&$html) {
                                    $html .= "
                                        <div class='form-check form-switch'>
                                            <input class='form-check-input permission' id='permission-{$item['a']}' name='permissions[]' type='checkbox' value='{$item['a']}' role='switch'>
                                            <label class='form-check-label' for='permission-{$item['a']}'>{$item['b']}</label>
                                        </div>";
                                });

                                $html .= "</fieldset></div>";
                                return $html;
                            })->join('');
                        @endphp
                        {!! $sections !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" type="hidden" value="">
                    @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ROLE, App\Models\User::CREATE_ROLE)))
                        <input name="id" type="hidden">
                        <button class="btn btn-primary" id="role-submit" type="submit">Save</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
