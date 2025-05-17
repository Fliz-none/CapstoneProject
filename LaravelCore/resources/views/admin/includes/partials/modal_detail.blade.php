<form class="save-form" id="detail-form" method="post">
    @csrf
    <div class="modal fade" id="detail-modal" data-bs-backdrop="static" aria-labelledby="detail-modal-label">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detail-modal-label">Details List</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered key-table" id="detail-table">
                            <thead>
                                <tr>
                                    <th>Order Code</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
