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
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6"></div>
            </div>
        </div>
        @if (session('response') && session('response')['status'] == 'success')
            <div class="alert key-bg-primary alert-dismissible fade show text-white" role="alert">
                <i class="fas fa-check"></i>
                {!! session('response')['msg'] !!}
                <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            </div>
        @elseif (session('response'))
            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <i class="fa-solid fa-xmark"></i>
                {!! session('response')['msg'] !!}
                <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            </div>
        @elseif ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <i class="fa-solid fa-xmark"></i>
                    {{ $error }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        @if (!$conditions['isCheckoutTime'] && !$conditions['isCheckin'] && $conditions['hasWork'])
            <div class="alert alert-warning alert-dismissible fade show text-white" role="alert">
                <i class="fa-solid fa-xmark"></i>
                Checkout is allowed, but not recommended at this time.
                <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
            </div>
        @endif
        <section class="section">
            <div class="card work-card">
                @if ($agent->isMobile())
                    <div class="card-header pb-0 text-center">
                        @if (isset(session('response')['work']) || isset($work))
                            @php
                                $work = session('response')['work'] ?? $work;
                            @endphp
                            <div class="work-clock fw-bold text-primary" style="font-size: calc(1rem + 0.5vw);"></div>
                        @endif
                    </div>
                    @if ($conditions['hasWork'])
                        {{-- Còn ca để chấm công --}}
                        <form id="work-form" action="{{ route('admin.work.timekeeping') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h6 class="my-3 text-primary">Confirm you are at <br> {{ Auth::user()->branch->name }}</h6>
                                    {!! $conditions['isCheckin'] ? '<span class="badge bg-success fs-6 btn-checkin">Check in</span>' : '<span class="badge bg-info fs-6 btn-checkout">Check out</span>' !!}
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12 work-webcam p-0 d-flex justify-content-center"></div>
                                    <div class="col-12 work-image-taken d-none"></div>
                                </div>
                            </div>
                            <div class="card-footer border-0 text-center d-none">
                                <input name="work_image" type="hidden">
                                <button class="btn btn-primary btn-taken-photo" type="button">Take photo</button>
                                <button class="btn btn-primary btn-create-work d-none" type="submit">Confirm</button>
                            </div>
                        </form>
                    @else
                        <div class="card-body text-center text-primary">
                            <div class="work-done-icon">
                                <i class="bi bi-calendar-check" style="font-size: calc(10rem + 1.5vw);"></i>
                            </div>
                            <span class="fs-5 text-primary fw-bold">You have completed your timekeeping for today</span>
                        </div>
                    @endif
                @else
                    <div class="card-body text-center text-primary">
                        <div class="work-done-icon">
                            <i class="bi bi-phone" style="font-size: calc(10rem + 1.5vw);"></i>
                        </div>
                        <span class="fs-5 text-primary fw-bold">Please use your phone to check in or check out</span>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('admin/vendors/webcamjs/html2canvas.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/vendors/webcamjs/webcam.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.btn-checkin').add('.btn-checkout').on('click', function() {
                $('#work-form .card-footer').removeClass('d-none');
                attachCamera();
            })

            $(document).on('click', '.btn-create-work', function() {
                $(this).text('loading...').prop('disabled', true);
                $('#work-form').submit();
            })

            function attachCamera() {
                Webcam.set({
                    width: 480,
                    height: 640,
                    image_format: 'jpeg',
                    jpeg_quality: 80,
                });
                $('.work-webcam').length ? Webcam.attach('.work-webcam') : '';
            }

            @if (isset($work) && $work->real_checkin)
                setInterval(() => {
                    showTime('{{ $work->real_checkin }}');
                }, 1000);
            @endif

            function showTime(timeBegin) {
                if (!timeBegin || timeBegin == '') {
                    $('.work-clock').text(`You have worked: ...`);
                } else {
                    var now = moment();
                    var duration = moment.duration(now.diff(moment(timeBegin)));
                    let hours = Math.floor(duration.asHours()).toString().padStart(2, '0'),
                        minutes = duration.minutes().toString().padStart(2, '0'),
                        seconds = duration.seconds().toString().padStart(2, '0');
                    $('.work-clock').text(`You have worked: ${hours}:${minutes}:${seconds}`);
                }
            }

            // preload shutter audio clip
            const sound = new Audio(`{{ asset('admin/vendors/webcamjs/shutter.ogg') }}`)

            $(document).on('click', '.btn-taken-photo', function() {
                // play sound effect
                const form = $('#work-form');
                sound.play();
                $(this).addClass('d-none')
                // take snapshot and get image data
                Webcam.snap(function(data_uri) {
                    form.find('input[name=work_image]').val(data_uri);
                    form.find('.work-image-taken').html(`<img id="work-image-preview" class="img-fluid" src="${data_uri}"/>`)
                    form.find('.work-webcam').addClass('d-none');
                    form.find('.work-image-taken').removeClass('d-none'); //hiện ảnh
                    form.find('.btn-create-work').removeClass('d-none'); //hiện nút submit
                });
                Webcam.reset();
            })
        })
    </script>
@endpush
