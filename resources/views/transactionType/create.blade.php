<div class="modal fade" id="transactionTypeModal" tabindex="-1" aria-labelledby="transactionTypeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionTypeModalLabel">
                    Add New Transaction Type
                </h5>
                <button type="button" class="btn-close" onclick="hideModal()"  data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name" class="d-flex mx-1">
                            Transaction Type Name
                            <span class="text-danger mx-1">*</span>
                        </label>
                        <input type="hidden" class="form-control" id="action_type" value="create" />
                        <input type="hidden" class="form-control" id="tt_id" value="" />
                        <input class="form-control" id="createTransactionName" name="name" value="{{ old('name') }}"
                            placeholder="Enter a Transaction Type Name" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideModal()"  data-dismiss="modal">
                    Close
                </button>
                <button type="button" onclick="submitBtn()" data-dismiss="modal" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
