<div class="container-fluid mobile-view">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-1 py-4">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Buy Products</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0  bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>Ser No</th>
                    <th>Products Category</th>
                    <th>Product Cost</th>
                    <th>Date</th>
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
    let res=await axios.get("buying-details");
    hideLoader();

    // console.log(res);



    let tableList=$("#tableList");
    let tableData=$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.data.forEach(function (item,index) {
        const createdAt = new Date(item.created_at);
        // const formattedDate = createdAt.toISOString().split('T')[0]; // '2024-10-10'
        const formattedDate = createdAt.toLocaleString('en-GB', {
                timeZone: 'Asia/Dhaka',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                // hour: '2-digit',
                // minute: '2-digit',
                // second: '2-digit',
            }); // '2024-10-10'

        let row=`<tr>
                    <td>${index+1}</td>
                    <td>${item['category']['name']}</td>
                    <td>${item['product_cost']}</td>

                    <td>${formattedDate}</td>
                    <td>
                        <button data-path="${item['invoice_url']}" data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success"><i class="fa text-sm  fa-pen"></i></button>

                        <button class="btn btn-sm btn-outline-primary"><a href="${item['invoice_url']}" target="_blank"><i class="fa text-sm  fa-eye"></i></a> </button>
                        <button data-path="${item['invoice_url']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger ${res.data['role'] === '1'?'':'d-none'}"><i class="fa text-sm  fa-trash"></i></button>
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
        order:[[0,'desc']],
        lengthMenu:[10,20,30,50,100,500]
    });

}


</script>

