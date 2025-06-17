<footer>
    <div class="footer clearfix mb-0 p-4 text-muted">
        <div class="float-start">
            <p>{{ date('Y') }} &copy; {{ Auth::user()->branch ? Auth::user()->branch->name : 'SMS' }}</p>
        </div>
        <div class="float-end">
            <p>{{ __('messages.built') }} <span class="text-danger"><i class="bi bi-heart"></i></span>{{ __('messages.by') }} <a href="#">SMS</a></p>
        </div>
    </div>
</footer>