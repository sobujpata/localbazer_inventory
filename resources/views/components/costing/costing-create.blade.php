<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Sector of Spending Money</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Recipient Name *</label>
                                <input type="text" class="form-control" id="recipientName" name="recipientName" required>
                                
                                <label class="form-label">Reason *</label>
                                <select name="reason" id="reason" class="form-control form-select" required>
                                    <option value="" disabled selected>Select Reason</option>
                                    <option value="Salary">Salary</option>
                                    <option value="Borrow">Borrow Money</option>
                                </select>
                                
                                <label class="form-label">Amount *</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function Save() {
        let recipientName = document.getElementById('recipientName').value;
        let reason = document.getElementById('reason').value;
        let amount = document.getElementById('amount').value;

        if (recipientName.trim() === "") {
            errorToast("Recipient Name Required!");
        }
        else if (amount.trim() === "") {
            errorToast("Amount Required!");
        }
        else if (reason.trim() === "") {
            errorToast("Reason Required!");
        }
        else {
            document.getElementById('modal-close').click();
            showLoader();

            try {
                let res = await axios.post("/create-costing", {
                    recipient: recipientName,
                    reason: reason,
                    amount: amount
                });
                hideLoader();

                if (res.status === 201) {
                    successToast('Request completed');
                    document.getElementById("save-form").reset();
                    await getList();
                } else {
                    errorToast("Request failed!");
                }
            } catch (error) {
                hideLoader();
                errorToast("Request failed!");
            }
        }
    }
</script>
