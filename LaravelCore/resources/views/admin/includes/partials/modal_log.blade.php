<form class="save-form" id="log-form" method="post">
    @csrf
    <div class="modal fade" id="log-modal" data-bs-backdrop="static" aria-labelledby="log-modal-label" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- rộng hơn để dễ đọc -->
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="log-modal-label">Nhật Kí</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Trước khi thay đổi</th>
                                <th>Sau khi thay đổi</th>
                            </tr>
                        </thead>
                        <tbody id="change-comparison-body">
                            <!-- Dữ liệu sẽ được đổ vào đây bằng JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>