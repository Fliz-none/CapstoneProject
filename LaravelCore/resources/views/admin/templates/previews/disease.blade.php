<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="order-modal-label">{{ $disease->code }} - Bệnh {{ $disease->name }}</h1>
            <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if ($disease->infection_chain)
                <div class="card card-body mb-2">
                    <h5 class="card-title">Chuỗi lây nhiễm</h5>
                    <p class="card-text">{!! nl2br($disease->infection_chain) !!}</p>
                </div>
            @endif
            @if ($disease->complication)
                <div class="card card-body mb-2">
                    <h5 class="card-title">Biến chứng</h5>
                    <p class="card-text">{!! nl2br($disease->complication) !!}</p>
                </div>
            @endif
            @if ($disease->prevention)
                <div class="card card-body mb-2">
                    <h5 class="card-title">Phòng ngừa</h5>
                    <p class="card-text">{!! nl2br($disease->prevention) !!}</p>
                </div>
            @endif
            @if ($disease->advice)
                <div class="card card-body mb-2">
                    <h5 class="card-title">Lời dặn</h5>
                    <p class="card-text">{!! nl2br($disease->advice) !!}</p>
                </div>
            @endif
            @if ($disease->counsel)
                <div class="card card-body mb-2">
                    <h5 class="card-title">Tư vấn</h5>
                    <p class="card-text">{!! nl2br($disease->counsel) !!}</p>
                </div>
            @endif
            @if ($disease->prognosis)
                <div class="card card-body mb-2">
                    <h5 class="card-title">Tiên lượng</h5>
                    <p class="card-text">{!! nl2br($disease->prognosis) !!}</p>
                </div>
            @endif
            @if ($disease->symptoms->count())
                <div class="card card-body mb-2">
                    <h5 class="card-title">Các triệu chứng</h5>
                    <p class="card-text">{!! $disease->symptoms->map(function ($symptom) {
                            return '• ' . $symptom->name;
                        })->join('<br/>') !!}</p>
                </div>
            @endif
            @if ($disease->services->count())
                <div class="card card-body mb-2">
                    <h5 class="card-title">Các chỉ định</h5>
                    <p class="card-text">{!! $disease->services->map(function ($service) {
                            return '• ' . $service->fullName;
                        })->join('<br/>') !!}</p>
                </div>
            @endif
            @if ($disease->medicines->count())
                <div class="card card-body mb-2">
                    <h5 class="card-title">Các thuốc điều trị</h5>
                    {!! $disease->medicines->map(function ($medicine) {
                            return '<p class="fw-bold mb-1 mt-3">' . $medicine->name . '</p>' .
                                '<ul class="mb-0">' .
                                $medicine->dosages->map(function ($dosage) use ($medicine) {
                                        return '<li>Liều cho ' .
                                            $dosage->specie .
                                            ' từ ' .
                                            $dosage->age .
                                            ' tháng: 
                                            ' .
                                            $dosage->dosage .
                                            ' ' .
                                            optional($medicine->variable->_units->where('rate', 1)->first())->term .
                                            '/kg, 
                                            dùng trong ' .
                                            $dosage->quantity .
                                            ' ngày, (mỗi ngày ' .
                                            $dosage->frequency .
                                            ' lần)</li>';
                                    })->join('') . '</ul>';
                        })->join('') !!}
                </div>
            @endif
        </div>
        <div class="modal-footer">
            @if (Auth::user()->can(App\Models\User::UPDATE_DISEASE))
                <button class="btn btn-primary text-decoration-none btn-update-disease" data-bs-dismiss="modal" data-id="{{ $disease->id }}" type="button" aria-label="Close">
                    <i class="bi bi-pencil-square"></i> Cập nhật
                </button>
            @endif
        </div>
    </div>
</div>
