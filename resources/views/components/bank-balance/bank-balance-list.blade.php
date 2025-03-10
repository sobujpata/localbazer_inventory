<div class="container-fluid mobile-view">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-1 py-4">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Bank Loan Repay</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-secondary"/>
            <div class="table-responsive">
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Payer</th>
                    <th>Bank Name</th>
                    <th>Pay Amount</th>
                    <th>Total Pay</th>
                    <th>Balance</th>
                    <th>Installment No</th>
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
</div>

<script>

getList();


async function getList() {


    showLoader();
    let res=await axios.get("/list-loan-repay-balance");
    hideLoader();
// console.log(res)
    let tableList=$("#tableList");
    let tableData=$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.forEach(function (item,index) {
        let row=`<tr>
                    <td>${index+1}</td>
                    <td>${item['user']['firstName']} ${item['user']['lastName']}</td>
                    <td>${item['banks']['loan_type']}, ${item['banks']['bank_name']}</td>
                    <td>${item['pay_amount']}</td>
                    <td>${item['total_pay']}</td>
                    <td>${item['balance']}</td>
                    <td>${item['installment_no']}</td>
                    <td>
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success"><i class="fa text-sm fa-pen"></i></button>
                        <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger ${res.data['role'] === '1'?'':'d-none'}"><i class="fa text-sm  fa-trash-alt"></i></button>
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
       lengthMenu:[10,15,20,30]
   });

}


</script>

