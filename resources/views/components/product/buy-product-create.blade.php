<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Product Cost</label>
                                <input type="text" class="form-control" id="productCost">

                                <label class="form-label mt-2">Carring Cost</label>
                                <input type="text" class="form-control" id="carringCost">

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Invoice File Upload</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="InvoiceImg">

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>



    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        })
    }


    async function Save() {

        let productCategory=document.getElementById('productCategory').value;
        let productCost = document.getElementById('productCost').value;
        let carringCost = document.getElementById('carringCost').value;
        let InvoiceImg = document.getElementById('InvoiceImg').files[0];

        if (productCategory.length === 0) {
            errorToast("Product Category Required !")
        }
        else if(productCost.length===0){
            errorToast("Product Name Required !")
        }
        else if(carringCost.length===0){
            errorToast("Product Price Required !")
        }
        else if(!InvoiceImg){
            errorToast("Product Image Required !")
        }

        else {

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('invoice_url',InvoiceImg)
            formData.append('product_cost',productCost)
            formData.append('other_cost',carringCost)
            formData.append('category_id',productCategory)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/buying-details-store",formData,config)
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
