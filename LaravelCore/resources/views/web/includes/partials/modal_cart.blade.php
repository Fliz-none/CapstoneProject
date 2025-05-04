<!-- cartModal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasCartLabel">Giỏ hàng của bạn</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="m-1">
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-12 text-center">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('images/cart-x.png') }}" alt="" class="img-fluid mb-2"
                        style="width: 50px;">
                </div>
                <p>Không có sản phẩm nào trong giỏ hàng</p>
            </div>
        </div>
    </div>
    <hr class="m-1">
    <div class="offcanvas-footer p-4">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-3 fw-bold">
                    <trong>Tạm tính: 0đ</trong>
                </p>
                <a href="#" class="btn btn-warning" style="width: 100%;">Thanh toán</a>
            </div>
        </div>
    </div>
</div>
<!-- end cartModal -->
