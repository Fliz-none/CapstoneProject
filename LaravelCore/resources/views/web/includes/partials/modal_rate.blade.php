<form class="save-form" id="order-rate-form" method="post" enctype="multipart/form-data" action="{{ route('profile.order_rate') }}">
    @csrf
    <div class="modal fade" id="order-rate-modal" data-bs-backdrop="static" aria-labelledby="order-rate-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title text-white fs-5" id="order-rate-modal-label">Đánh giá sản phẩm</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body overflow-auto"  style="max-height: 55vh">
                </div>
                <div class="modal-footer my-1">
                    <div class="text-end">
                        <input name="id" type="hidden" value="">
                        <button class="key-btn-dark" data-text="Đánh giá" type="submit">Đánh giá</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
