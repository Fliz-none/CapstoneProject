@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-9">
                    <h5 class="text-uppercase">{{ __('messages.work_schedule.work_schedule_management') }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.work_schedule.work_schedule_management') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-3">
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row mb-3">
                <div class="col-12 col-lg-6">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_WORK)))
                        <a class="btn btn-info block btn-work-schedule">
                            <i class="bi bi-calendar2-range"></i>
                            {{ __('messages.work_schedule.work_schedule') }}
                        </a>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_WORK)))
                        <a class="btn btn-info block btn-work-summary">
                            <i class="bi bi-calendar-plus"></i>
                            {{ __('messages.work_schedule.summary') }}
                        </a>
                    @endif
                </div>
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-end">
                    <select class="form-control form-control-plaintext text-center w-auto ms-2 calendar-list-branches">
                        <option selected hidden disabled>{{ __('messages.work_schedule.your_branch') }}</option>
                        @foreach (Auth::user()->branches as $branch)
                            <option value="{{ $branch->id }}" {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @php
                        $active_calendar = !(Request::query('display') === 'list') ? 'active' : '';
                        $active_list = Request::query('display') === 'list' ? 'active' : '';
                    @endphp
                    <div class="ms-2 btn-group">
                        <a class="btn btn-outline-primary {{ $active_calendar }}" id="display-calendar" href="{{ route('admin.work') }}">
                            <i class="bi bi-calendar-check"></i>
                        </a>
                        <a class="btn btn-outline-primary {{ $active_list }} " id="display-list" href="{{ route('admin.work') }}?display=list">
                            <i class="bi bi-list-check"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><i class="bi bi-chat-right-fill text-info"></i> {{ __('messages.work_schedule.shift_checked') }}</li>
                            <li class="breadcrumb-item"><i class="bi bi-chat-right text-info"></i> {{ __('messages.work_schedule.not_checked') }}</li>
                            <li class="breadcrumb-item"><i class="bi bi-chat-right text-secondary"></i> {{ __('messages.work_schedule.absent') }}</li>
                        </ul>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary border-0 btn-prev-week" type="button"><i class="bi bi-caret-left-fill"></i></button>
                            <button class="btn btn-outline-secondary border-0 btn-next-week" type="button"><i class="bi bi-caret-right-fill"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover key-table table-striped" id="work-schedule-table">
                            <thead>
                            </thead>
                            <tbody>
                                @forelse ($users as $i => $user)
                                    @php
                                        $shifts = $users
                                            ->pluck('works')
                                            ->flatten()
                                            ->unique(function ($work) {
                                                return Carbon\Carbon::parse($work['sign_checkin'])->format('H:i:s'); // Lọc theo giờ:phút:giây
                                            })
                                            ->sortBy('sign_checkin');
                                    @endphp
                                    <tr>
                                        <td>
                                            @if (Auth::user()->can(App\Models\User::UPDATE_USER))
                                                <a class="text-primary text-start p-0 btn-update-user cursor-pointer" data-id="{{ $user->id }}">{{ $user->name }}</a><br>
                                                {{-- <small>{{ $user->getRoleNames()[0] }}</small> --}}
                                                <a class="btn-sm text-primary btn-update-user cursor-pointer px-0 fw-bold" data-id="{{ $user->id }}">{{ $user->code }}<br> </a>
                                            @else
                                                <a class="text-primary text-start p-0">{{ $user->name }}</a><br>
                                                <a class="btn-sm text-primary px-0 fw-bold"> {{ $user->code }}<br> </a>
                                            @endif
                                        </td>
                                        @foreach ($days as $j => $day)
                                            <td class="text-start align-content-center">
                                                <div class="btn-group btn-group-sm">
                                                    @php
                                                        $user_works = $user->works->where('user_id', $user->id)->filter(function ($item) use ($day) {
                                                            return Carbon\Carbon::parse($item['sign_checkin'])->format('Y-m-d') === $day->format('Y-m-d');
                                                        });
                                                    @endphp
                                                    @foreach ($shifts as $k => $shift)
                                                        @php
                                                            $is_checked = false;
                                                            $color = 'secondary';
                                                            $tooltip = '';
                                                            $work_id = '';
                                                        @endphp
                                                        @foreach ($user_works->filter(function($work) use ($shift) {
                                                            return Carbon\Carbon::parse($work['sign_checkin'])->format('H:i:s') === Carbon\Carbon::parse($shift['sign_checkin'])->format('H:i:s');
                                                        }) as $work)
                                                            @php
                                                                $is_checked = $work->real_checkin && $work->real_checkout;
                                                                $color = !$work->real_checkout && \Carbon\Carbon::now() > $work->sign_checkout ? 'secondary' : 'info';
                                                                $tooltip =
                                                                    '
                                                                <div class="tooltip-text">
                                                                    <li class="d-flex text-nowrap">
                                                                        <span class="text-primary fw-bold">' . (!$work->real_checkin ? 'No attendance recorded yet' : '') . '</span>
                                                                        <span class="' .
                                                                    ($work->real_checkin <= $work->sign_checkin ? 'text-info' : 'text-danger') . '"> ' .
                                                                    ($work->real_checkin ? '<i class="bi bi-box-arrow-in-down-right"></i>&nbsp;' . \Carbon\Carbon::parse($work->real_checkin)->format('H:i') : '') . ' ' .
                                                                    ($work->real_checkin ? '(' . ($work->real_checkin <= $work->sign_checkin ? '' : '-') . \Carbon\Carbon::parse($work->real_checkin)->diffInMinutes(\Carbon\Carbon::parse($work->sign_checkin)) . 'p)' : '') . '
                                                                        </span>&nbsp;&nbsp;&nbsp;
                                                                        <span class="' .
                                                                    ($work->real_checkout >= $work->sign_checkout ? 'text-info' : 'text-danger') . '"> ' .
                                                                    ($work->real_checkout ? '<i class="bi bi-box-arrow-up-right"></i>&nbsp;' . \Carbon\Carbon::parse($work->real_checkout)->format('H:i') : '') . ' ' .
                                                                    ($work->real_checkout ? '(' . ($work->real_checkout >= $work->sign_checkout ? '' : '-') . \Carbon\Carbon::parse($work->real_checkout)->diffInMinutes(\Carbon\Carbon::parse($work->sign_checkout)) . 'p)' : '') . '
                                                                        </span>
                                                                    </li>
                                                                </div>';
                                                                $work_id = $work->id;
                                                            @endphp
                                                        @endforeach
                                                        <input class="btn-check" id="shift-{{ $i . $j . $k }}" type="checkbox" {{ $is_checked ? 'checked' : '' }} autocomplete="off" {{ $work_id ? '' : 'disabled' }}>
                                                        <label class="btn p-1 px-2 btn-outline-{{ $color }} shadow-none {{ $work_id ? 'tooltip-container btn-update-work' : '' }}" data-id="{{ $work_id }}"
                                                            for=" shift-{{ $i . $j . $k }}">C{{ $loop->index + 1 }}
                                                            {!! $tooltip !!}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="8"><span class="text-primary fw-bold"> No attendance records yet</span></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.includes.partials.modal_schedule')
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.btn-work-schedule', function(e) {
            e.preventDefault();
            const modal = $('#schedule-modal');
            renderSchedule(nextMonday, $('#schedule-table thead'));
            $('#schedule-table').find('.btn-change-schedule').prop('checked', false);
            fillSchedule();
            modal.modal('show').find('.modal-title').text(`{{ __('messages.work_schedule.work_shift') }} (${nextMonday.format('DD/MM')} - ${nextMonday.clone().add(6, 'days').format('DD/MM')})`);
        })

        $(document).on('change', '.schedule-list-branches', function() {
            const branch_id = $(this).val();
            $('#schedule-modal').find('tr').each(function(i, element) {
                if (branch_id === 'all') {
                    $('#schedule-modal').find('tr').show();
                } else if ($(element).find(`[data-branch_id="${branch_id}"]`).length > 0) {
                    $(element).show();
                } else {
                    if (!$(element).hasClass('tr-head')) {
                        $(element).hide();
                    }
                }
            });
        });

        //Xem lịch chấm công lấy thứ hai của tuần hiện tại
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        let monday = getQueryParam('monday') ? moment(getQueryParam('monday')) : moment().startOf('week');
        renderSchedule(monday, $('#work-schedule-table thead'));


        //Khoảng chọn tháng
        let startDate = moment().startOf('month').format('DD/MM/YYYY'); // Ngày đầu tháng
        let endDate = moment().endOf('month').format('DD/MM/YYYY');

        $(document).on('click', '.btn-work-summary', function(e) {
            e.preventDefault();
            $.get(`{{ route('admin.work', ['key' => 'summary']) }}`, function(modal) {
                $('#render-wrapper').removeClass('d-none').html(modal);
                $('#work_summary-modal').modal('show');
                initializeDateRange();
            });
        });

        function initializeDateRange() {
            $('#work_summary-range').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY',
                },
            });

            $('#work_summary-range').off('apply.daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                const range = $(this).val();
                $.get(`{{ route('admin.work', ['key' => 'summary']) }}?range=${range}`, function(modal) {
                    $('#work_summary-modal').modal('hide');
                    $('#render-wrapper').html(modal);
                    $('#work_summary-modal').modal('show');
                    initializeDateRange();
                });
            });
        }


        $('.calendar-list-branches').change(function() {
            window.location.href = `{{ route('admin.work') }}?monday=${monday.format('YYYY-MM-DD')}&branch_id=${$(this).val()}`
        })

        // Chuyển sang tuần kế tiếp
        $('.btn-next-week').on('click', function() {
            monday = monday.add(7, 'days');
            const query_branch = $('.schedule-list-branches').val() != 'all' ? '&branch_id=' + $('.schedule-list-branches').val() : '';
            window.location.href = `{{ route('admin.work') }}?monday=${monday.format('YYYY-MM-DD')}${query_branch}`;
        });

        // Chuyển sang tuần trước
        $('.btn-prev-week').on('click', function() {
            monday = monday.subtract(7, 'days');
            const query_branch = $('.schedule-list-branches').val() != 'all' ? '&branch_id=' + $('.schedule-list-branches').val() : '';
            window.location.href = `{{ route('admin.work') }}?monday=${monday.format('YYYY-MM-DD')}${query_branch}`;
        });

        $('.view-timesheet').css({
            'opacity': 0,
            'height': '0',
            'overflow': 'hidden',
            'transition': 'opacity 0.5s ease-in-out, height 0.5s ease-in-out'
        });

        $('#view-timesheet').on('change', function() {
            $('.view-timesheet').each(function() {
                if ($('#view-timesheet').is(':checked')) {
                    const height = $(this).get(0).scrollHeight;
                    $(this).css({
                        'opacity': 1,
                        'height': height + 'px'
                    });
                } else {
                    $(this).css({
                        'opacity': 0,
                        'height': '0',
                    });
                }
            });
        });
    </script>
@endpush
