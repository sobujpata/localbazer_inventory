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
                                <label class="form-label" for="Name">Recipient Name *</label>
                                <input type="text" class="form-control" id="recipientName" name="recipientName" placeholder="Enter Recipient Name" required>

                                <label class="form-label">Reason *</label>
                                <select name="reason" id="reason" class="form-control form-select" required>
                                    <option value="" disabled selected>Select Reason</option>
                                    <option value="Buying">Buying Products</option>
                                    <option value="Salary">Salary</option>
                                    <option value="Withdraw">Withdraw</option>
                                </select>
                                <label class="form-label">Total Collection</label>
                                <input type="text" id="collection" value="" placeholder="Total Collection" class="form-control" readonly>
                                <label class="form-label">Total Cost</label>
                                <input type="text" id="totalCost" value="" placeholder="Total Cost" class="form-control" readonly>

                                <label class="form-label">Amount *</label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Cost Amount" required>
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
    // Fetch the collection and total cost from the server
    async function fillUpForm() {
        try {
            let res = await axios.get('/summary');
            document.getElementById('collection').value = res.data['total_deposit_with_collection'] || 0;
            document.getElementById('totalCost').value = res.data['total_cost'] || 0;
        } catch (error) {
            console.error("Error fetching summary:", error);
            document.getElementById('collection').value = 0;
            document.getElementById('totalCost').value = 0;
            errorToast("Failed to load summary data.");
        }
    }

    // Call fillUpForm on page load to populate values
    fillUpForm();

    // Save the new costing entry
    async function Save() {
    let recipientName = document.getElementById('recipientName').value;
    let reason = document.getElementById('reason').value;
    let collection = parseInt(document.getElementById('collection').value) || 0;
    let totalCost = parseInt(document.getElementById('totalCost').value) || 0;
    let amount = parseInt(document.getElementById('amount').value) || 0;

    // Calculate balance
    let balance = parseInt(collection) - (parseInt(totalCost) + parseInt(amount));

    console.log(balance)

    // Validation messages if fields are empty
    if (recipientName.trim() === "") {
        errorToast("Recipient Name Required!");
    } else if (amount <= 0) {
        errorToast("Amount must be greater than 0!");
    } else if (reason.trim() === "") {
        errorToast("Reason Required!");
    } else {
        document.getElementById('modal-close').click();
        showLoader();

        try {
            // Axios POST request
            let res = await axios.post("/create-costing", {
                recipient: recipientName,
                reason: reason,
                amount: amount,
                balance: balance
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
            console.error("Error:", error.response.data);  // Log the error response
            errorToast("Request failed!");
        }
    }
}

</script>
