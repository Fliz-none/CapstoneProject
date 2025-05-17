<form class="save-form" id="timekeeping-form" method="post">
    @csrf
    <div class="modal fade" id="timekeeping-modal" data-bs-backdrop="static" aria-labelledby="timekeeping-modal-label">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="timekeeping-modal-label">Timekeeping</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p class="badge bg-info mb-1">Registered</p>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="timekeeping-sign_checkin">Check-in Time</span>
                            <input class="form-control" name="sign_checkin" type="time" disabled readonly>
                            <span class="input-group-text" id="timekeeping-sign_checkout">Check-out Time</span>
                            <input class="form-control" name="sign_checkout" type="time" disabled readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="badge bg-info mb-1">Actual</p>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="timekeeping-real_checkin">Check-in Time</span>
                            <input class="form-control" name="real_checkin" type="time">
                            <span class="input-group-text" id="timekeeping-real_checkout">Check-out Time</span>
                            <input class="form-control" name="real_checkout" type="time">
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                <input name="id" type="hidden">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
