<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-1 py-4">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Product</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0  bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>Image</th>
                    <th>Name</th>
                    <th>Buy Price</th>
                    <th>Sale Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>

getList();


async function getList() {
    showLoader();
    let res=await axios.get("/list-product");
    hideLoader();

    let tableList=$("#tableList");
    let tableData=$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.data.forEach(function (item,index) {
        let row = `<tr style="${item['buy_qty'] <= '0' ? 'background-color: red; color:white;' : ''}">
                    <td><img style="width: 70px; height: 80px;" alt="" src="${item['img_url']}"></td>
                    <td>${item['name']} <br> ${item['eng_name']}</td>
                    <td>${item['buy_price']}</td>
                    <td>${item['wholesale_price']}</td>
                    <td>${item['buy_qty']}</td>
                    <td>
                        <button data-path="${item['img_url']}" data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button data-path="${item['img_url']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger ${res.data['role'] === '1'?'':'d-none'}">Delete</button>
                    </td>
                 </tr>`
        tableList.append(row)
    })

    $('.editBtn').on('click', async function () {
           let id= $(this).data('id');
           let filePath= $(this).data('path');
           await FillUpUpdateForm(id,filePath)
           $("#update-modal").modal('show');
    })

    $('.deleteBtn').on('click',function () {
        let id= $(this).data('id');
        let path= $(this).data('path');

        $("#delete-modal").modal('show');
        $("#deleteID").val(id);
        $("#deleteFilePath").val(path)

    })

    new DataTable('#tableData',{
        // order:[[0,'desc']],
        lengthMenu:[10,15,20,30, 100]
    });

}
</script>

