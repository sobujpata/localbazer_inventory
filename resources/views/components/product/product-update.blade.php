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
                                <label class="form-label">Category</label>
                                <select type="text" name="category" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Bangla Name</label>
                                <input type="text" name="name" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-2">English Name</label>
                                <input type="text" name="eng_name" class="form-control" id="productEngNameUpdate">

                                <label class="form-label mt-2">Original Price</label>
                                <input type="text" name="buy_price" class="form-control" id="productOriginalPriceUpdate">

                                <label class="form-label mt-2">Sale price</label>
                                <input type="text" name="wholesale_price" class="form-control" id="productSalePriceUpdate">

                                <label class="form-label mt-2">Quantity</label>
                                <input type="text" name="buy_qty" class="form-control" id="productQtyUpdate">
                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>
                                <label class="form-label mt-2">Image</label>
                                {{-- <input name="invoice_url"  type="file" class="form-control" id="productImgUpdate"> --}}
                                <input name="invoice_url" oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="productImgUpdate">
                                
                                <input name="id" type="text" class="" id="updateID">
                                <input name="filePath" type="text" class="" id="filePath">


                            </div>
                        </div>
                    </div>
                    
                </form>
                <div class="modal-footer">
                    <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="update()" type="submit" id="update-btn" class="btn bg-gradient-success" >Update</button>
                </div>
                {{-- <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success" >Update</button> --}}
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
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;


        showLoader();
        // await UpdateFillCategoryDropDown();

        let res=await axios.post("/product-by-id",{id:id})
        hideLoader();
        // console.log(res);

        document.getElementById('productCategoryUpdate').value=res.data['category_id'];
        document.getElementById('productNameUpdate').value=res.data['name'];
        document.getElementById('productEngNameUpdate').value=res.data['eng_name'];
        document.getElementById('productOriginalPriceUpdate').value=res.data['buy_price'];
        document.getElementById('productSalePriceUpdate').value=res.data['wholesale_price'];
        document.getElementById('productQtyUpdate').value=res.data['buy_qty'];

    }

    async function update() {

let productCategoryUpdate=document.getElementById('productCategoryUpdate').value;
let productNameUpdate = document.getElementById('productNameUpdate').value;
let productEngNameUpdate = document.getElementById('productEngNameUpdate').value;
let productOriginalPriceUpdate = document.getElementById('productOriginalPriceUpdate').value;
let productSalePriceUpdate = document.getElementById('productSalePriceUpdate').value;
let productQtyUpdate = document.getElementById('productQtyUpdate').value;

let updateID=document.getElementById('updateID').value;
let filePath=document.getElementById('filePath').value;
let productImgUpdate = document.getElementById('productImgUpdate').files[0];


if (productNameUpdate.length === 0) {
        errorToast("Product Bangla Name Required!");
    } else if (productEngNameUpdate.length === 0) {
        errorToast("Product English Name Required!");
    } else if (productOriginalPriceUpdate.length === 0) {
        errorToast("Product Original Price Required!");
    } else if (productQtyUpdate.length === 0) {
        errorToast("Product Quantity Required!");
    } else if (isNaN(productOriginalPriceUpdate)) {
        errorToast("Original Price must be a number!");
    } else if (isNaN(productQtyUpdate)) {
        errorToast("Quantity must be a number!");
    }

else {

    document.getElementById('update-modal-close').click();
    let formData=new FormData();
        formData.append('id', updateID);
        formData.append('name', productNameUpdate);
        formData.append('eng_name', productEngNameUpdate);
        formData.append('buy_price', productOriginalPriceUpdate);
        formData.append('wholesale_price', productSalePriceUpdate);
        formData.append('buy_qty', productQtyUpdate);
        formData.append('category_id', productCategoryUpdate);
        formData.append('file_path', filePath);
    

    const config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    }

    showLoader();
    let res = await axios.post("/update-product",formData,config)
    hideLoader();
    console.log(res)

    if(res.status===200){
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
