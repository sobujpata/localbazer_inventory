<!-- Modal -->
<div class="modal animated zoomIn" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Invoice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="invoice" class="modal-body px-2 bg-white">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="row">
                                {{-- <div class="col-2 text-left">

                                 </div> --}}
                                 <div class="col-10 text-center">
                                     <span class="text-center text-bold" style="font-size: 18px; margin-left:30px;">মেসার্স  আর এস আই ট্রেডার্স</span><br>
                                     <span class="text-center fw-bold" style="font-size: 12px; margin-left:30px;">বন্যাকান্দি বাজার, উল্লাপাড়া, সিরাজগঞ্জ <br>
                                        মোবা নং-০১৭৪৫৭৬০২৬৫, ০১৭৭১৩৭৮২৫৮, ০১৭৩৯৮৭১৭০৫
                                        {{-- ই-মেইল : localbazer24@gmail.com --}}
                                    </span>
                                 </div>
                                 <div class="col-2 text-left">
                                    ইন নং : <span id="InvoiceId" class="fw-bold"></span>
                                </div>
                            </div>



                        </div>
                        <div class="row" style="font-size: 10px;">
                            <div class="col-12"><span class="fw-bolder">ক্রেতার বিবরণ :-</span></div>
                            <div class="col-8">দোকানের নাম : <span id="CName" class="fw-bold"></div>
                            <div class="col-4">মোবাইল:<span id="CMobile" class="fw-bold"></div>
                            {{-- <div class="col-6">ই-মেইল : <span id="CEmail" class="fw-bold"></span></div> --}}
                            <div class="col-8">ঠিকানা : <span id="CAddress" class="fw-bold"></span></div>
                            {{-- <div class="col-6">ইনভয়েচ নং : <span id="InvoiceId" class="fw-bold text-2xl"></span></div> --}}
                            <div class="col-4">তারিখ : <span id="invCreateDt"></span></div>
                            <p class="text-xs mx-0 my-1 d-none">User ID:  <span id="CId"></span> </p>
                        </div>
                        <hr class="mx-0 my-2 p-0 bg-secondary"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table w-100" id="invoiceTable">
                            <thead class="w-100">
                            <tr class="text-xs text-bold">
                                <td class="text-center">সিরিয়াল নং</td>
                                <td>পণ্যের নাম</td>
                                <td>পরিমান</td>
                                <td>দর</td>
                                <td>টাকা</td>
                            </tr>
                            </thead>
                            <tbody  class="w-100" id="invoiceList">

                            </tbody>
                        </table>
                    </div>
                </div>


                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row">
                    <div class="col-11">
                        <p class="text-bold text-xs my-1 text-dark text-end"> মোট টাকা : </i> <span id="total"></span>/= </p>
                        <p class="text-bold text-xs my-1 text-dark text-end">(Due Inv-<span id="dueInvoice" class="text-red"></span>) বাকি টাকা : </i> <span id="dueAmount"></span>/= </p>
                        <hr class="mx-0 my-2 p-0 bg-secondary"/>
                        <p class="text-bold text-xs my-2 text-dark text-end"> PAYABLE :</i>  <span id="payable"></span>/=</p>
                        <p class="text-bold text-xs my-1 text-dark d-none"> VAT(5%):</i>  <span id="vat"></span> Tk</p>
                        <p class="text-bold text-xs my-1 text-dark d-none"> Discount:</i>  <span id="discount"></span> Tk</p>
                    </div>

                </div>
                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row footer">
                    <div class="col-6 text-center">হিসাবরক্ষকের স্বাক্ষর</div>
                    <div class="col-6 text-left">সরবারহকারীর স্বাক্ষর</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Close</button>
                <button onclick="PrintPage()" class="btn bg-gradient-success">Print</button>
            </div>
        </div>
    </div>
</div>
<style>
    .invoice {
        height: 1748px;
        width: 1240px;
        /* Optional: to prevent overflow and make sure the content fits */
        overflow: hidden;
    }
  </style>

<script>


    async function InvoiceDetails(cus_id,inv_id) {

        showLoader()
        let res=await axios.post("/invoice-details",{cus_id:cus_id,inv_id:inv_id})
        hideLoader();

        const createdAt = res.data['invoice']['created_at'];

        const formattedDate = new Date(createdAt).toLocaleString('en-GB', {
            timeZone: 'Asia/Dhaka',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
        }); // '2024-10-10'

        document.getElementById('invCreateDt').innerText = formattedDate;

        document.getElementById('CName').innerText=res.data['customer']['shop_name']
        document.getElementById('CId').innerText=res.data['customer']['user_id']
        // document.getElementById('CEmail').innerText=res.data['customer']['email']
        document.getElementById('CMobile').innerText=res.data['customer']['mobile']
        document.getElementById('CAddress').innerText=res.data['customer']['address']
        document.getElementById('total').innerText =parseFloat(res.data['invoice']['total']).toFixed(2);

        document.getElementById('vat').innerText=res.data['invoice']['vat']
        document.getElementById('discount').innerText=res.data['invoice']['discount']
        document.getElementById('InvoiceId').innerText=res.data['invoice']['id']

        document.getElementById('dueAmount').innerText=res.data['due_amount']

        let total = parseFloat(document.getElementById('total').innerText) || 0;
        let dueAmount = parseFloat(document.getElementById('dueAmount').innerText) || 0;
        document.getElementById('payable').innerText = (total + dueAmount).toFixed(2);


        let dueInvoice = document.getElementById('dueInvoice');
        dueInvoice.textContent = ''; // Clear any existing content

        res.data['due_invoice'].forEach(item => {
            let id = item['invoice_id']; // Get each invoice ID
            dueInvoice.textContent += id + ', '; // Append each ID, separated by a comma
        });

        // Optionally, remove the trailing comma and space
        dueInvoice.textContent = dueInvoice.textContent.replace(/, $/, '');



        let invoiceList=$('#invoiceList');

        invoiceList.empty();

        res.data['product'].forEach(function (item,index) {
            let row=`<tr class="text-xs">
                        <td class="text-center">${index+1}</td>
                        <td>${item['product']['name']}</td>
                        <td>${item['qty']}</td>
                        <td>${item['rate']}</td>
                        <td>${item['sale_price']}</td>
                     </tr>`
            invoiceList.append(row)
        });



        $("#details-modal").modal('show')
    }

    function PrintPage() {
        let printContents = document.getElementById('invoice').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function() {
            location.reload();
        }, 1000);
    }
</script>
