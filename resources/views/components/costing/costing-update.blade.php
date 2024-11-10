<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form" enctype="multipart/form-data">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label" for="Name">Recipient Name *</label>
                                <input type="text" class="form-control" id="recipientNameUpdate" name="recipientName" placeholder="Enter Recipient Name" required>

                                <label class="form-label">Reason *</label>
                                <select name="reason" id="reasonUpdate" class="form-control form-select" required>
                                    <option value="" disabled selected>Select Reason</option>
                                    <option value="Buying">Buying Products</option>
                                    <option value="Salary">Salary</option>
                                    <option value="Withdraw">Withdraw</option>
                                    <option value="Buy Bag">Buy Bag</option>
                                    <option value="Other Cost">Other Cost</option>
                                </select>
                                {{-- <label class="form-label">Total Collection</label>
                                <input type="text" id="collectionUpdate" value="" placeholder="Total Collection" class="form-control" readonly>
                                <label class="form-label">Total Cost</label>
                                <input type="text" id="totalCostUpdate" value="" placeholder="Total Cost" class="form-control" readonly> --}}

                                <label class="form-label">Amount *</label>
                                <input type="number" class="form-control" id="amountUpdate" name="amount" placeholder="Enter Cost Amount" required>

                                <label class="form-label">Balance *</label>
                                <input type="number" class="form-control" id="balanceUpdate" name="balance" placeholder="Enter Cost balance" required>

                                <input name="id" type="text" class="d-none" id="updateID">

                            </div>
                        </div>
                    </div>

                </form>
                <div class="modal-footer">
                    <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="update()" type="submit" id="update-btn" class="btn bg-gradient-success" >Update</button>
                </div>

            </div>
        </div>
    </div>
</div>


<script>



    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategoryUpdate").append(option);
        })
    }


    async function FillUpUpdateForm(id,filePath){
        document.getElementById('updateID').value=id;
        showLoader();

        let res=await axios.post("/costing-by-id",{id:id})
        let resSummary = await axios.get('/summary');
        hideLoader();
        // console.log(res);

        document.getElementById('recipientNameUpdate').value=res.data['recipient'];
        document.getElementById('reasonUpdate').value=res.data['reason'];
        // document.getElementById('collectionUpdate').value=resSummary.data['total_deposit_with_collection'];
        // document.getElementById('totalCostUpdate').value=resSummary.data['total_cost'];
        document.getElementById('amountUpdate').value=res.data['amount'];
        document.getElementById('balanceUpdate').value=res.data['balance'];

    }

    async function update() {

    let recipientNameUpdate=document.getElementById('recipientNameUpdate').value;
    let reasonUpdate = document.getElementById('reasonUpdate').value;
    let amountUpdate = document.getElementById('amountUpdate').value;
    let balanceUpdate = document.getElementById('balanceUpdate').value;

    let updateID=document.getElementById('updateID').value;



    if (recipientNameUpdate.length === 0) {
            errorToast("Product Recipient Required!");
        } else if (reasonUpdate.length === 0) {
            errorToast("Product Reason Required!");
        } else if (amountUpdate.length === 0) {
            errorToast("Product amoun Required!");
        } else if (balanceUpdate.length === 0) {
            errorToast("Product balance Required!");
        }

    else {

        document.getElementById('update-modal-close').click();
        let formData=new FormData();
            formData.append('id', updateID);
            formData.append('recipient', recipientNameUpdate);
            formData.append('reason', reasonUpdate);
            formData.append('amount', amountUpdate);
            formData.append('balance', balanceUpdate);


        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

        showLoader();
        let res = await axios.post("/update-costing",formData,config)
        hideLoader();
        // console.log(res)

        if(res.status===200){
            successToast('Request updated completed');
            document.getElementById("update-form").reset();
            await getList();
        }
        else{
            errorToast("Request fail !")
        }
    }
}


</script>
