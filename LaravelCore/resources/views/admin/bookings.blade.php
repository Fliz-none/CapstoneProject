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
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row ajax-search mx-auto mb-3">
                        <div class="col-12 col-lg-5">
                            <div class="input-group mb-3">
                                <select class="form-control form-control-lg form-control-plaintext text-end border-0" id="month-picker"></select>&nbsp;&nbsp;
                                <select class="form-control form-control-lg form-control-plaintext text-start border-0" id="year-picker"></select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="dropdown">
                                <div class="dropdown search-form">
                                    <input class="form-control form-control-lg search-input" id="booking-search" data-url="{{ route('admin.booking') }}?key=search" placeholder="Tìm kiếm..." autocomplete="off">
                                </div>
                                <ul class="dropdown-menu shadow-lg overflow-auto search-result w-100" style="z-index:1">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            @if (!empty(Auth::user()->can(App\Models\User::READ_BOOKINGS)))
                <div class="card card-body text-center table-responsive">
                    <div class="calendar" style="min-width: 90rem">
                        <div class="border-0 d-flex">
                            <div class="dayname h-25">
                                <h4 class="p-2">T2</h4>
                            </div>
                            <div class="dayname h-25">
                                <h4 class="p-2">T3</h4>
                            </div>
                            <div class="dayname h-25">
                                <h4 class="p-2">T4</h4>
                            </div>
                            <div class="dayname h-25">
                                <h4 class="p-2">T5</h4>
                            </div>
                            <div class="dayname h-25">
                                <h4 class="p-2">T6</h4>
                            </div>
                            <div class="dayname h-25">
                                <h4 class="p-2">T7</h4>
                            </div>
                            <div class="dayname h-25">
                                <h4 class="p-2">CN</h4>
                            </div>
                        </div>
                        <div id="daysmonth"></div>
                        <div class="row justify-content-end my-4 align-items-center" id="listwork"></div>
                    </div>
                </div>
            @else
                @include('includes.access_denied')
            @endif
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        //Hiển thị ngày trong tháng
        function showCalendar([year, month]) {
            var daysInMonth = howManyDate(new Date(year, month, 0));
            var str = `<div class="week d-flex">`;
            //Lấy thứ của ngày đầu tiên trong tháng
            var firstDay = (new Date(year, month - 1, 1).getDay()) ? new Date(year, month - 1, 1).getDay() : 7;
            //Thêm các ô trống
            for (var i = 1; i < firstDay; i++) {
                str += `<div class="empty-day">
                            <div class="daybar">
                            </div>
                            <div class="dots pt-3 pb-5">
                            </div>
                        </div>`;
            }
            //In ra các nhày trong tháng
            for (var day = 1; day <= daysInMonth; day++) {
                const date = moment(year + '-' + (('0' + month).slice(-2)) + '-' + (('0' + day).slice(-2))),
                    isPast = date.isBefore(moment(), 'day');
                str += `<div data-date="${date.format('YYYY-MM-DD')}" class="day work ${moment().format('YYYY-MM-DD') == date.format('YYYY-MM-DD') ? 'today' : ''}">
                            <div class="daybar ${(new Date(`${year}-${month}-${day}`).getDay() == 0) ? 'sunday' : ''}">
                                ${day}
                            </div>
                            <div class="dots mt-4">
                                <div class="mb-1 dot-date-${day}">
                                    <ul class="list-dot list-unstyled d-flex align-items-center"></ul>
                                </div>
                            </div>
                            <div class="open" style="display: ${date.week() == moment().week() ? 'block' : 'none'}">
                                <div class="d-grid">
                                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_BOOKING)))
                                        <button type="button" class="btn btn-link text-decoration-none btn-create-booking ${isPast ? 'opacity-0' : ''}"
                                            data-date="${date.format('YYYY-MM-DD')}""
                                            ${isPast ? 'disabled' : ''} >
                                            <i class="bi bi-plus-circle"></i> Thêm lịch mới
                                        </button>
                                    @endif
                                </div>
                                <div class="timeline">
                                </div>
                            </div>
                        </div>`;
                //Xuống dòng nếu là chủ nhật
                if ((firstDay + day) % 7 === 1) {
                    str += `</div><div class="week d-flex">`;
                }
            }
            $('#daysmonth').html(str);
            initMenu();
            const date = new Date(year, month - 1, 1),
                startDate = moment(date).startOf('month').format('DD/MM/YYYY'),
                endDate = moment(date).endOf('month').format('DD/MM/YYYY')

            fillData(startDate + ' - ' + endDate)
        }

        function fillData(dateRange) {
            $.get(`{{ route('admin.booking') }}?key=filter&daterange=${dateRange}`, function(events) {
                let [startDateStr, endDateStr] = dateRange.split(' - ');
                let startDate = moment(startDateStr, "DD/MM/YYYY");
                let endDate = moment(endDateStr, "DD/MM/YYYY");

                while (startDate.isSameOrBefore(endDate)) {
                    let div = $(`.day[data-date="${startDate.format('YYYY-MM-DD')}"]`);
                    div.find('.timeline, .list-dot').empty();
                    startDate.add(1, 'days');
                }

                $.each(events, function(i, event) {
                    const divDay = $(`.day[data-date=${moment(event.appointment_at).format('YYYY-MM-DD')}]`),
                        hour = moment(event.appointment_at).format('HH'),
                        count = events.filter(function(item) {
                            return moment(item.appointment_at).format('YYYY-MM-DD') === moment(event.appointment_at).format('YYYY-MM-DD');
                        }),
                        badgeColor = !event.status ? 'danger text-white' : (event.status == 1 ? 'light text-dark' : (event.status == 2 ? 'info text-white' : 'success text-white')),
                        dotColor = event.service_id && event._service.major_id ? event._service._major.color : 'warning',
                        status = !event.status ? 'Bị hủy' : (event.status == 1 ? 'Đang chờ' : (event.status == 2 ? 'Sẽ tới' : 'Đã tới')),
                        card = `<div class="timeline-item px-3 hour-${hour}">
                                    <div class="card card-event position-relative shadow-none border bg-light-${event.service_id != null ? dotColor : 'primary'} text-start p-3 my-1">
                                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_BOOKING)))
                                            <form action="{{ route('admin.booking.remove') }}" method="post" class="save-form">
                                                @csrf
                                                <input type="hidden" name="choices[]" value="${event.id}">
                                                <button type="button" class="btn-close btn-delete-booking" data-date-selected="${moment(event.appointment_at).format('DD/MM/YYYY')}" aria-label="Close">
                                                </button>
                                            </form>
                                        @endif
                                        <span class="d-inline-block">${hour}:00 <small class="badge rounded-pill bg-${badgeColor}">${status}</small></span>
                                        <p class="fs-5 mb-1 fw-bold btn-update-booking" data-id="${event.id}">${event.name}</p>
                                        ${event._pet ? `<small class="mb-1 fw-bold">${event._pet.name}<br>${event._pet._customer.name}${event._pet._customer.phone ? ` - <a href="tel:${event._pet._customer.phone}">${event._pet._customer.phone}</a>` : ''}</small>` : ''}
                                        <small class="text-secondary">${event.note ? event.note : ''}</small>
                                    </div>
                                </div>`;
                    divDay.find('.timeline').append(card)
                    if (divDay.find('.dots ul>li').length < 7) {
                        if (event.service_id != null) {
                            divDay.find('.dots ul').append(`<li class="ms-2 d-inline-block">
                                        <div class="p-2 bg-${dotColor} border-light rounded-circle mt-2" data-bs-toggle="tooltip" data-bs-title="${event._service.name}"></div>
                                    </li>`)
                        } else {
                            divDay.find('.dots ul').append(`<li class="ms-2 d-inline-block">
                                        <div class="p-2 bg-danger border-light rounded-circle mt-2" data-bg="bg-light-danger" data-bs-toggle="tooltip" data-bs-title="${event.name}"></div>
                                    </li>`)
                        }
                        divDay.find('.timeline .card').addClass(divDay.find('.dots li').attr('data-bg'))
                    } else if (divDay.find('.dots ul>li').length == 7) {
                        divDay.find('.dots ul').append(`<li class="ms-2 d-inline-block mt-2 text-secondary">+${count.length - 7}</li>`)
                    }
                })
            })
        }

        function initMenu() {
            var block = $(".dots");
            block.addClass("clickable");
            block.hover(function() {
                window.status = $(this)
            }, function() {
                window.status = ""
            });

            block.click(
                function() {
                    // $(this).parents('div:eq(0)').find('.open').slideToggle('slow');
                    $(this).closest('.week').find('.open').slideToggle('slow');
                }
            );
        }

        //Tính số ngày trong tháng
        function howManyDate(dateTime) {
            switch (dateTime.getMonth() + 1) {
                case 1:
                case 3:
                case 5:
                case 7:
                case 8:
                case 10:
                case 12:
                    return 31;
                case 2:
                    if (isLeapYear(dateTime.getFullYear())) {
                        return 29;
                    } else {
                        return 28;
                    }
                case 4:
                case 6:
                case 9:
                case 11:
                    return 30;
            }
        }

        //Kiểm tra năm nhuận
        function isLeapYear(yr) {
            if (yr % 4 === 0) {
                if (yr % 100 === 0) {
                    if (yr % 400 === 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        let monthOptions = `<option selected hidden disabled>Chọn tháng</option>`,
            yearOptions = '<option selected hidden disabled>Chọn năm</option>';
        for (var i = 1; i <= 12; i++) {
            monthOptions += `<option value="${i}">Tháng ${i}</option>`
        }
        $('#month-picker').html(monthOptions).val(new Date().getMonth() + 1)
        for (var i = (new Date().getFullYear()) - 2; i <= (new Date().getFullYear()) + 2; i++) {
            yearOptions += `<option value="${i}">Năm ${i}</option>`
        }

        $('#year-picker').html(yearOptions).val(new Date().getFullYear())
        showCalendar([$('#year-picker').val(), $('#month-picker').val()])
        //Cập nhật lịch khi người dùng đổi khoảng thời gian
        $('#month-picker').add('#year-picker').change(function() {
            $(`#listwork`).empty();
            showCalendar([$('#year-picker').val(), $('#month-picker').val()])
        })

        function makeColor(id) {
            let valColor = 0;
            valColor = (id * 73) % 360
            return valColor;
        }
    </script>
@endpush
