<div class="container-fluid mobile-view">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-1 py-4">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Balance Sheet</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Payer</th>
                    <th>Recipient</th>
                    <th>Reason</th>
                    <th>Amount</th>
                    <th>Balanch</th>
                    <th>Date</th>
                    <th class="${res.data['role'] === '1'?'':'d-none'}">Action</th>
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
    let res=await axios.get("/list-costing");
    hideLoader();
    // console.log(res.data['role']);

    let tableList=$("#tableList");
    let tableData=$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.data.forEach(function (item,index) {
        const createdAt = new Date(item.created_at);
        const formattedDate = createdAt.toLocaleString('en-GB', {
                timeZone: 'Asia/Dhaka',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });
        let row=`<tr>
                    <td class="text-center">${index+1}</td>
                    <td>${item['user']['firstName']} ${item['user']['lastName']}</td>
                    <td>${item['recipient']}</td>
                    <td>${item['reason']}</td>
                    <td>${item['amount']}</td>
                    <td>${item['balance']}</td>
                    <td>${formattedDate}</td>
                    <td>
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success ${res.data['role'] === '1'?'':'d-none'}">Edit</button>
                    </td>
                 </tr>`
        tableList.append(row)
    })

    $('.editBtn').on('click', async function () {
           let id= $(this).data('id');
           await FillUpUpdateForm(id)
           $("#update-modal").modal('show');
    })

    $('.deleteBtn').on('click',function () {
        let id= $(this).data('id');
        $("#delete-modal").modal('show');
        $("#deleteID").val(id);
    })

    new DataTable('#tableData',{
        order:[[0,'desc']],
        lengthMenu:[20,30,50,100,500]
    });

}


</script>

