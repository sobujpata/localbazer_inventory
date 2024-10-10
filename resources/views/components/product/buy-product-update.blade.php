<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Buy Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Product Cost</label>
                                <input type="text" class="form-control" id="productCostUpdate">

                                <label class="form-label mt-2">Carring Cost</label>
                                <input type="text" class="form-control" id="carringCostUpdate">

                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>
                                <label class="form-label mt-2">Invoice File Update</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="InvoiceImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>

        </div>
    </div>
</div>


<script>



    async function UpdateFillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategoryUpdate").append(option);
        })
    }


    async function FillUpUpdateForm(id,filePath){

        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;


        showLoader();
        await UpdateFillCategoryDropDown();

        let res=await axios.post("/buying-details-by-id",{id:id})
        hideLoader();

        document.getElementById('productCostUpdate').value=res.data['product_cost'];
        document.getElementById('carringCostUpdate').value=res.data['other_cost'];
        document.getElementById('InvoiceImgUpdate').value=res.data['invoice_url'];
        document.getElementById('productCategoryUpdate').value=res.data['category_id'];

    }



    async function update() {

        let productCostUpdate=document.getElementById('productCostUpdate').value;
        let carringCostUpdate = document.getElementById('carringCostUpdate').value;
        let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
        let productUnitUpdate = document.getElementById('productUnitUpdate').value;
        let updateID=document.getElementById('updateID').value;
        let filePath=document.getElementById('filePath').value;
        let InvoiceImgUpdate = document.getElementById('InvoiceImgUpdate').files[0];


        if (productCategoryUpdate.length === 0) {
            errorToast("Product Category Required !")
        }
        else if(productCostUpdate.length===0){
            errorToast("Product Name Required !")
        }
        else if(carringCostUpdate.length===0){
            errorToast("Product Price Required !")
        }
        else {

            document.getElementById('update-modal-close').click();

            let formData=new FormData();
            formData.append('invoice_url',InvoiceImgUpdate)
            formData.append('id',updateID)
            formData.append('product_cost',productCostUpdate)
            formData.append('other_cost',carringCostUpdate)
            formData.append('category_id',productCategoryUpdate)
            formData.append('file_path',filePath)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/buying-details-update",formData,config)
            hideLoader();

            if(res.status===200 && res.data===1){
                successToast('Request completed');
                document.getElementById("update-form").reset();
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script>
