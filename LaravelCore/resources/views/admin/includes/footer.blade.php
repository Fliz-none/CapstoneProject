<footer>
    <div class="footer clearfix mb-0 p-4 text-muted">
        <div class="float-start">
            <p>{{ date('Y') }} &copy; {{ cache('settings_' . Auth::user()->company_id)['company_brandname'] }}</p>
        </div>
        <div class="float-end">
            <p>Thiết kế và xây dựng với <span class="text-danger"><i class="bi bi-heart"></i></span>
                từ <a href="https://keydigital.vn">Key Digital</a></p>
        </div>
    </div>
</footer>