<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5 text-info" id="booking-modal-label">{{ $booking->name }}</h1>
            <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="fw-bold fs-6">Tiêu đề:</td>
                        <td>{{ $booking->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold fs-6">Giờ hẹn:</td>
                        <td>{{ \Carbon\Carbon::parse($booking->appointment_at)->format('H:i \n\g\à\y d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold fs-6">Nhắc nhở:</td>
                        <td>{{ $booking->remindStr }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold fs-6">Tần suất lặp lại:</td>
                        <td>{{ $booking->frequencyStr }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold fs-6">Trạng thái:</td>
                        <td>{{ $booking->statusStr }}</td>
                    </tr>
                    {!! isset($booking->_customer) ? '<tr><td class="fw-bold fs-6">Hẹn với:</td><td>' . $booking->_customer->name . ' - ' . $booking->_customer->phone . '</td></tr>' : '' !!}
                    {!! isset($booking->_doctor) ? '<tr><td class="fw-bold fs-6">Bác sĩ được hẹn:</td><td>' . $booking->_doctor->name . '</td></tr>' : '' !!}

                </tbody>
            </table>
            <div class="mb-1 form-group">
                <p class="text-info form-label">Ghi chú</p>
                <p>{!! nl2br($booking->note) !!}</p>
            </div>
            <div class="mb-1 form-group">
                <p class="text-info form-label">Mô tả</p>
                <p>{!! nl2br($booking->description) !!}</p>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-12">
                    <div class="d-grid">
                        <div class="btn-group" role="group" aria-label="Chọn trạng thái">
                            @foreach ([0 => 'Bị hủy', 1 => 'Đang chờ', 2 => 'Xác nhận', 3 => 'Hoàn thành'] as $value => $label)
                                <input class="btn-check" id="status-{{ $value }}" name="status" type="radio" {{ $booking->status == $value ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary fs-6 p-2" for="status-{{ $value }}">{{ $label }}</label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-12 text-end">
                    @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_BOOKING)))
                        <button class="btn btn-primary btn-update-booking" data-id="{{ $booking->id }}" type="button" data-bs-dismiss="modal">Cập nhật</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
