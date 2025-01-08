<div class="modal fade" id="addNewSupplierModal" tabindex="-1" role="dialog" aria-labelledby="addNewSupplierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="addNewSupplierModalLabel">
                    Add New Suppliers
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name" class="required">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="contact" class="required">Contact</label>
                            <input type="text" id="contact" class="form-control" placeholder="Enter your contact" />
                            <small class="text-danger fw-bolder" id="contactError" style="display: none;">Invalid Number</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="Enter your email address" />
                            <small class="text-danger fw-bolder" id="emailError" style="display: none;">Invalid Email</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" class="form-control" placeholder="Enter your address" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="others_info">Others Info</label>
                            <textarea id="others_info" class="form-control" placeholder="Enter your additional info" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" id="addNewSupplierSubmitBtn">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
