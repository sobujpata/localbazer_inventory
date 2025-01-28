@extends('layout.sidenav-layout')
@section('content')
    <div class="container-fluid mobile-view">
      <div class="col-12 text-center">
        <h4>Invoice Product Edit</h4>
      </div>
      <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>
    
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    </script>
    
      <div class="row">
        <div class="col-md-6 col-lg-6 px-1 py-2">
            <div class="shadow-sm h-100 bg-white rounded-3 px-3 py-3">
                <div class="row">
                    <div class="col-8">
                        <span class="text-bold text-dark">BILLED TO </span>
                        <p class="text-xs mx-0 my-1">Name:  {{ $customerDetails->name }} </p>
                        <p class="text-xs mx-0 my-1">Mobile:  {{ $customerDetails->mobile }} </p>
                        <p class="text-xs mx-0 my-1">Address:  {{ $customerDetails->address }}</p>
                        <p class="text-xs mx-0 my-1">User ID:  {{ $invoiceTotal->id }} </p>
                    </div>
                    <div class="col-4">
                        {{-- <img class="w-50" src="{{"images/logo.png"}}"> --}}
                        <span class="text-bold text-primary">M RSI Tredars </span>
                        <p class="text-bold mx-0 my-1 text-dark">Invoice  </p>
                        <p class="text-xs mx-0 my-1">Date: {{ date('Y-m-d') }} </p>
                    </div>
                </div>
                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row">
                    <div class="col-12">
                        <table class="table w-100" id="invoiceTable">
                            <thead class="w-100">
                            <tr class="text-xs">
                                <td>Name</td>
                                <td>Qty</td>
                                <td>Total</td>
                                <td>Remove</td>
                            </tr>
                            </thead>
                            <tbody  class="w-100" id="invoiceList">
                              @foreach ($invoiceProduct as $product)
                              <tr>
                                <td>{{ $product->product->name }}</td>
                                <td>{{ $product->qty }}</td>
                                <td>{{$product->qty * $product->rate }}</td>
                                <td>
                                  <button type="button" class="btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0" data-bs-toggle="modal" data-bs-target="#editProduct{{ $product->id }}">
                                    <i class="fa text-sm fa-pen"></i>
                                </button>

                                  <!-- Modal -->
                                  <div class="modal fade" id="editProduct{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="{{ url('/invoice-update-product') }}" method="post">
                                            @csrf
                                            {{-- @dd($product->rate) --}}
                                            <input type="text" class="d-none" name="productID" value="{{ $product->id }}">
                                            <input type="text" class="d-none" name="invoiceID" value="{{ $invoiceTotal->id }}">
                                            <input type="text" class="d-none" name="invoiceOldQty" value="{{ $product->qty }}">
                                            <input type="text" class="d-none" name="product_id" value="{{ $product->product['id'] }}">
                                            <div class="form-group">
                                                <label for="productName">Product Name</label>
                                                <input type="text" name="productName" class="form-control" value="{{ $product->product->name }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="qty">Product Qty</label>
                                                <input type="text" name="qty" class="form-control" id="updateQty" oninput="calculateTotalPrice()" value="{{ $product->qty }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="productRate">Product Rate</label>
                                                <input type="text" name="productRate" class="form-control" id="updateRate" oninput="calculateTotalPrice()" value="{{ $product->rate }}">
                                                <input type="text" name="buy_price" class="form-control d-none" value="{{ $product->product['buy_price'] }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="salePrice">Total price</label>
                                                <input type="text" name="salePrice" class="form-control" id="updateSalePrice" oninput="calculateTotalPrice()" value="{{ $product->sale_price }} " readonly>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                          </form>
                                        </div>

                                      </div>
                                    </div>
                                  </div>

                                  {{-- delete button --}}
                                  <button type="button" class="deleteBtn btn btn-outline-danger text-sm px-3 py-1 btn-sm m-0" data-bs-toggle="modal" data-bs-target="#exampleModal{{$product->id}}">
                                    <i class="fa text-sm  fa-trash-alt"></i>
                                  </button>

                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModal{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <form action="{{ url('/invoice-delete-product') }}" method="post">
                                            @csrf
                                            @method('post')
                                            <div class="modal-body text-center">
                                                <h3 class=" mt-3 text-warning">Delete !</h3>
                                                <p class="mb-3">Once delete, you can't get it back.</p>
                                                <input class="form-control d-none" id="productID" name="productID" value="{{$product->id}}"/>
                                                <input class="form-control d-none" id="invoiceID" name="invoiceID" value="{{ $invoiceTotal->id }}"/>
                                                <input class="form-control d-none" id="ProductQtyDelete" name="ProductQtyDelete" value="{{ $product->qty }}"/>
                                                <input class="form-control d-none" id="product_id" name="product_id" value="{{ $product->product['id']}}"/>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary">Confirm</button>
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row">
                   <div class="col-12">
                       <p class="text-bold text-xs my-1 text-dark"> TOTAL: </i> {{ $invoiceTotal->total }} Tk</p>
                       <p class="text-bold text-xs my-2 text-dark"> PAYABLE: </i> {{ $invoiceTotal->payable }} Tk</p>
                       <p class="text-bold text-xs my-1 text-dark d-none"> VAT(0%): </i>  <span id="vat"></span> Tk</p>
                       <p class="text-bold text-xs my-1 text-dark d-none"> Discount: </i>  <span id="discount"></span> Tk</p>
                       <span class="text-xxs d-none">Discount(%):</span>
                       <input onkeydown="return false" value="0" min="0" type="number" step="0.25" onchange="DiscountChange()" class="form-control d-none w-40 " id="discountP"/>
                       <p>
                          <a href="{{ url('/invoicePage') }}" class="btn  my-3 bg-gradient-info w-40">Back to invoice</a>
                       </p>
                   </div>
                    <div class="col-12 p-2">

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 px-1 py-2">
            <div class="shadow-sm h-100 bg-white rounded-3 py-3">
                <table class="table  w-100" id="productTable">
                    <thead class="w-100">
                    <tr class="text-xs text-bold">
                        <td>Product <br>
                            Buy & Sale Price
                        </td>
                        <td class="text-center">Pick</td>
                    </tr>
                    </thead>
                    <tbody  class="w-100" id="productList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">Add Product</h6>
              </div>
              <div class="modal-body">
                      <div class="container">
                          <div class="row">
                            <form action="{{ url('/invoice-create-product') }}" method="post">
                              @csrf
                                  <input type="text" class="d-none" name="invoiceID" value="{{ $invoiceTotal->id }}">
                                  <input type="text" class="form-control d-none" id="PId" name="productName">
                                <div class="form-group">
                                  <label class="form-label mt-2">Product Name *</label>
                                  <input type="text" class="form-control" id="PName" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Product Qty</label>
                                    <input type="text" name="qty" class="form-control" value="" id="qty" oninput="calculateTotalPrice()" required>
                                </div>
                                <div class="form-group">
                                    <label for="productRate">Product Rate</label>
                                    <input type="text" name="productRate" class="form-control" value="" id="PPrice" oninput="calculateTotalPrice()" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="salePrice">Total price</label>
                                    <input type="text" name="salePrice" class="form-control" value="" id="salePrice" readonly>
                                    <input type="text" name="buyPrice" class="form-control d-none" value="" id="BPrice" oninput="calculateTotalPrice()" required>
                                    <input type="text" name="total_buy_price" class="form-control d-none" value="" id="buy_price" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>
                          </div>
                      </div>
              </div>
              
          </div>
      </div>
  </div>
    <script>
      
      function addModal(id,name,wholesale_price,buy_price) {
            document.getElementById('PId').value=id
            document.getElementById('PName').value=name
            document.getElementById('PPrice').value=wholesale_price
            document.getElementById('BPrice').value=buy_price
            $('#create-modal').modal('show')
        }
      ProductList()
        async function ProductList(){
            let res=await axios.get("/list-product");
            let productList=$("#productList");
            let productTable=$("#productTable");
            productTable.DataTable().destroy();
            productList.empty();

            res.data.data.forEach(function (item,index) {
                let row=`<tr class="${item['buy_qty'] <= '0' ? 'alert alert-danger text-white' : ''}">
                        <td>
                            ${item['name']} <br> ${item['eng_name']} <br>
                            Buy Price : ${item['buy_price']} <br>
                            <span class="text-bold">Sale Price : ${item['wholesale_price']}</span>
                        </td>
                        <td style="vertical-align: middle; text-align:center;">
                          <a data-name="${item['name']}" 
                          data-wholesale_price="${item['wholesale_price']}" 
                          data-buy_price="${item['buy_price']}" 
                          data-id="${item['id']}" 
                          class="btn btn-success text-xxs px-2 py-1 addProduct  btn-sm m-0">Add</a></td>
                     </tr>`
                productList.append(row)
            })
            $('.addProduct').on('click', async function () {
                let PName= $(this).data('name');
                let PPrice = $(this).data('wholesale_price')
                let BPrice = $(this).data('buy_price')
                let PId= $(this).data('id');
                addModal(PId,PName,PPrice,BPrice)
            })
            new DataTable('#productTable',{
                // order:[[2,'desc']],
                scrollCollapse: false,
                info: false,
                lengthChange: false
            });
        }
        function calculateTotalPrice() {
            let qty = parseFloat(document.getElementById("qty").value) || 0;
            let PPrice = parseFloat(document.getElementById("PPrice").value) || 0;
            let BPrice = parseFloat(document.getElementById("BPrice").value) || 0;
            let updateQty = parseFloat(document.getElementById("updateQty").value) || 0;
            let updateRate = parseFloat(document.getElementById("updateRate").value) || 0;

            let totalSalePrice = qty * PPrice;
            let totalBuyPrice = qty * BPrice;
            let updateSalePrice = updateQty * updateRate;
            console.log(updateSalePrice)
            document.getElementById('salePrice').value = totalSalePrice.toFixed(2); // Set the value in the input field
            document.getElementById('buy_price').value = totalBuyPrice; // Set the value in the input field
            document.getElementById('updateSalePrice').value = updateSalePrice; // Set the value in the input field
        }
    </script>
@endsection
