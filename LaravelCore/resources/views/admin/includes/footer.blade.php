<footer>
    <div class="footer clearfix mb-0 p-4 text-muted">
        <div class="float-start">
            <p>{{ date('Y') }} &copy; {{ Auth::user()->branch ? Auth::user()->branch->name : 'SMS' }}</p>
        </div>
        <div class="float-end">
            <p>Thiết kế và xây dựng với <span class="text-danger"><i class="bi bi-heart"></i></span>
                từ <a href="#">H.Đăng</a></p>
        </div>
    </div>
</footer>