
<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

                                <label class="form-label mt-2">Bangla Name</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label mt-2">English Name</label>
                                <input type="text" class="form-control" id="productEngName">

                                <label class="form-label mt-2">Original Price</label>
                                <input type="text" class="form-control" id="productOriginalPrice">

                                <label class="form-label mt-2">Sale Price</label>
                                <input type="text" class="form-control" id="productPrice">

                                <label class="form-label mt-2">Quantity</label>
                                <input type="text" class="form-control" id="productQty">

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">

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
        res.data.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        })
    }


    async function Save() {

        let productCategory=document.getElementById('productCategory').value;
        let productName = document.getElementById('productName').value;
        let productEngName = document.getElementById('productEngName').value;
        let productOriginalPrice = document.getElementById('productOriginalPrice').value;
        let productPrice = document.getElementById('productPrice').value;
        let productQty = document.getElementById('productQty').value;
        let productImg = document.getElementById('productImg').files[0];

        if (productCategory.length === 0) {
            errorToast("Product Category Required !")
        }
        else if(productName.length===0){
            errorToast("Product Name Required !")
        }
        else if(productEngName.length===0){
            errorToast("Product English Name Required !")
        }
        else if(productPrice.length===0){
            errorToast("Product Price Required !")
        }
        else if(productQty.length===0){
            errorToast("Product Unit Required !")
        }
        else if(!productImg){
            errorToast("Product Image Required !")
        }

        else {

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('img',productImg)
            formData.append('name',productName)
            formData.append('eng_name',productEngName)
            formData.append('buy_price',productOriginalPrice)
            formData.append('wholesale_price',productPrice)
            formData.append('buy_qty',productQty)
            formData.append('category_id',productCategory)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/create-product",formData,config)
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
