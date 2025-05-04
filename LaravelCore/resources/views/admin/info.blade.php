@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.info') }}">Phiếu khám</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-lg-6"></div>
            </div>
        </div>
        <section class="section">
            @if (session('response') && session('response')['status'] == 'success')
                <div class="alert key-bg-primary alert-dismissible fade show text-white" role="alert">
                    <i class="fas fa-check"></i>
                    {!! session('response')['msg'] !!}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                    </button>
                </div>
            @elseif (session('response'))
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <i class="fa-solid fa-xmark"></i>
                    {!! session('response')['msg'] !!}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                    </button>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <i class="fa-solid fa-xmark"></i>
                    {{ $errors->first() }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                    </button>
                </div>
            @endif
            @php
                $pet = isset($info) && $info->_pet ? $info->_pet : $pet ?? null;
                $customer = isset($info) && $info->_pet ? $info->_pet->_customer : optional($pet)->_customer ?? $customer;
            @endphp
            <div class="row mb-3">
                {{-- Thông tin khách hàng  --}}
                <div class="col-12 col-lg-3 mb-3 mb-lg-0">
                    <div class="card border h-100 mb-0">
                        <div class="card-body" style="min-height: 373px">
                            <div class="ajax-search">
                                <label class="col-form-label fw-bold" for="info-customer_search">
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Thông tin khách hàng">Chọn khách hàng</span>
                                    @error('customer_id')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </label>
                                <div class="search-form">
                                    <input class="form-control customer-information search-input customer-search" id="info-customer_search" data-url="{{ route('admin.user') }}?key=search"
                                        value="{{ $customer ? $customer->name . ' - ' . $customer->phone : '' }}" onclick="this.select()" placeholder="Tìm khách hàng" autocomplete="off"
                                        @isset($info) {{ $info->_pet ? 'readonly disabled' : '' }} @endisset>
                                </div>
                                <ul class="list-customer-suggest overflow-auto search-result ps-0 mt-1" style="max-height: 330px"></ul>
                            </div>
                            <div class="form-group p-2 customer-suggestions"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="card border h-100 mb-0">
                        <div class="card-body">
                            <label class="col-form-label fw-bold">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Danh sách thú cưng của khách hàng">Chọn thú cưng</span>
                                @if (!isset($info))
                                    <button class="btn bg-white btn-refresh-list-pet ms-1 px-1 py-0" data-check="" type="button">
                                        <i class="bi bi-arrow-repeat text-primary fs-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tải lại danh sách"></i>
                                    </button>
                                @endif
                                @error('pet_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                            <div class="row overflow-auto flex-nowrap align-items-stretch pet-slider">
                                @if (isset($info) && $info->_pet)
                                    <div class="col-6 col-md-4 col-lg-3 my-2">
                                        <input class="d-none choice" id="pet-choice-{{ $pet->id }}" name="choices[]" data-name="{{ $pet->name }}" data-specie="{{ $pet->animal->specie }}" type="radio" value="{{ $pet->id }}" checked
                                            readonly>
                                        <label class="d-block choice-label h-100" for="pet-choice-{{ $pet->id }}">
                                            <div class="card card-image mb-2 h-100">
                                                <div class="ratio ratio-16x9">
                                                    <img class="card-img-top object-fit-cover p-1" src="{{ $pet->avatarUrl }}" alt="{{ $pet->name }}">
                                                </div>
                                                <div class="p-3">
                                                    <p class="card-title d-inline-block fw-bold">
                                                        <small data-bs-toggle="tooltip" data-bs-title="{{ $pet->name }}">{{ $pet->name }}</small>
                                                        <span class="badge bg-light-info">
                                                            <small>{{ $pet->animal->specie }} {{ $pet->genderStr }} {!! $pet->neuterIcon !!}</small>
                                                        </span>
                                                    </p>
                                                    <p class="text-body-secondary mb-0 fs-6"><small class="pet-age">Tuổi: {{ optional($info->_pet)->age ?? 'Không rõ' }} tháng</small></p>
                                                </div>
                                                <div class="d-grid mb-2 mt-auto">
                                                    <div class="btn-group">
                                                        <a class="btn btn-link text-decoration-none btn-update-pet btn-sm" data-id="{{ $pet->id }}">Thông tin</a>
                                                        <a class="btn btn-link text-decoration-none btn-sm" data-id="{{ $pet->id }}">Bệnh án</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @else
                                    <div class="col-6 col-md-4 col-lg-3 my-2">
                                        <a class="btn-empty cursor-pointer">
                                            <div class="card card-image add-gallery ratio ratio-1x1 rounded-3 mb-2 h-100" style="min-height: 260px">
                                                <i class="bi bi-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Info form --}}
            <form class="h-100" id="info-form" method="post" action="{{ route('admin.info.' . (isset($info) && $info->id ? 'update' : 'create')) }}">
                @csrf
                <div class="card border mb-2">
                    <div class="card-body" style="min-height: 250px">
                        <div class="row mb-4">
                            <div class="col-12 col-md-6 mb-4">
                                @php
                                    if (isset($info)) {
                                        $requirements = $info->requirements ?? [];
                                    } elseif (request('requirements')) {
                                        $requirements = [request('requirements')] ?? [];
                                    } else {
                                        $requirements = old('requirements') ?? [];
                                    }
                                    $fix_options = ['Khám bệnh', 'Cấp cứu', 'Xổ giun', 'Làm đẹp', 'Tiêm phòng', 'Lưu trú', 'Thai sản'];
                                    $other = array_diff($requirements, $fix_options);
                                @endphp
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Yêu cầu của khách hàng" for="info-requirements">
                                    Lý do đến khám
                                </label>
                                <div class="d-flex align-items-center">
                                    <div class="btn-group btn-group-column w-100">
                                        @foreach ($fix_options as $i => $option)
                                            <input class="btn-check @error('requirements') is-invalid @enderror" id="info-requirements-{{ $i }}" name="requirements[]" type="checkbox" value="{{ $option }}"
                                                {{ in_array($option, $requirements) ? 'checked' : '' }}>
                                            <label class="btn btn-outline-info mb-1" for="info-requirements-{{ $i }}">{{ $option }}</label>
                                        @endforeach
                                    </div>
                                </div>
                                <input class="form-control mt-2" id="info-requirements-other" name="requirements[]" value="{{ implode(', ', $other) }}" placeholder="Lý do khác">
                                @error('requirements')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Danh sách các bệnh đã từng được chẩn đoán trước đây" for="info-history">
                                    Bệnh sử
                                </label>
                                <textarea class="form-control @error('history') is-invalid @enderror" id="info-history" name="history" rows="3" placeholder="Bệnh sử">{{ old('history') ? old('history') : (isset($info) ? $info->history ?? '' : '') }}</textarea>
                                @error('history')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Môi trường sống của thú cưng" for="captive-environment">
                                    Môi trường sống
                                </label>
                                @php $environment = $info->environment ?? null @endphp
                                <div class="btn-group w-100">
                                    <input class="btn-check" id="captive-environment" name="environment" type="radio" value="Nuôi nhốt"
                                        {{ (old('environment') === 'Nuôi nhốt' ? 'checked' : isset($environment) && $environment == 'Nuôi nhốt') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-info" for="captive-environment">Nuôi nhốt</label>
                                    <input class="btn-check" id="free-range-environment" name="environment" type="radio" value="Nuôi thả"
                                        {{ (old('environment') === 'Nuôi thả' ? 'checked' : isset($environment) && $environment == 'Nuôi thả') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-info" for="free-range-environment">Nuôi thả</label>
                                </div>
                                @error('environment')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cân nặng hiện tại của thú cưng" for="info-weight">
                                    Cân nặng
                                </label>
                                <div class="input-group">
                                    <input class="form-control rounded-0 rounded-start @error('weight') is-invalid @enderror" id="info-weight" name="weight" type="text"
                                        value="{{ old('weight') ? old('weight') : (isset($info) ? $info->weight ?? '' : '') }}" placeholder="Nhập số thập phân" autocomplete="off">
                                    <span class="input-group-text rounded-0 rounded-end">kg</span>
                                </div>
                                @error('weight')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Nhiệt độ cơ thể hiện tại của thú cưng" for="info-temperature">
                                    Thân nhiệt
                                </label>
                                <div class="input-group">
                                    <input class="form-control rounded-0 rounded-start @error('temperature') is-invalid @enderror" id="info-temperature" name="temperature" type="text"
                                        value="{{ old('temperature') ? old('temperature') : (isset($info) ? $info->temperature ?? '' : '') }}" placeholder="Nhập số thập phân" autocomplete="off" required>
                                    <span class="input-group-text rounded-0 rounded-end">°C</span>
                                </div>
                                @error('temperature')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Các loại thức ăn thú cưng ăn hàng ngày" for="info-daily_food">
                                    Thức ăn hàng ngày
                                </label>
                                <input class="form-control rounded-0 rounded-start @error('daily_food') is-invalid @enderror" id="info-daily_food" name="daily_food" type="text"
                                    value="{{ old('daily_food') ? old('daily_food') : (isset($info) ? $info->daily_food ?? '' : '') }}" placeholder="Nhập tên thức ăn / uống" autocomplete="off" required>
                                @error('daily_food')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Liệt kê các thức ăn thú cưng đã ăn trong những ngày gần đây" for="info-recent_food">
                                    Thức ăn gần đây
                                </label>
                                <input class="form-control rounded-0 rounded-start @error('recent_food') is-invalid @enderror" id="info-recent_food" name="recent_food" type="text"
                                    value="{{ old('recent_food') ? old('recent_food') : (isset($info) ? $info->recent_food ?? '' : '') }}" placeholder="Nhập tên thức ăn / uống" autocomplete="off">
                                @error('recent_food')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Điểm tình trạng cơ thể" for="info-bcs">
                                    Điểm tầm vóc
                                </label>
                                <input class="form-control rounded-0 rounded-start @error('bcs') is-invalid @enderror" id="info-bcs" name="bcs" type="text" value="{{ old('bcs') ? old('bcs') : (isset($info) ? $info->bcs : '') }}"
                                    placeholder="Thang điểm 1-9" autocomplete="off">
                                @error('bcs')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card border shadow-none mb-3">
                            <div class="card-body overflow-auto">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-wide table-infos">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tên triệu chứng lâm sàng" style="width: 20%">
                                                    Triệu chứng
                                                    <a class="btn btn-outline-info btn-sm btn-list-symptoms" data-bs-toggle="modal" data-bs-target="#info_symptoms-modal">
                                                        <i class="bi bi-clipboard-check-fill"></i>
                                                        Quy trình chuẩn
                                                    </a>
                                                </th>
                                                <th class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Số liệu, màu sắc, chỉ số v.v..." style="width: 20%">
                                                    Mô tả biểu hiện
                                                </th>
                                                <th class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Triệu chứng này thuộc nhóm cơ quan nào, chọn một phương án" style="width: 10%">
                                                    Nhóm cơ quan
                                                </th>
                                                <th class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gợi ý bệnh liên quan đến triệu chứng này (sẽ được lưu lại để gợi ý cho các lần khám sau)">
                                                    Chẩn đoán sơ bộ
                                                </th>
                                                <th class="text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gợi ý dịch vụ để xét nghiệm tìm bệnh hoặc gợi ý thuốc điều trị triệu chứng" style="width: 18%">
                                                    Điều trị
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="info-symptoms">
                                            @php
                                                if (old('symptom_ids')) {
                                                    $symptoms = collect(old('symptom_ids'))
                                                        ->zip(old('symptom_names'), old('symptom_measures'), old('symptom_groups'), old('symptom_diseases'))
                                                        ->map(function ($item, $key) {
                                                            return (object) [
                                                                'id' => $item[0],
                                                                'name' => $item[1],
                                                                'measure' => $item[2],
                                                                'group' => $item[3],
                                                                'diseases' => $item[4],
                                                            ];
                                                        })
                                                        ->toArray();
                                                }
                                                if (!isset($symptoms) && isset($info)) {
                                                    $symptoms = json_decode($info->symptoms);
                                                }
                                            @endphp
                                            @if (isset($symptoms))
                                                @foreach ($symptoms as $i => $detail)
                                                    @php
                                                    @endphp
                                                    <tr class="info-symptom">
                                                        <td>
                                                            <input class="form-control @error('symptom_names.' . $i) is-invalid @enderror" name="symptom_names[]" type="text" value="{{ $detail->name }}" placeholder="Tên triệu chứng"
                                                                list="list-info-symptoms" autocomplete="off" onclick="this.select()">
                                                        </td>
                                                        <td>
                                                            <input class="form-control @error('symptom_measures.' . $i) is-invalid @enderror" name="symptom_measures[]" type="text" value="{{ $detail->measure }}"
                                                                placeholder="Chi tiết triệu chứng {{ $detail->name }}" autocomplete="off" onclick="this.select()">
                                                        </td>
                                                        <td>
                                                            <select class="form-select local-select @error('symptom_groups.' . $i) is-invalid @enderror" name="symptom_groups[]" placeholder="Chọn nhóm cơ quan" autocomplete="off">
                                                                @foreach (cache()->get('symptoms_' . Auth::user()->company_id)->pluck('group')->unique() as $j => $group)
                                                                    <option value="{{ $group }}" {{ $group == $detail->group ? 'selected' : '' }}>{{ $group }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select local-select tags symptom_diseases @error('symptom_diseases.' . $i) is-invalid @enderror" name="symptom_diseases[{{ $i }}][]"
                                                                placeholder="Nghi bệnh hoặc bỏ trống nếu bình thường" multiple>
                                                                @foreach (cache()->get('diseases_' . Auth::user()->company_id) as $k => $disease)
                                                                    @if (in_array($disease->name, $detail->diseases ?? []))
                                                                        <option value="{{ $disease->name }}" selected>{{ $disease->name }}</option>
                                                                        @php
                                                                            $detail->diseases = array_filter($detail->diseases ?? [], function ($item) use ($disease) {
                                                                                return $item !== $disease->name;
                                                                            });
                                                                        @endphp
                                                                    @else
                                                                        <option value="{{ $disease->name }}">{{ $disease->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                                @foreach ($detail->diseases ?? [] as $disease)
                                                                    <option value="{{ $disease }}" selected>{{ $disease }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input name="symptom_ids[]" type="hidden" value="{{ $detail->id }}" />
                                                            <div class="btn-group" role="group">
                                                                <a class="btn btn-outline-success btn-suggest-medicine align-content-center" data-name="{{ $detail->name }}" @if (isset($info)) disabled @endif>Thuốc</a>
                                                                <a class="btn btn-outline-info btn-suggest-service align-content-center" data-name="{{ $detail->name }}">Chỉ định</a>
                                                                <a class="btn btn-outline-danger btn-remove-detail align-content-center">
                                                                    <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr class="info-symptom">
                                                <td>
                                                    <input class="form-control symptom_names" type="text" placeholder="Tên triệu chứng" list="list-info-symptoms" autocomplete="off" onclick="this.select()">
                                                </td>
                                                <td>
                                                    <input class="form-control symptom_measures" type="text" placeholder="Số liệu, màu sắc, chỉ số v.v..." autocomplete="off" onclick="this.select()">
                                                </td>
                                                <td>
                                                    <select class="form-select local-select symptom_groups" placeholder="Chọn nhóm cơ quan" autocomplete="off">
                                                        @foreach (cache()->get('symptoms_' . Auth::user()->company_id)->pluck('group')->unique() as $index => $group)
                                                            <option value="{{ $group }}">{{ $group }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select local-select tags symptom_diseases" placeholder="Nghi bệnh hoặc bỏ trống nếu bình thường" size="1" multiple>
                                                        @foreach (cache()->get('diseases_' . Auth::user()->company_id) as $index => $disease)
                                                            <option value="{{ $disease->name }}">{{ $disease->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="symptom_ids" type="hidden" value="" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @if ($errors->has('symptom_ids'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('symptom_ids') }}</strong>
                                    </span>
                                @elseif ($errors->has('symptom_names'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('symptom_names') }}</strong>
                                    </span>
                                @endif
                                <datalist id="list-info-symptoms">
                                    @foreach (cache()->get('symptoms_' . Auth::user()->company_id) as $symptom)
                                        <option value="{{ $symptom->name }}">{{ $symptom->group }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="card border shadow-none mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-3">
                                        <div class="ajax-search" style="max-height: 550px">
                                            <div class="input-group mb-3 position-relative search-form">
                                                <input class="form-control search-input" id="service-select" data-url="{{ route('admin.service') }}?key=search&type=is_indicated" placeholder="Tìm kiếm dịch vụ..." autocomplete="off">
                                            </div>
                                            <div class="info-services overflow-auto" style="max-height: 250px">
                                                <ul class="list-group search-result">
                                                    @foreach (cache()->get('services_' . Auth::user()->company_id)->where('is_indicated', 1) as $service)
                                                        @php
                                                            $symptomNames = $service->symptoms->pluck('name')->implode(', ');
                                                        @endphp
                                                        <li class="list-group-item list-group-item-action cursor-pointer info-service rounded-3 border-0" data-symptom="{{ $symptomNames }}" data-price="{{ $service->price }}"
                                                            data-id="{{ $service->id }}">
                                                            {{ $service->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        @php
                                            if (isset($info) && !empty($info->indications())) {
                                                $indication_group = $info->indications();
                                            }
                                        @endphp
                                        <table class="table table-hover table-striped mb-4">
                                            <thead>
                                                <tr>
                                                    <th class="text-info">Chỉ định dịch vụ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="info-indications">
                                                @if (isset($indication_group))
                                                    @foreach ($indication_group as $indications)
                                                        @foreach ($indications as $indication)
                                                            @php
                                                                $indication->load('detail._service');
                                                                if ($indication->has_booking) {
                                                                    $class = 'btn-update-booking';
                                                                    $color = 'text-info';
                                                                    $title = 'Đã có lịch hẹn';
                                                                } else {
                                                                    $class = 'btn-create-booking';
                                                                    $color = 'text-success';
                                                                    $title = 'Chưa có lịch hẹn';
                                                                }
                                                                $booking_btn =
                                                                    '<a class="btn btn-link text-decoration-none ' .
                                                                    $class .
                                                                    '"
                                                                data-id="' .
                                                                    optional($indication->has_booking)->id .
                                                                    '"
                                                                data-service_id="' .
                                                                    $indication->detail->service_id .
                                                                    '"
                                                                data-doctor_id="' .
                                                                    $indication->info->doctor_id .
                                                                    '"
                                                                data-pet_id="' .
                                                                    $indication->info->pet_id .
                                                                    '"> <i class="bi bi-calendar-check ' .
                                                                    $color .
                                                                    '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' .
                                                                    $title .
                                                                    '"></i>
                                                                </a>';
                                                                $ticket_name = $indication->detail->_service->ticket;
                                                            @endphp
                                                            <tr id="info-service-{{ $indication->detail->service_id }}">
                                                                <td>
                                                                    {!! $indication->detail->_service->fullName !!}
                                                                    <input name="service_prices[]" type="hidden" value="{{ $indication->detail->price }}">
                                                                    <input name="service_tickets[]" type="hidden" value="{{ e($indication->detail->_service->ticket) }}">
                                                                    <input name="service_names[]" type="hidden" value="{{ e($indication->detail->_service->fullName) }}">
                                                                    <input name="service_ids[]" type="hidden" value="{{ $indication->detail->service_id }}" />
                                                                </td>
                                                                <td class="text-end">
                                                                    <input name="indication_has_booking[]" type="hidden" value="{{ optional($indication->has_booking)->id }}">
                                                                    <input name="detail_ids[]" type="hidden" value="{{ $indication->id }}" />
                                                                    @if (optional($service)->commitment_required)
                                                                        <a class="btn btn-link text-decoration-none btn-print print-commitment" data-id="{{ $detail->id }}" data-url="{{ getPath(route('admin.detail')) }}">
                                                                            <i class="bi bi-pencil-square text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="In phiếu cam kết"></i>
                                                                        </a>
                                                                    @endif
                                                                    @if ($ticket = optional($indication->detail->_service)->ticket)
                                                                        <a class="btn btn-link text-decoration-none btn-preview preview-{{ $ticket }}" data-id="{{ $indication->id }}" data-url="{{ getPath(route('admin.' . $ticket)) }}">
                                                                            <i class="bi bi-receipt-cutoff" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xem phiếu {{ $indication->detail->_service->name }}"></i>
                                                                        </a>
                                                                    @endif
                                                                    @if ($indication->id)
                                                                        @if (!$indication->detail->export_detail && $ticket_name && $ticket_name !== 'prescription')
                                                                            <a class="btn btn-link text-decoration-none btn-indication-export" data-id="{{ $indication->detail->id }}">
                                                                                <i class="icon-mid bi bi-dropbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xuất vật tư tiêu hao"></i>
                                                                            </a>
                                                                        @endif
                                                                        {!! $booking_btn !!}
                                                                        <a class="btn btn-link text-decoration-none btn-print print-indication" data-id="{{ $indication->detail->id }}" data-url="{{ getPath(route('admin.detail')) }}">
                                                                            <i class="bi bi-printer-fill text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="In phiếu chỉ định"></i>
                                                                        </a>
                                                                    @endif
                                                                @if (optional($service)->commitment_required)
                                                                    <a class="btn btn-link text-decoration-none btn-print print-commitment" data-id="{{ $detail->id }}" data-url="{{ getPath(route('admin.detail')) }}">
                                                                        <i class="bi bi-pencil-square text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="In phiếu cam kết"></i>
                                                                    </a>
                                                                @endif
                                                                    <input name="id" type="hidden" value="{{ $indication->id }}" />
                                                                    <a class="btn btn-link text-decoration-none btn-remove-detail" data-id="{{ $indication->detail->id }}" data-url="{{ getPath(route('admin.detail.remove')) }}">
                                                                        <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            @php
                                if (isset($info)) {
                                    $final_diag = $info->final_diag;
                                }
                                if (old('final_diag')) {
                                    $final_diag = old('final_diag');
                                }
                            @endphp
                            <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Chẩn đoán sau các xét nghiệm" for="info-final_diag">
                                Chẩn đoán bệnh
                            </label>
                            <button class="btn btn-link btn-sm btn-mix-disease text-decoration-none" type="button">
                                <i class="bi bi-lightning-charge-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tự động tổng hợp bệnh lý từ chẩn đoán sơ bộ"></i>
                            </button>
                            <select class="form-control local-select tags @error('final_diag') is-invalid @enderror" id="info-final_diag" name="final_diag[]" placeholder="Chẩn đoán bệnh" multiple>
                                @foreach (cache()->get('diseases_' . Auth::user()->company_id) as $k => $disease)
                                    @if (in_array($disease->name, $final_diag ?? []))
                                        <option value="{{ $disease->name }}" selected>{{ $disease->name }}</option>
                                        @php
                                            $final_diag = array_filter($final_diag ?? [], function ($item) use ($disease) {
                                                return $item !== $disease->name;
                                            });
                                        @endphp
                                    @else
                                        <option value="{{ $disease->name }}">{{ $disease->name }}</option>
                                    @endif
                                @endforeach
                                @foreach ($final_diag ?? [] as $disease)
                                    <option value="{{ $disease }}" selected>{{ $disease }}</option>
                                @endforeach
                            </select>
                            @error('final_diag')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3 mb-4">
                                @php
                                    if (isset($info) && $info->advice) {
                                        $advice = $info->advice;
                                    }
                                    if (old('advice')) {
                                        $advice = old('advice');
                                    }
                                @endphp
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hướng dẫn và lời khuyên cụ thể về chế độ ăn uống, sinh hoạt, theo dõi cho thú cưng" for="info-advice">
                                    Lời dặn của bác sĩ
                                </label>
                                <button class="btn btn-link btn-sm btn-mix-advice text-decoration-none" type="button">
                                    <i class="bi bi-lightning-charge-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tự động điền lời dặn theo chẩn đoán bệnh"></i>
                                </button>
                                <textarea class="form-control @error('advice') is-invalid @enderror" id="info-advice" name="advice" rows="6" placeholder="Lời dặn của bác sĩ">{{ $advice ?? '' }}</textarea>
                                @error('advice')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mb-4">
                                @php
                                    if (isset($info) && $info->prognosis) {
                                        $prognosis = $info->prognosis;
                                    }
                                    if (old('prognosis')) {
                                        $prognosis = old('prognosis');
                                    }
                                @endphp
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dự đoán kết quả và khả năng hồi phục" for="info-prognosis">
                                    Tiên lượng
                                </label>
                                <button class="btn btn-link btn-sm btn-mix-prognosis text-decoration-none" type="button">
                                    <i class="bi bi-lightning-charge-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tự động điền tiên lượng theo chẩn đoán bệnh"></i>
                                </button>
                                <textarea class="form-control @error('prognosis') is-invalid @enderror" id="info-prognosis" name="prognosis" rows="6" placeholder="Tiên lượng">{{ $prognosis ?? '' }}</textarea>
                                @error('prognosis')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 mb-4">
                                @php
                                    if (isset($info) && $info->treatment_plan) {
                                        $treatment_plan = $info->treatment_plan;
                                    }
                                    if (old('treatment_plan')) {
                                        $treatment_plan = old('treatment_plan');
                                    }
                                @endphp
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hướng dẫn điều trị từ bác sĩ" for="info-treatment_plan">
                                    Phác đồ điều trị bằng lời
                                </label>
                                <textarea class="form-control @error('treatment_plan') is-invalid @enderror" id="info-treatment_plan" name="treatment_plan" rows="6" placeholder="Phác đồ điều trị bằng lời">{{ $treatment_plan ?? '' }}</textarea>
                                @error('treatment_plan')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                @php
                                    if (isset($info)) {
                                        $note = $info->note;
                                    }
                                    if (old('note')) {
                                        $note = old('note');
                                    }
                                @endphp
                                <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ghi chú khám bệnh" for="info-type-clinic">
                                    Ghi chú khám
                                </label>
                                <textarea class="form-control @error('note') is-invalid @enderror" id="info-note" name="note" rows="6" placeholder="Ghi chú khám">{{ $note ?? '' }}</textarea>
                                @error('note')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer footer-fixed">
                        <div class="row">
                            <div class="col-12 col-md-3 mb-3">
                                @php
                                    $services = cache()
                                        ->get('services_' . Auth::user()->company_id)
                                        ->where('ticket', 'info');
                                @endphp
                                <select class="form-select" id="info-service_id" name="service_id">
                                    @if ($services->count())
                                        @foreach ($services as $key => $service)
                                            @php
                                                $is_selected = '';
                                                if (old('service_id') == $service->id) {
                                                    $is_selected = 'selected';
                                                } else {
                                                    if (isset($info) && optional($info)->detail->service_id == $service->id) {
                                                        $is_selected = 'selected';
                                                    } elseif (!isset($info)) {
                                                        if (cache()->get('settings_' . Auth::user()->company_id)['default_info_service'] == $service->id) {
                                                            $is_selected = 'selected';
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $service->id }}" {{ $is_selected }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('service_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('type')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <div class="d-flex align-items-center" style="height: 40px">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="info-type-clinic" name="type" type="radio" value="1" checked>
                                        <label class="form-check-label" for="info-type-clinic">
                                            Tại phòng khám
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="info-type-home" name="type" type="radio" value="2" {{ (old('type') == 2 ? 'checked' : isset($info) && $info->type == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="info-type-home">
                                            Tại nhà
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="info-type-online" name="type" type="radio" value="3" {{ (old('type') == 3 ? 'checked' : isset($info) && $info->type == 3) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="info-type-online">
                                            Online
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 mb-3">
                                <div class="text-end">
                                    @if (isset($info))
                                        <a class="btn btn-success m-1 btn-print print-info" data-id="{{ $info->id }}" data-url="{{ getPath(route('admin.info')) }}">
                                            <i class="bi bi-printer"></i>
                                            In phiếu khám
                                        </a>
                                        <a class="btn btn-outline-danger btn-preview preview-order" data-url="{{ getPath(route('admin.order')) }}" data-id="{{ $info->_detail->order_id }}">
                                            <i class="bi bi-archive"></i>
                                            Xem đơn hàng
                                        </a>
                                    @endif
                                    <input name="order_id" type="hidden" value="{{ old('order_id') ? old('order_id') : (isset($info) ? $info->_detail->order_id : request('order_id') ?? '') }}">
                                    <input name="id" type="hidden" value="{{ old('info_id') ? old('info_id') : (isset($info) ? $info->id : '') }}">
                                    <input name="pet_id" data-specie="{{ isset($info) && $info->_pet ? $pet->animal->specie : '' }}" type="hidden" value="{{ old('pet_id') ? old('pet_id') : (isset($pet) ? $pet->id : request('pet_id') ?? '') }}">
                                    <input name="customer_id" type="hidden" value="{{ old('customer_id') ? old('customer_id') : (isset($customer) ? $customer->id : request('customer_id') ?? '') }}">
                                    <button class="btn btn-info m-1 save-info" data-text='<i class="bi bi-floppy me-2"></i> Lưu phiếu khám' type="submit">
                                        <i class="bi bi-floppy"></i>
                                        Lưu phiếu khám
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            @if (isset($info) && $info->pet_id)
                <div class="card border h-100 mb-0">
                    <div class="card-body d-flex flex-column">
                        <div class="row" style="border-bottom: 1px solid #dedede !important;">
                            <div class="col-12 col-lg-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="fw-bold me-2">Chỉ định thuốc</h6>
                                    <a class="btn btn-link btn rounded-pill p-0 btn-create-prescription mb-2" type="button">
                                        <i class="bi bi-plus-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Thêm đơn thuốc"></i></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-10">
                                <ul class="nav nav-pills" id="info-prescription-tabs" role="tablist">
                                    @if (isset($info->indications()['prescriptions']))
                                        @foreach ($info->indications()['prescriptions'] as $j => $prescription)
                                            <li>
                                                <a class="nav-link btn shadow rounded-0 me-1 mb-1" data-bs-toggle="pill" data-bs-target="#info-prescription-tab-{{ $j + 1 }}">
                                                    {{ $prescription->name ? $prescription->name : $prescription->code }}
                                                    <button class="btn btn-light-primary btn-remove-prescription py-0 z-5 opacity-50 px-2 ms-2 d-none" data-id="{{ $prescription->id }}" type="button">×</button>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="info-prescription-contents">
                            @if (isset($info->indications()['prescriptions']))
                                @foreach ($info->indications()['prescriptions'] as $k => $prescription)
                                    <div class="tab-pane fade" id="info-prescription-tab-{{ $k + 1 }}">
                                        <form class="info-prescription-form" action="{{ route('admin.prescription.update') }}" method="post">
                                            @csrf
                                            <input class="form-control my-2" name="name" type="text" value="{{ $prescription->name }}" placeholder="Tên đơn thuốc" autocomplete="off">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-wide table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Tên thuốc</th>
                                                            <th>Liều dùng/lần</th>
                                                            <th>Số lần/ngày</th>
                                                            <th>Số ngày</th>
                                                            <th>Đường cấp</th>
                                                            <th>Ghi chú</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="info-medicines">
                                                        @foreach ($prescription->prescription_details as $item => $prescription_detail)
                                                            @php
                                                                $unit = $prescription_detail->_medicine->_variable->units->where('rate', 1)->first()->term;
                                                            @endphp
                                                            <tr class="medicine-row" id="info-medicine-{{ $prescription_detail->medicine_id }}">
                                                                <td class="fw-bold">
                                                                    {{ $prescription_detail->_medicine->name }}
                                                                    <input class="medicine-name" type="hidden" value="{{ $prescription_detail }}">
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input class="form-control form-control-plaintext border-bottom" name="dosages[]" value="{{ $prescription_detail->dosage }}"
                                                                            list="list-dosage-{{ $prescription_detail->_medicine->id }}" placeholder="Nhập số" autocomplete="off">
                                                                        <span class="input-group-text">{{ $unit }}/lần</span>
                                                                        <datalist id="info-prescription-dosages-{{ $item + 1 }}">
                                                                        </datalist>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription-frequency bg-transparent" name="frequencies[]" type="text"
                                                                        value="{{ $prescription_detail->frequency }}" list="list-frequency-{{ $prescription_detail->_medicine->id }}" placeholder="Nhập số" autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control form-control-plaintext border-bottom bg-transparent prescription-quantity" name="quantities[]" type="text"
                                                                        value="{{ $prescription_detail->quantity }}" list="list-quantity-{{ $prescription_detail->_medicine->id }}" placeholder="Nhập số" autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription-route bg-transparent" name="routes[]" type="text"
                                                                        value="{{ $prescription_detail->route }}" list="medicine-routes" placeholder="Chọn" autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control form-control-plaintext px-3 bg-transparent border-bottom" name="notes[]" type="text" value="{{ $prescription_detail->note }}" placeholder="Ghi chú"
                                                                        autocomplete="off">
                                                                </td>
                                                                <td>
                                                                    <input name="medicine_ids[]" type="hidden" value="{{ $prescription_detail->medicine_id }}" />
                                                                    <input name="prescription_detail_ids[]" type="hidden" value="{{ $prescription_detail->id }}">
                                                                    <a class="btn btn-link text-decoration-none btn-remove-detail" data-id="{{ $prescription_detail->id }}" data-url="{{ getPath(route('admin.prescription_detail.remove')) }}">
                                                                        <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row mt-5 px-2">
                                                <div class="col-12 col-lg-6">
                                                    <textarea class="form-control border-0 border-bottom mb-3 mb-lg-0" name="message" placeholder="Ghi chú đơn thuốc" rows="2" autocomplete="off">{{ $prescription->message }}</textarea>
                                                    <input name="order_id" type="hidden" value="{{ $info->_detail->order_id }}">
                                                    <input name="info_id" type="hidden" value="{{ $info->id }}">
                                                    <input name="id" type="hidden" value="{{ $prescription->id }}">
                                                </div>
                                                <div class="col-12 col-lg-6 text-end">
                                                    <a class="btn btn-primary btn-suggest-medicine mb-1">
                                                        <i class="bi bi-capsule-pill me-2"></i>
                                                        Thêm thuốc mới
                                                    </a>
                                                    <a class="btn btn-primary btn-create-booking mb-1" data-service_id="{{ $prescription->detail->service_id }}" data-doctor_id="{{ $info->doctor_id }}" data-pet_id="{{ optional($pet)->id }}">
                                                        <i class="bi bi-calendar-check me-2"></i>
                                                        Đặt lịch hẹn
                                                    </a>
                                                    <a class="btn btn-success btn-print print-prescription mb-1" data-id="{{ $prescription->id }}" data-url="{{ getPath(route('admin.prescription')) }}">
                                                        <i class="bi bi-printer me-2"></i>
                                                        In toa thuốc
                                                    </a>
                                                    @if (Auth::user()->can(App\Models\User::UPDATE_PRESCRIPTION))
                                                        <a class="btn btn-info btn-submit-prescription-form mb-1" data-text="Lưu đơn thuốc">
                                                            <i class="bi bi-floppy me-2"></i>
                                                            Lưu đơn thuốc
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <datalist id="medicine-routes">
                    <option value="Đường uống (PO)">
                    <option value="Trực tràng (PR)">
                    <option value="Âm đạo (PV)">
                    <option value="Dưới lưỡi (SL)">
                    <option value="Tiêm tĩnh mạch (IV)">
                    <option value="Thuốc tiêm (IJ)">
                    <option value="Tiêm dưới da (SC)">
                    <option value="Tiêm bắp (IM)">
                    <option value="Nhỏ giọt (Instill)">
                    <option value="Truyền dịch (Inf)">
                </datalist>
                <div class="list-medicine"></div>
            @endif
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        config.routes.createPrescription = `{{ route('admin.prescription.create') }}`
        config.routes.updatePrescription = `{{ route('admin.prescription.update') }}`

        $(document).ready(function() {
            $('.local-select').each(function() {
                $(this).select2(initLocalSelect($(this).parent(), $(this).hasClass('tags'), $(this).attr('placeholder')));
            });

            /************************************* Thiết lập chung ***********************************/

            @if (request('key') == 'new')
                @isset($customer)
                    fillCustomer({{ $customer->id }}, '{{ $customer->name . ' - ' . $customer->phone }}')
                    @isset($pet)
                        fillListPet({{ $customer->id }}, {{ $pet->id }})
                    @endisset
                @endisset
            @endif

            /*********************************** Phiếu khám **************************************/
            /**
             * KHÁM THEO QUY TRÌNH
             */

            // Hàm search thông tin lâm sàng
            $('#symptom-select').on('keyup', function(e) {
                e.preventDefault();
                if (e.key === "Escape") {
                    $(this).val('').change().focus();
                }

                var searchTerm = $(this).val().toLowerCase();
                $('.accordion-item').each(function() {
                    var accordion = $(this);
                    accordion.hide(); // Ẩn accordion

                    accordion.find('.info-item .list-group-item').each(function() {
                        var text = $(this).text().toLowerCase();
                        if (text.includes(searchTerm)) {
                            $(this).show();
                            // Nếu có nhãn phù hợp, hiển thị accordion và mở nó
                            accordion.show(); // Hiển thị accordion
                            accordion.find('.accordion-collapse').collapse('show'); // Mở accordion
                        } else {
                            $(this).hide();
                        }
                    });
                });
            });

            // Thêm thông tin lâm sàng
            $('.symptom-item-form').submit(function(e) {
                e.preventDefault()
                const form = $(this),
                    symptom = {
                        id: form.find('[name=id]').val(),
                        name: form.find('[name=name]').val(),
                        measure: form.find('[name=measure]').val(),
                        group: form.find('[name=group]').val(),
                        disease: form.find('[name=disease]').val()
                    };
                if (!symptom.id || !$('#info-symptoms').find(`[name='symptom_ids[]'][value='${symptom.id}']`).length) { // Tạo dòng mới
                    const info_symptom = $(`tr.info-symptom:last`).clone(),
                        count_symptoms = $('#info-symptoms').find(`[name='symptom_names[]']`).length
                    info_symptom
                        .find(`.symptom_names`).attr('name', 'symptom_names[]').val(symptom.name).attr('data-disease', symptom.disease).end()
                        .find(`.symptom_measures`).attr('name', 'symptom_measures[]').val(symptom.measure).end()
                        .find(`.symptom_groups`).attr('name', 'symptom_groups[]').val(symptom.group).end()
                        .find(`.symptom_ids`).attr('name', 'symptom_ids[]').val(symptom.id).end()
                        .find(`.symptom_diseases`).attr('name', `symptom_diseases[${count_symptoms}][]`).val(symptom.disease).end()
                        .find(`td:last`).html(symptomControl(symptom))
                    $(`tr.info-symptom:last`).before(info_symptom)
                    pushToastify(`Đã bổ sung triệu chứng ${symptom.name} vào phiếu khám!`, 'success')
                } else { //Cập nhật dòng hiện tại
                    $(`[name='symptom_ids[]'][value='${symptom.id}']`).closest('tr.info-symptom').find(`[name='symptom_measures[]']`).val(symptom.measure)
                    pushToastify(`Đã bổ sung triệu chứng ${symptom.name} vào phiếu khám!`, 'danger')
                }
            })

            /**
             * KHÁM TỰ DO
             */
            //Xử lý người dùng nhập triệu chứng mới vào trường trống hiện tại
            $(document).on('focus', `#info-symptoms .symptom_names:last`, function() {
                $(this).closest('tbody').find('.local-select').select2('destroy')
                const tr = $(this).closest('tr'),
                    newTr = tr.clone(),
                    count_symptoms = $('#info-symptoms').find(`[name='symptom_names[]']`).length
                tr
                    .find(`.symptom_names`).attr('name', 'symptom_names[]').end()
                    .find(`.symptom_measures`).attr('name', 'symptom_measures[]').end()
                    .find(`.symptom_groups`).attr('name', 'symptom_groups[]').end()
                    .find(`.symptom_ids`).attr('name', 'symptom_ids[]').end()
                    .find(`.symptom_diseases`).attr('name', `symptom_diseases[${count_symptoms}][]`).end()
                    .find(`td:last`).html(symptomControl())
                tr.after(newTr)
                tr.closest('tbody').find('.local-select').each(function() {
                    $(this).select2(initLocalSelect($(this).parent(), $(this).hasClass('tags'), $(this).attr('placeholder')));
                });
            })

            $(document).on('change', `#info-symptoms .symptom_names`, function() {
                const tr = $(this).closest('tr'),
                    group = $(`#list-info-symptoms`).find(`option[value="${$(this).val()}"]`).eq(0).text()
                    console.log(group);
                    
                tr.find(`[name='symptom_groups[]']`).val(group).change()
            })

            $(document).on('blur', `#info-symptoms .symptom_names`, function() {
                var input = $(`#info-symptoms .symptom_names`).eq(-2);
                if (!input.val()) {
                    input.closest('tr').find('td:last').empty()
                    input.closest('tr').next().remove()
                }
            });

            setTimeout(addFinalDiagControl, 300);
            $(`[name='final_diag[]']`).change(function() {
                setTimeout(addFinalDiagControl, 300);
            })

            function symptomControl(symptom) {
                return `
                    <input name="symptom_ids[]" type="hidden" value="${symptom ? symptom.id : ''}"/>
                    <div class="btn-group" role="group">
                        <a class="btn btn-outline-success btn-suggest-medicine align-content-center" data-name="${symptom ? symptom.name : ''}" disabled>Thuốc</a>
                        <a class="btn btn-outline-info btn-suggest-service align-content-center" data-name="${symptom ? symptom.name : ''}">Chỉ định</a>
                        <a class="btn btn-outline-danger btn-remove-detail align-content-center">
                            <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                        </a>
                    </div>`
            }

            function addFinalDiagControl() {
                $(`[name='final_diag[]']`).next().find('li.select2-selection__choice').each((i, choice) => {
                    if (!$(choice).find('span.btn-inside-select2').length) {
                        const text = $(choice).attr('title'),
                            span = $(choice).find('span').clone(),
                            str = `<span class="cursor-pointer btn-inside-select2 btn-suggest-medicine text-success btn-dismiss-select2 px-1" role="presentation" data-name="${text}"><i class="bi bi-capsule"></i></span>
                                <span class="cursor-pointer btn-inside-select2 btn-suggest-service text-info btn-dismiss-select2 px-1" role="presentation" data-name="${text}"><i class="bi bi-heart-pulse"></i></span>`
                        $(choice).append(str).addClass('mb-3')
                    }
                })
            }

            setTimeout(addPrelimDiagControl, 300);
            $(`.symptom_diseases`).change(function() {
                setTimeout(addPrelimDiagControl, 300);
            })

            function addPrelimDiagControl() {
                $(`.symptom_diseases`).each(function() {
                    $(this).next().find('li.select2-selection__choice').each((i, choice) => {
                        if (!$(choice).find('span.btn-inside-select2').length) {
                            const text = $(choice).attr('title'),
                                span = $(choice).find('span').clone(),
                                str = `
                            @if (Auth::user()->can(App\Models\User::UPDATE_DISEASE))
                            <span class="cursor-pointer btn-inside-select2 btn-update-disease text-primary btn-dismiss-select2 px-1" role="presentation" data-name="${text}"><i class="bi bi-pencil-square"></i></span>
                            @endif`
                            $(choice).append(str).addClass('mb-3')
                        }
                    })
                })
            }

            $(document).on('click', '.btn-dismiss-select2', function() {
                $(this).closest('span.select2.select2-container').prev().select2('close')
            })

            function initLocalSelect(dropdownParent, tags = true, placeholder = 'Nhập thêm hoặc chọn') {
                return {
                    theme: "bootstrap-5",
                    width: '100%',
                    placeholder: placeholder,
                    closeOnSelect: false,
                    tags: tags, // Điều kiện tags dựa trên lớp CSS
                    dropdownParent: dropdownParent // Điều kiện dropdownParent dựa trên phần tử cha
                };
            }

            $(document).on('click', '.btn-mix-advice', function() {
                const final_diag = $(`[name='final_diag[]']`).val()
                if (final_diag.length) {
                    $.get(`{{ route('admin.disease', ['key' => 'advice']) }}?q=${final_diag}`, function(advices) {
                        $('[name=advice]').val(advices.filter(Boolean).join('\r\n'))
                    })
                } else {
                    pushToastify('Bạn chưa chẩn đoán bệnh', 'danger')
                }
            })

            $(document).on('click', '.btn-mix-prognosis', function() {
                const final_diag = $(`[name='final_diag[]']`).val()
                if (final_diag.length) {
                    $.get(`{{ route('admin.disease', ['key' => 'prognosis']) }}?q=${final_diag}`, function(prognosises) {
                        $('[name=prognosis]').val(prognosises.filter(Boolean).join('\r\n'))
                    })
                } else {
                    pushToastify('Bạn chưa chẩn đoán bệnh', 'danger')
                }
            })

            /**
             *  CHẨN ĐOÁN TỰ ĐỘNG
             */
            $('.btn-mix-disease').click(syncDisease);

            function syncDisease() {
                // Gộp tất cả bệnh thành 1 mảng lớn
                let mergeDiseaseArrays = [];
                // $(`[name='symptom_names[]']`).each(function() {
                //     if($(this).attr('data-disease')) {
                //         const arr = JSON.parse($(this).attr('data-disease').replace(/&quot;/g, '"'))
                //         mergeDiseaseArrays.push(...arr);
                //     }
                // })
                $(`#info-symptoms .symptom_diseases`).each(function() {
                    if ($(this).val()) {
                        mergeDiseaseArrays.push(...$(this).val());
                    }
                })

                // Đếm tần suất xuất hiện
                const frequency = {};
                mergeDiseaseArrays.forEach(item => {
                    if (frequency[item]) {
                        frequency[item]++;
                    } else {
                        frequency[item] = 1;
                    }
                });

                // Sắp xếp mảng
                const sortedDiseases = Object.entries(frequency).sort((a, b) => b[1] - a[1]);
                // Hiển thị
                const final_diseases = $(`[name='final_diag[]']`).val() || []
                sortedDiseases.map((disease) => {
                    final_diseases.push(disease[0])
                })

                $(`[name='final_diag[]']`).select2('destroy')
                $.each(final_diseases.reverse(), (i, disease) => {
                    const option = $(`[name='final_diag[]']`).find(`option[value='${disease}']`),
                        newOption = new Option(disease, disease, true, true)
                    if (option.length) option.remove()
                    $(`[name='final_diag[]']`).prepend(newOption)
                })
                $(`[name='final_diag[]']`).val(final_diseases).trigger('change')
                $(`[name='final_diag[]']`).select2(initLocalSelect($(this).parent(), $(this).hasClass('tags'), $(this).attr('placeholder')))
            }

            /************************************* Đơn thuốc *******************************/
            // Thêm đơn thuốc
            $(document).on('click', '.btn-create-prescription_detail', function() {
                const unit = $(this).attr('data-unit'),
                    row = $(this).closest('.list-medicines-dosage'),
                    dosage = row.find('.medicine-item-dosage-dosage').val(),
                    frequency = row.find('.medicine-item-dosage-frequency').val(),
                    quantity = row.find('.medicine-item-dosage-quantity').val(),
                    route = row.find('.medicine-item-dosage-route').val(),
                    medicine_name = row.find('.medicine-item-dosage-medicine_name').val(),
                    medicine_id = row.find('.medicine-item-dosage-medicine_id').val(),
                    specie = infoForm.find('input[name="pet_id"]').attr('data-specie')
                if (!$('.tab-pane.active').find(`#info-medicine-${medicine_id}`).length) {
                    const newRow = `
                        <tr class="medicine-row" id="info-medicine-${medicine_id}">
                            <td class="fw-bold">
                                ${medicine_name}
                                <input type="hidden" class="medicine-name" value="${medicine_name}">
                            </td>
                            <td>
                                <div class="input-group">
                                    <input list="list-dosage-${medicine_id}" name="dosages[]" class="form-control form-control-plaintext border-bottom prescription_detail-dosage bg-transparent" value="${dosage}" placeholder="Nhập số" autocomplete="off">
                                    <span class="input-group-text">${ unit }/lần</span>
                                </div>
                            </td>
                            <td>
                                <input list="list-frequency-${medicine_id}" type="text" class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription_detail-frequency bg-transparent" value="${frequency}" name="frequencies[]" placeholder="Nhập số" autocomplete="off">
                            </td>
                            <td>
                                <input list="list-quantity-${medicine_id}" type="text" class="form-control form-control-plaintext border-bottom bg-transparent prescription_detail-quantity" value="${quantity}" name="quantities[]" placeholder="Nhập số" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" list="medicine-routes" class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription_detail-route bg-transparent" value="${route}" name="routes[]" placeholder="Đường cấp" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-plaintext px-3 border-bottom prescription_detail-note bg-transparent" name="notes[]" placeholder="Ghi chú" autocomplete="off">
                            </td>
                            <td>
                                <input name="medicine_ids[]" type="hidden" value="${medicine_id}" />
                                <input name="prescription_detail_ids[]" type="hidden">
                                <a class="btn btn-link text-decoration-none btn-remove-detail">
                                    <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                                </a>
                            </td>
                        </tr>`;
                    $('#info-prescription-contents').find('.tab-pane.active .info-medicines').append(newRow);
                } else {
                    pushToastify('Thuốc đã được thêm!', 'danger')
                }
            });

            $(document).on('click', '.btn-suggest-medicine', function() {
                const textToSearch = $(this).attr('data-name')
                $('#info-medicine-select').val(textToSearch).trigger('keyup').focus()[0];
                $('#info_medicines-modal').modal('show')
            })

            $(document).on('click', '.btn-create-prescription', function() {
                createPrescriptionTab()
                $('.tab-pane.active').find('.info-prescription-form').attr('action', config.routes.createPrescription)
            })

            $(document).on('click', '.medicine-item-title', function() {
                const dosage_input = $(this).next().find('.medicine-item-dosage-dosage'),
                    weight = parseFloat(infoForm.find('[name=weight]').val()),
                    apply_dosage = parseFloat(dosage_input.val()) * weight
                dosage_input.val(apply_dosage.toFixed(2))
            })

            // Gắn sự kiện click cho nút đóng đơn thuốc
            $(document).on('click', '.btn-remove-prescription', function(e) {
                e.stopPropagation()
                const id = $(this).attr('data-id');
                Swal.fire(config.sweetAlert.confirm).then((result) => {
                    if (result.isConfirmed) {
                        if (id) {
                            $.ajax({
                                url: `{{ route('admin.prescription.remove') }}`,
                                method: 'POST',
                                data: {
                                    choices: [id],
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    pushToastify(response.msg, response.status)
                                },
                                error: function(error) {
                                    Swal.fire("Thông báo!", 'Thao tác chưa được cấp quyền', "role");
                                }
                            });
                        }
                        var tab = $(this).closest('a.nav-link');
                        var target = tab.data('bs-target');

                        var tabToActive = tab.closest('li').prev('li').find('a.nav-link');
                        if (!tabToActive.length) {
                            tabToActive = tab.closest('li').next('li').find('a.nav-link');
                        }
                        tabToActive.addClass('active').find('.btn').removeClass('d-none');
                        $(tabToActive.data('bs-target')).addClass('show active');
                        tab.closest('li').remove();
                        $(target).remove();
                        if (!$('#info-prescription-tabs').find('li').length) {
                            createPrescriptionTab()
                        }
                    }
                })
            });

            $(document).on('click', 'a[data-bs-toggle="pill"]', function(e) {
                $(this).closest('ul').find('a .btn').addClass('d-none');
                $(this).find('.btn').removeClass('d-none');
            });

            $(document).on('click', '.btn-submit-prescription-form', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                $('.local-select').each(function() {
                    $(this).select2('destroy');
                });
                submitForm(form).done(function(response) {
                    reloadPrescription(form, response.obj)
                });
            });

            /******************************************* Dịch vụ ************************************/
            // Thêm dịch vụ

            $(document).on('click', '.btn-suggest-service', function() {
                const textToSearch = $(this).attr('data-name')
                $('#service-select').val(textToSearch).trigger('keyup').focus()[0]
            })
            /************************************** Kết thúc dịch vụ *******************************/
            /** Nếu là cập nhật phiếu khám */
            @if (isset($info))
                @if (!$info->prescriptions->count())
                    createPrescriptionTab()
                @else
                    const tags = $('#info-prescription-tabs').find('li').length;
                    $(`[data-bs-target="#info-prescription-tab-${tags}"]`).addClass('active').find('.btn.btn-remove-prescription').removeClass('d-none')
                    $(`#info-prescription-tab-${tags}`).addClass('show active')
                    var medicineId;
                    @foreach ($info->prescriptions as $e => $prescription)
                        @foreach ($prescription->prescription_details as $i => $prescription_detail)
                            medicineId = {{ $prescription_detail->_medicine->id }}
                            var specie = infoForm.find('input[name="pet_id"]').attr('data-specie');
                            if ($('.list-medicine').find(`datalist#list-dosage-${medicineId}`).length == 0) {
                                var optionDosages = `<datalist id="list-dosage-${medicineId}">`,
                                    optionFrequencies = `<datalist id="list-frequency-${medicineId}">`,
                                    optionQuantities = `<datalist id="list-quantity-${medicineId}">`;

                                @foreach ($prescription_detail->_medicine->dosages as $p => $dosage)
                                    if ({!! json_encode($dosage->specie) !!} === specie) {
                                        optionDosages += `<option value="` + {{ $dosage->dosage * $info->weight }} + `">`;
                                        optionFrequencies += `<option value="` + {{ $dosage->frequency }} + `">`;
                                        optionQuantities += `<option value="` + {{ $dosage->quantity }} + `">`;
                                    }
                                @endforeach
                                optionDosages += `</datalist>`
                                optionFrequencies += `</datalist>`
                                optionQuantities += `</datalist>`
                                $('.list-medicine').append(optionDosages).append(optionFrequencies).append(optionQuantities)
                            }
                        @endforeach
                    @endforeach
                @endif

                function createPrescriptionTab() {
                    const numberOfTabs = $('#info-prescription-tabs').find('li').length,
                        tagStr = `<li>
                            <a class="nav-link btn shadow rounded-0 me-1 mb-1 active"
                                    data-bs-toggle="pill" data-bs-target="#info-prescription-tab-${numberOfTabs + 1}">
                                Đơn thuốc ${numberOfTabs + 1}
                                {{-- <button type="button" data-id="" class="btn btn-light-primary btn-remove-prescription py-0 z-5 opacity-50 px-2 ms-2">×</button> --}}
                            </a>
                        </li>`,
                        contentStr = `<div class="tab-pane fade show active" id="info-prescription-tab-${numberOfTabs + 1}">
                                <form class="info-prescription-form" action="${config.routes.createPrescription}" method="post">
                                    @csrf
                                    <input type="text" name="name" class="form-control my-3" placeholder="Tên đơn thuốc" autocomplete="off">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-wide table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tên thuốc</th>
                                                    <th>Liều dùng/lần</th>
                                                    <th>Số lần/ngày</th>
                                                    <th>Số ngày</th>
                                                    <th>Đường cấp</th>
                                                    <th>Ghi chú</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="info-medicines">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-5 px-2">
                                        <div class="col-12 col-lg-6">
                                            <textarea name="message" class="form-control border-0 mb-3 mb-lg-0 border-bottom" placeholder="Ghi chú đơn thuốc" rows="2" autocomplete="off"></textarea>
                                            <input type="hidden" name="order_id" value="{{ $info->_detail->order_id }}"">
                                            <input type="hidden" name="info_id" value="{{ $info->id }}">
                                            <input type="hidden" name="id" value="">
                                            </div>
                                            <div class="col-12 col-lg-6 d-flex align-items-end justify-content-end">
                                            <a class="btn btn-primary btn-suggest-medicine me-2">
                                                <i class="bi bi-capsule-pill me-2"></i>
                                                Thêm thuốc mới
                                            </a>
                                            @if (Auth::user()->can(App\Models\User::CREATE_PRESCRIPTION))
                                                <a class="btn btn-info btn-submit-prescription-form" data-text="Lưu đơn thuốc">
                                                    <i class="bi bi-floppy me-2"></i>
                                                    Lưu đơn thuốc
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>`
                    if (numberOfTabs >= 10) {
                        pushToastify('Số đơn thuốc của phiếu khám đã đạt giới hạn!', 'danger')
                    } else {
                        $('#info-prescription-tabs').find('.btn.active').removeClass('active').find('.btn').addClass('d-none');
                        $('#info-prescription-contents').find('.tab-pane.active').removeClass('show active');
                        $('#info-prescription-tabs').append(tagStr);
                        $('#info-prescription-contents').append(contentStr);
                    }
                }
            @endif
        })

        function reloadPrescription(form, prescription) {
            console.log('reload');

            form.attr('action', config.routes.updatePrescription)
            form.find('.btn-submit-prescription-form').removeClass('btn-info').addClass('btn-success')
            form.find('input[name="id"]').val(prescription.id)
            form.find('[name="message"]').val(prescription.message ?? '')
            form.find('.info-medicines').empty()
            const tab_id = form.closest('.tab-pane.fade').attr('id'),
                tab = $('#info-prescription-tabs').find(`a[data-bs-target="#${tab_id}"]`);
            tab.contents().filter(function() {
                return this.nodeType === Node.TEXT_NODE;
            }).first().replaceWith(prescription.name ?? prescription.code);
            tab.find('.btn').attr('data-id', prescription.id)
            let str = `<a class="btn btn-primary btn-suggest-medicine me-2">
                            <i class="bi bi-capsule-pill me-2"></i>
                            Thêm thuốc mới
                        </a>
                        <a class="btn btn-primary btn-create-booking me-2" data-service_id="{{ optional(cache()->get('services_' . Auth::user()->company_id)->where('ticket', 'prescription')->first())->id }}">
                            <i class="bi bi-calendar-check me-2"></i>
                            Đặt lịch hẹn
                        </a>
                        <a class="btn btn-success btn-print print-prescription me-2" data-id="${prescription.id}" data-url="{{ getPath(route('admin.prescription')) }}">
                            <i class="bi bi-printer me-2"></i>
                            In toa thuốc
                        </a>
                        @if (Auth::user()->can(App\Models\User::UPDATE_PRESCRIPTION))
                            <a class="btn btn-info btn-submit-prescription-form" data-text="Lưu đơn thuốc">
                                <i class="bi bi-floppy me-2"></i>
                                Lưu đơn thuốc
                            </a>
                        @endif`
            form.find('.btn-submit-prescription-form').parent().html(str);
            $.each(prescription.prescription_details, function(index, detail) {
                const unit = detail._medicine._variable.units.find(function(item) {
                        return item.rate == 1;
                    }).term,
                    prescriptionDetail = `
                                    <tr class="medicine-row" id="info-medicine-${detail.medicine_id}">
                                        <td class="fw-bold">
                                            ${detail._medicine.name}
                                            <input type="hidden" class="medicine-name" value="${detail._medicine.name}">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" list="list-dosage-${detail._medicine}}" name="dosages[]" value="${detail.dosage}" class="form-control form-control-plaintext border-bottom" placeholder="Nhập số" autocomplete="off">
                                                <span class="input-group-text">${unit}/lần</span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" list="list-frequency-${detail._medicine}}" class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription-frequency bg-transparent" value="${detail.frequency}" name="frequencies[]" placeholder="Nhập số" autocomplete="off">
                                        </td>
                                        <td>
                                            <input  type="text" list="list-quantity-${detail._medicine}}"class="form-control form-control-plaintext border-bottom bg-transparent prescription-quantity" value="${detail.quantity}" name="quantities[]" placeholder="Nhập số" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="text" list="medicine-routes" class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription-route bg-transparent" value="${detail.route}" name="routes[]" placeholder="Chọn" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="text" value="${detail.note ?? ''}" class="form-control form-control-plaintext px-3 bg-transparent border-bottom" name="notes[]" placeholder="Ghi chú" autocomplete="off">
                                        </td>
                                        <td>
                                            <input name="medicine_ids[]" type="hidden" value="${detail.medicine_id}" />
                                            <input name="prescription_detail_ids[]" type="hidden" value="${detail.id}">
                                            <a class="btn btn-link text-decoration-none btn-remove-detail" data-id="${detail.id}" data-url="{{ getPath(route('admin.prescription_detail.remove')) }}">
                                                <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                                            </a>
                                        </td>
                                    </tr>`;
                form.find('.info-medicines').append(prescriptionDetail);
            })
        }
    </script>
@endpush
