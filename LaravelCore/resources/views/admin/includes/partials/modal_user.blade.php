<form class="save-form" id="user-form" method="post">
    @csrf
    <div class="modal fade" id="user-modal" data-bs-backdrop="static" aria-labelledby="user-modal-label">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="user-modal-label">Account</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="sticky-top">
                                <label class="form-label ratio ratio-1x1 select-avatar" for="user-avatar">
                                    <img class="img-fluid rounded-4 object-fit-cover" id="user-avatar-preview" src="{{ asset('admin/images/placeholder.webp') }}" alt="Avatar">
                                </label>
                                <input class="d-none" id="user-avatar" name="avatar" type="file" multiple accept="image/*">
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Remove</button>
                                </div>
                                <hr>
                                <div class="d-grid">
                                    <a class="btn btn-outline-primary btn-customer_orders">All Orders</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="User's common name" for="user-name">Full Name</label>
                                <input class="form-control" id="user-name" name="name" type="text" placeholder="Display name" autocomplete="off" required>
                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="User's phone number" for="user-phone">Phone</label>
                                <input class="form-control" id="user-phone" name="phone" type="text" placeholder="Phone number" autocomplete="off" inputmode="numeric">
                            </div>
                            <div class="pt-2 row align-items-center">
                                <div class="col-12 btn-group pb-3">
                                    <input class="btn-check" id="gender-male" name="gender" type="radio" value="0">
                                    <label class="btn btn-outline-primary" for="gender-male">Male</label>
                                    <input class="btn-check" id="gender-female" name="gender" type="radio" value="1">
                                    <label class="btn btn-outline-primary" for="gender-female">Female</label>
                                    <input class="btn-check" id="gender-other" name="gender" type="radio" value="2">
                                    <label class="btn btn-outline-primary" for="gender-other">Other</label>
                                </div>
                                <div class="pt-2 row align-items-center form-group">
                                    <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="User's address" for="user-local_city">Address</label>
                                    <div class="mb-4">
                                        <input class="form-control" id="user-address" name="address" type="text" autocomplete="off" placeholder="Enter specific address">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <select class="form-control select2" id="user-local_city" name="local_city" data-ajax--url="{{ route('admin.local', ['key' => 'cities']) }}" data-placeholder="Select a city / province"
                                            autocomplete="off"></select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <select class="form-control select2" id="user-local_id" name="local_id" data-ajax--url="{{ route('admin.local', ['key' => 'districts']) }}" data-placeholder="Select a district"
                                            autocomplete="off"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="user-more">
                                <div class="mb-3 form-group">
                                    <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="Email used to log in" for="user-email">Email</label>
                                    <input class="form-control" id="user-email" name="email" type="email" placeholder="User email" autocomplete="off" inputmode="email">
                                </div>
                                <div class="mb-3 form-group">
                                    <label class="col-form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="User's date of birth" for="user-birthday">Birthday</label>
                                    <input class="form-control" id="user-birthday" name="birthday" type="date" max="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                </div>
                                <div class="mb-3 form-group">
                                    <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="Notes for memory aid" for="user-note">Note</label>
                                    <textarea class="form-control" id="user-note" name="note" rows="2" placeholder="Enter note content" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#user-more" aria-expanded="false" aria-controls="user-more">
                                More Information
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="user-status" name="status" type="checkbox">
                                    <label class="form-check-label" data-bs-toggle="tooltip" data-bs-title="Account status can be changed later" for="user-status">Active</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_USER, App\Models\User::CREATE_USER)))
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
</form>

<form class="save-form" id="user_role-form" method="post">
    @csrf
    <div class="card mb-3">
        <div class="modal fade" id="user_role-modal" aria-labelledby="user_role-modal-label">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h1 class="modal-title fs-5 text-white" id="user_role-modal-label"></h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body overflow-auto row justify-content-center">
                        <div class="col-12 col-md-4">
                            <div class="form-group search-container">
                                <label class="form-label fw-bolder d-flex align-items-center mb-0" data-bs-toggle="tooltip" data-bs-title="Select the user's role" for="role-search-input">Role</label>
                                <input class="form-control search-input" id="role-search-input" placeholder="Enter keyword to search">
                            </div>
                            <div class="search-item overflow-auto h-100" id="roles-check">
                                <ul class="list-group search-list">
                                    @foreach (cache()->get('roles') as $id => $roleName)
                                        <li class="list-group-item border border-0 pb-0">
                                            <input class="form-check-input me-1" id="role-{{ $id }}" name="role_id[]" type="checkbox" value="{{ $id }}">
                                            <label class="form-check-label" for="role-{{ $id }}">{{ $roleName }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group search-container">
                                <label class="form-label fw-bolder d-flex align-items-center mb-0" data-bs-toggle="tooltip" data-bs-title="Select the warehouses the user manages" for="warehouse-search-input">Warehouse</label>
                                <input class="form-control search-input" id="warehouse-search-input" placeholder="Enter keyword to search">
                            </div>
                            <div class="search-item overflow-auto h-100" id="warehouses-check">
                                <ul class="list-group search-list">
                                    @foreach (cache()->get('warehouses') as $warehouse)
                                        <li class="list-group-item border border-0 pb-0">
                                            <input class="form-check-input me-1" id="warehouse-{{ $warehouse->id }}" name="warehouse_id[]" type="checkbox" value="{{ $warehouse->id }}">
                                            <label class="form-check-label d-inline" for="warehouse-{{ $warehouse->id }}">{{ $warehouse->name }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group search-container">
                                <label class="form-label fw-bolder d-flex align-items-center mb-0" data-bs-toggle="tooltip" data-bs-title="Select the branches the user manages" for="branch-search-input">Branch</label>
                                <input class="form-control search-input" id="branch-search-input" placeholder="Enter keyword to search">
                            </div>
                            <div class="search-item overflow-auto h-100" id="branches-check">
                                <ul class="list-group search-list">
                                    @foreach (cache()->get('branches') as $branch)
                                        <li class="list-group-item border border-0 pb-0">
                                            <input class="form-check-input me-1" id="branch-{{ $branch->id }}" name="branch_id[]" type="checkbox" value="{{ $branch->id }}">
                                            <label class="form-check-label d-inline" for="branch-{{ $branch->id }}">{{ $branch->name }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
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

<form class="save-form" id="user_password-form" method="post">
    @csrf
    <div class="card mb-3">
        <div class="modal fade" id="user_password-modal" aria-labelledby="user_password-modal-label">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h1 class="modal-title fs-5 text-white" id="user_password-modal-label">Set Password</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="user_password-password">New Password</label>
                            <input class="form-control" id="user_password-password" name="password" type="text">
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

<div class="modal fade" id="self-schedule-modal" data-bs-backdrop="static" aria-labelledby="self-schedule-modal-label">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title fs-5 text-white" id="self-schedule-modal-label">Work Schedule Registration</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover key-table text-nowrap" id="self-schedule-table">
                        <thead>
                        </thead>
                        <tbody>
                            @php
                                $work_info = json_decode(cache()->get('settings')['work_info']) ?? [];
                                unset($work_info->allow_self_register); // Remove 'allow_self_register' field
                                $user = Auth::user();
                            @endphp
                            <tr>
                                <td>
                                    <a class="btn text-primary text-start p-0">{{ $user->name }}</a><br>
                                    <small>{{ $user->getRoleNames()->first() }}</small><br>
                                    <a class="cursor-pointer btn-sm btn-update-user text-primary px-0 fw-bold" data-id="{{ $user->id }}">{{ $user->code }}</a>
                                </td>
                                @for ($i = 0; $i < 7; $i++)
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            @foreach ($work_info as $index => $work)
                                                <input class="btn-check btn-change-schedule {{ $user->main_branch }}-{{ $user->id }}-{{ $index }}-{{ $i }}"
                                                    id="self-schedule-{{ $user->main_branch }}-{{ $user->id }}-{{ $index }}-{{ $i }}" data-user_id="{{ $user->id }}" data-main_branch="{{ $user->main_branch }}"
                                                    data-shift="{{ $work->sign_checkin }}-{{ $work->sign_checkout }}" data-date="{{ $i }}" data-branch_id="{{ $user->main_branch }}" type="checkbox">
                                                <label class="btn p-1 px-2 btn-outline-info shadow-none" data-bs-toggle="tooltip" data-bs-title="{{ $work->shift_name . ' (' . $work->sign_checkin . ' - ' . $work->sign_checkout . ')' }}"
                                                    for="self-schedule-{{ $user->main_branch }}-{{ $user->id }}-{{ $index }}-{{ $i }}">S{{ $index + 1 }}</label>
                                            @endforeach
                                        </div>
                                    </td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

