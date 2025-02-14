<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Monthly Installment</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Bank Loan Type *</label>
                                <select type="text" class="form-control form-select" id="LoanType">
                                    <option disable selected>Select Bank Loan Type</option>
                                </select>
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Bank Name *</label>
                                <input type="text" class="form-control" id="BankName" readonly>
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Monthly Instalment *</label>
                                <input type="number" class="form-control" id="installment" readonly>
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
    getBankLoanType()
    async function getBankLoanType(){
        let res = await axios.get('/list-bank');
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['loan_type']}</option>`
            $("#LoanType").append(option);
        })

    }
    document.getElementById('LoanType').addEventListener('change', function() {
        let id = this.value;
        if (id) {
            axios.get(`/get-bank-loan-by-id/${id}`)
                .then(response => {
                    document.getElementById('BankName').value = response.data.bank_name; // Change 'name' to the field you need
                    document.getElementById('installment').value = response.data.total_installment; // Change 'name' to the field you need
                })
                .catch(error => console.error(error));
        } else {
            document.getElementById('BankName').value = '';
            document.getElementById('installment').value = '';
        }
    });
    async function Save() {
        let loanType = document.getElementById('LoanType').value;
        let installment = document.getElementById('installment').value;
        if (loanType.length === 0) {
            errorToast("Loan type Required !")
        }
        
        if (installment.length === 0) {
            errorToast("Installment amount Required !")
        }
        else {
            document.getElementById('modal-close').click();
            showLoader();
            let res = await axios.post("/create-loan-repay-balance",{
                loan_type :loanType,
                total_installment :installment,
            })
            hideLoader();
            console.log(res);
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
