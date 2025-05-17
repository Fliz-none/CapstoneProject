@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
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
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        @include('admin.includes.quick_images')
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        showQuickImages()
    </script>
@endpush