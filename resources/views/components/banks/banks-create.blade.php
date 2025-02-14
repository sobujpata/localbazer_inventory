<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create bank</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Bank Name *</label>
                                <input type="text" class="form-control" id="bankName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Loan Type *</label>
                                <input type="text" class="form-control" id="loanType">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Loan Amount *</label>
                                <input type="number" class="form-control" id="loanAmount">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Total Repay Amount *</label>
                                <input type="number" class="form-control" id="repayAmount">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Monthly Instalment *</label>
                                <input type="number" class="form-control" id="installment">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>
    async function Save() {
        let bankName = document.getElementById('bankName').value;
        let loanType = document.getElementById('loanType').value;
        let loanAmount = document.getElementById('loanAmount').value;
        let repayAmount = document.getElementById('repayAmount').value;
        let installment = document.getElementById('installment').value;
        if (bankName.length === 0) {
            errorToast("Name Required !")
        }
        if (loanType.length === 0) {
            errorToast("Loan type Required !")
        }
        if (loanAmount.length === 0) {
            errorToast("Total loan amount Required !")
        }
        if (repayAmount.length === 0) {
            errorToast("Repay amount Required !")
        }
        if (installment.length === 0) {
            errorToast("Installment amount Required !")
        }
        else {
            document.getElementById('modal-close').click();
            showLoader();
            let res = await axios.post("/create-bank",{
                bank_name:bankName,
                loan_type :loanType,
                loan_amount :loanAmount,
                total_repay_amount :repayAmount,
                total_installment :installment,
            })
            hideLoader();
            if(res.status===201){
                successToast('Request completed');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script>
