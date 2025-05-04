@extends('admin.layouts.app')
@section('title')
{{ $pageName }}
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h5 class="text-uppercase">{{ $pageName }}</h5>
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6">
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                {{-- @if (!empty(Auth::user()->can(App\Models\User::CREATE_BEAUTY)))
                <a class="btn btn-info mb-3 block btn-create-beauty">
                    <i class="bi bi-plus-circle"></i>
                    Thêm
                </a>
                @endif --}}
            </div>
        </div>
        <div class="card">
            @if (!empty(Auth::user()->can(App\Models\User::READ_BEAUTIES)))
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped key-table dataTable no-footer" id="beauty-table">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Thú cưng</th>
                                <th>KTV / CN</th>
                                <th>Dịch vụ</th>
                                <th class="text-center">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            <tr class="odd">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="142">SGC00142</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3219">PK03219</a><br><small>30/12/2024
                                        08:55</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="5728"><span class="text-primary">Cherry</span></a> (3.5kg) - Mèo <br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="4834"><span class="text-primary">Anh Nam</span></a> - <span
                                        class="text-info mb-0">0939819191</span></td>
                                <td>
                                    <p class="text-danger mb-0">Chưa thực hiện</p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-danger">Chưa thực hiện</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="141">SGC00141</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3204">PK03204</a><br><small>29/12/2024
                                        18:59</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="6295"><span class="text-primary">KHỞI MY</span></a> (2.5kg) - Mèo cái
                                    <i class="bi bi-x-circle-fill text-warning" data-bs-toggle="tooltip"
                                        data-bs-title="Chưa triệt sản"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="4347"><span class="text-primary">DUNG</span></a> - <span
                                        class="text-info mb-0">0932869832</span>
                                </td>
                                <td>
                                    <p class="text-danger mb-0">Chưa thực hiện</p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-danger">Chưa thực hiện</p>
                                </td>
                            </tr>
                            <tr class="odd">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="140">SGC00140</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3161">PK03161</a><br><small>29/12/2024
                                        09:21</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="6946"><span class="text-primary">bông</span></a> (6kg) - Chó đực <i
                                        class="bi bi-x-circle-fill text-warning" data-bs-toggle="tooltip"
                                        data-bs-title="Chưa thiến"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="26921"><span class="text-primary">chị Lên</span></a> - <span
                                        class="text-info mb-0">0787854179</span></td>
                                <td>
                                    <p class="text-primary cursor-pointer btn-update-user mb-0" data-id="832"><span
                                            class="text-primary">BSTY. THÁI THÀNH TÀI</span></p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="2"><span
                                            class="text-primary">TRƯƠNGDUNG PET THN</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-success">Hoàn thành</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="139">SGC00139</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3158">PK03158</a><br><small>28/12/2024
                                        19:59</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="7219"><span class="text-primary">Su</span></a> (3.3kg) - Chó đực <i
                                        class="bi bi-x-circle-fill text-warning" data-bs-toggle="tooltip"
                                        data-bs-title="Chưa thiến"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="27182"><span class="text-primary">Anh Thư</span></a> - <span
                                        class="text-info mb-0">0946792632</span></td>
                                <td>
                                    <p class="text-danger mb-0">Chưa thực hiện</p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-danger">Chưa thực hiện</p>
                                </td>
                            </tr>
                            <tr class="odd">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="138">SGC00138</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3114">PK03114</a><br><small>28/12/2024
                                        13:28</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="7208"><span class="text-primary">Chuột</span></a> (3.0kg) - Mèo đực <i
                                        class="bi bi-check-circle-fill text-primary" data-bs-toggle="tooltip"
                                        data-bs-title="Đã thiến"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="27174"><span class="text-primary">Lam</span></a> - <span
                                        class="text-info mb-0">0394731219</span></td>
                                <td>
                                    <p class="text-primary cursor-pointer btn-update-user mb-0" data-id="1611"><span
                                            class="text-primary">BSTY. NGUYỄN VIỆT CƯỜNG</span></p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-danger">Chưa thực hiện</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="137">SGC00137</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3108">PK03108</a><br><small>28/12/2024
                                        09:03</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="7197"><span class="text-primary">TINY</span></a> (2.5kg) - Chó cái <i
                                        class="bi bi-x-circle-fill text-warning" data-bs-toggle="tooltip"
                                        data-bs-title="Chưa triệt sản"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="27159"><span class="text-primary">chị LONA</span></a> - <span
                                        class="text-info mb-0">0583134269</span></td>
                                <td>
                                    <p class="text-primary cursor-pointer btn-update-user mb-0" data-id="832"><span
                                            class="text-primary">BSTY. THÁI THÀNH TÀI</span></p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="2"><span
                                            class="text-primary">TRƯƠNGDUNG PET THN</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-success">Hoàn thành</p>
                                </td>
                            </tr>
                            <tr class="odd">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="136">SGC00136</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3045">PK03045</a><br><small>27/12/2024
                                        13:50</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="7192"><span class="text-primary">Bông (Đốm)</span></a> (1.5kg) - Mèo
                                    cái <i class="bi bi-x-circle-fill text-warning" data-bs-toggle="tooltip"
                                        data-bs-title="Chưa triệt sản"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="1828"><span class="text-primary">Chú Huệ</span></a> - <span
                                        class="text-info mb-0">0939416760</span></td>
                                <td>
                                    <p class="text-danger mb-0">Chưa thực hiện</p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-danger">Chưa thực hiện</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="135">SGC00135</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/3057">PK03057</a><br><small>26/12/2024
                                        18:00</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="6621"><span class="text-primary">An</span></a> (2.7kg) - Mèo cái <i
                                        class="bi bi-x-circle-fill text-warning" data-bs-toggle="tooltip"
                                        data-bs-title="Chưa triệt sản"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="26663"><span class="text-primary">Chị Hương 586</span></a> - <span
                                        class="text-info mb-0">0932883977</span></td>
                                <td>
                                    <p class="text-danger mb-0">Chưa thực hiện</p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-danger">Chưa thực hiện</p>
                                </td>
                            </tr>
                            <tr class="odd">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="134">SGC00134</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/2989">PK02989</a><br><small>25/12/2024
                                        12:18</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="627"><span class="text-primary">Bông Gòn</span></a> (4.8kg) - Chó đực
                                    <i class="bi bi-x-circle-fill text-warning" data-bs-toggle="tooltip"
                                        data-bs-title="Chưa thiến"></i><br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="594"><span class="text-primary">Chị Lan Anh</span></a> - <span
                                        class="text-info mb-0">0939526639</span>
                                </td>
                                <td>
                                    <p class="text-primary cursor-pointer btn-update-user mb-0" data-id="1611"><span
                                            class="text-primary">BSTY. NGUYỄN VIỆT CƯỜNG</span></p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-success">Hoàn thành</p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class="sorting_1"><a
                                        class="btn btn-link text-decoration-none btn-update-beauty text-info fw-bold p-0"
                                        data-id="133">SGC00133</a><br><a
                                        class="btn btn-link text-decoration-none fw-bold p-0"
                                        href="http://petclinic.test/quantri/info/2971">PK02971</a><br><small>24/12/2024
                                        18:29</small></td>
                                <td><a class="btn btn-link text-decoration-none text-info btn-update-pet p-0"
                                        data-id="2858"><span class="text-primary">Xệ</span></a> (8kg) - Chó <br><a
                                        class="btn btn-link text-decoration-none text-info btn-update-user p-0"
                                        data-id="2841"><span class="text-primary">Chị Diễm</span></a> - <span
                                        class="text-info mb-0">0774313315</span></td>
                                <td>
                                    <p class="text-primary cursor-pointer btn-update-user mb-0" data-id="1611"><span
                                            class="text-primary">BSTY. NGUYỄN VIỆT CƯỜNG</span></p>
                                    <p class="text-primary cursor-pointer btn-update-branch mb-0" data-id="4"><span
                                            class="text-primary">PHÒNG KHÁM - 586</span></p>
                                </td>
                                <td>Combo 9B</td>
                                <td class="  text-center">
                                    <p class="badge bg-light-success">Hoàn thành</p>
                                </td>
                            </tr>
                        </tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            @include('admin.includes.access_denied')
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-update-beauty', function (e) {
            e.preventDefault();
            const form = $('#beauty-form');
            resetForm(form);
            form.find('.modal').modal('show')
        })
    })

</script>
@endpush