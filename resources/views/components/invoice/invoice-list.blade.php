<div class="container-fluid mobile-view">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-1 py-4">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h5>Invoices</h5>
                    </div>
                    <div class="align-items-center col">
                        <a    href="{{url("/salePage")}}" class="float-end btn m-0 bg-gradient-primary">Create Sale</a>
                    </div>
                </div>
                <hr class="bg-dark "/>
                <table class="table table-responsive" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name & Phone</th>
                            <th>Payable</th>
                            <th>Earn</th>
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

    try {
        let res = await axios.get("/invoice-select");
        hideLoader();

        console.log(res);

        let role = res.data.role; // Access the role directly
        let tableList = $("#tableList");
        let tableData = $("#tableData");

        // Reset DataTable
        tableData.DataTable().destroy();
        tableList.empty();

        // Populate the table
        res.data.data.forEach(function (item) {
            let row = `
                <tr>
                    <td>${item['invoice'].id}</td>
                    <td>${item['invoice'].customer.shop_name} <br> ${item['invoice'].customer.mobile}</td>
                    <td>${item['invoice'].payable}</td>
                    <td>${((item['invoice'].payable || 0) - (item['totalBuyPrice'] || 0)).toFixed(2)}</td>

                    <td>
                        <button data-id="${item['invoice'].id}" data-cus="${item['invoice'].customer.id}" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-eye"></i>
                        </button>
                        <a href="/invoice-edit-page/${item['invoice'].id}" class="btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-pen"></i>
                        </a>
                        <button data-id="${item['invoice'].id}" data-cus="${item['invoice'].customer.id}" class="completeBtn btn btn-outline-primary text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm  fa-check"></i></button>

                        <button data-id="${item['invoice'].id}" data-cus="${item['invoice'].customer.id}" class="deleteBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0 ${role === '1' ? '' : 'd-none'}">
                            <i class="fa text-sm fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
            tableList.append(row);
        });

        

    } catch (error) {
        hideLoader();
        console.error(error);
        alert("An error occurred while fetching data. Please try again later.");
    }



    $('.viewBtn').on('click', async function () {
        let id= $(this).data('id');
        let cus= $(this).data('cus');
        await InvoiceDetails(cus,id)
    })

    $('.deleteBtn').on('click',function () {
        let id= $(this).data('id');
        document.getElementById('deleteID').value=id;
        $("#delete-modal").modal('show');
    })
    $('.completeBtn').on('click',function () {
        let id= $(this).data('id');
        document.getElementById('completeID').value=id;
        $("#complete-modal").modal('show');
    })

    new DataTable('#tableData',{
        order:[[0,'desc']],
        lengthMenu:[20,30,50,100,500]
    });

}


</script>

