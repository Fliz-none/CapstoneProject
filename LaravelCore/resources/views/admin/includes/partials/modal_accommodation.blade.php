<div class="modal fade" id="accommodation-modal" data-bs-backdrop="static" aria-labelledby="accommodation-modal-label">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title fs-5 text-white" id="accommodation-modal-label">Phiếu lưu trú</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body section">
                <div class="row mb-3">
                    {{-- Thông tin khách hàng  --}}
                    <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                        <div class="card border h-100 mb-0">
                            <div class="card-body" style="min-height: 373px">
                                <div class="ajax-search">
                                    <label class="col-form-label fw-bold" for="accommodation-customer_search">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Thông tin khách hàng">Chọn khách hàng</span>
                                    </label>
                                    <div class="search-form">
                                        <input class="form-control customer-information search-input customer-search" id="accomoodation-customer_search" data-url="{{ route('admin.user') }}?key=search" value="" onclick="this.select()"
                                            placeholder="Tìm khách hàng" autocomplete="off">
                                    </div>
                                    <ul class="list-customer-suggest overflow-auto search-result ps-0 mt-1" style="max-height: 330px"></ul>
                                </div>
                                <div class="form-group p-2 customer-suggestions"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card border h-100 mb-0">
                            <div class="card-body">
                                <label class="col-form-label fw-bold">
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Danh sách thú cưng của khách hàng">Chọn thú cưng</span>
                                </label>
                                <div class="row overflow-auto flex-nowrap align-items-stretch pet-slider">
                                    <div class="col-6 col-md-4 my-2">
                                        <a class="btn-empty cursor-pointer">
                                            <div class="card card-image add-gallery ratio ratio-1x1 rounded-3 mb-2 h-100" style="min-height: 260px">
                                                <i class="bi bi-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="save-form" id="accommodation-form" method="post">
                    @csrf
                    <div class="card border mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h3 class="fs-6">Thông tin lưu chuồng</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="position-relative overflow-hidden">
                                        <label class="form-label">Vị trí chuồng</label>
                                        <div class="d-flex flex-nowrap shadow-sm overflow-auto px-1 scrollSlider accommodation-room-list">
                                        </div>
                                    </div>
                                </div>
                                <hr class="w-100">
                                <ul class="col-12 col-md-6 list-group accessory-list overflow-auto" style="max-height: 16.5rem;">
                                    <li class="list-group-item mb-3 border-0">
                                        <div class="row">
                                            <div class="col-7">
                                                <input class="form-control accessory-input-empty" data-input_name="name" placeholder="Vật dụng đi kèm" autocomplete="off"></input>
                                            </div>
                                            <div class="col-4 px-0">
                                                <input class="form-control accessory-input-empty" data-input_name="quantity" placeholder="Số lượng" autocomplete="offNếu tô"></input>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <a class="btn btn-remove-accessory-detail d-none text-danger fw-bold p-0">&#10006</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="col-12 col-md-6">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="accommodation-diet">Chế độ ăn uống</label>
                                            <input class="form-control" id="accommodation-diet" name="details[diet]" placeholder="Chế độ ăn uống" autocomplete="off"></input>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="accommodation-sports">Chế độ vui chơi thể thao</label>
                                            <input class="form-control" id="accommodation-sports" name="details[sports]" placeholder="Chế độ vui chơi thể thao" autocomplete="off"></input>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="accommodation-hygiene">Chế độ vệ sinh</label>
                                            <input class="form-control" id="accommodation-hygiene" name="details[hygiene]" placeholder="Chế độ vệ sinh" autocomplete="off"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="accommodation-customer_request">Yêu cầu khách hàng</label>
                                        <textarea class="form-control" id="accommodation-customer_request" name="details[customer_request]" placeholder="Yêu cầu khách hàng" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="accommodation-note">Ghi chú</label>
                                        <textarea class="form-control" id="accommodation-note" name="details[note]" placeholder="Ghi chú" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3 pe-2">
                                        <label class="form-label" for="accommodation-checkin_at">Thời gian nhận</label>
                                        <input class="form-control" id="accommodation-checkin_at" name="checkin_at" type="datetime-local">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3 pe-2">
                                        <label class="form-label" for="accommodation-estimate_checkout_at">Thời gian trả dự kiến</label>
                                        <input class="form-control" id="accommodation-estimate_checkout_at" name="estimate_checkout_at" type="datetime-local">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3 pe-2">
                                        <label class="form-label" for="accommodation-real_checkout_at">Thời gian trả thực tế</label>
                                        <input class="form-control" id="accommodation-real_checkout_at" name="real_checkout_at" type="datetime-local">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ACCOMMODATION)))
                        <div class="card border mb-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-6">
                                        <h3 class="fs-6">Thông tin theo dõi</h3>

                                    </div>
                                    <div class="col-12 col-lg-6 text-end">
                                        <a class="btn btn-outline-info ms-2 mb-3 block btn-create-tracking">
                                            <i class="bi bi-plus-circle"></i>
                                            Thêm
                                        </a>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <datalist id="accommodation-tracking-datalist"></datalist>
                                        <div class="accordion accommodation-trackings">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card border mb-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6">
                                    <h3 class="fs-6">Phiếu khám</h3>
                                </div>
                                <div class="col-12 col-lg-6 text-end">
                                    <a class="btn btn-outline-info ms-2 mb-3 block btn-create-info">
                                        <i class="bi bi-plus-circle"></i>
                                        Thêm
                                    </a>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped key-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Mã</th>
                                                    <th>Bác sĩ</th>
                                                    <th>Chẩn đoán sơ bộ</th>
                                                    <th>Các chỉ định</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="accommodation-result">Kết quả sau xử lý</label>
                                        <textarea class="form-control" id="accommodation-result" name="details[result]" placeholder="Kết quả sau xử lý" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="accommodation-advice">Lời dặn của BS</label>
                                        <textarea class="form-control" id="accommodation-advice" name="details[advice]" placeholder="Lời dặn của BS" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                    <div class="btn-group">
                                        <input class="btn-check" id="accommodation-complete" name="status" type="radio" value="0" checked>
                                        <label class="btn btn-outline-info" for="accommodation-complete">Đang ở</label>
                                        <input class="btn-check" id="accommodation-waiting" name="status" type="radio" value="1">
                                        <label class="btn btn-outline-success" for="accommodation-waiting">Đã trả</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8 text-end mb-3 mb-lg-0">
                                    <a class="btn btn-success m-1 btn-print-accommodation">
                                        <i class="bi bi-printer"></i>
                                        In phiếu
                                    </a>
                                    <a class="btn btn-outline-danger btn-preview preview-order" data-url="{{getPath(route('admin.order'))}}" data-id="">
                                        <i class="bi bi-archive"></i>
                                        Xem đơn hàng
                                    </a>
                                    <input name="pet_id" type="hidden">
                                    <input name="id" type="hidden">
                                    <button class="btn btn-info m-1 save-accommodation" type="submit">
                                        <i class="bi bi-floppy"></i>
                                        Lưu phiếu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
