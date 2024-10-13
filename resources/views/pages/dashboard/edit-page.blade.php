@extends('layout.sidenav-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card px-1 py-4">
                    <div class="row justify-content-between ">
                        <div class="align-items-center col">
                            <h5>Invoices Edit</h5>
                        </div>
                        <div class="align-items-center col">
                            <button type="button" class="float-end btn m-0 bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                                + Add Product
                            </button>

                              <!-- Modal -->
                              <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{ url('/invoice-create-product') }}" method="post">
                                        @csrf
                                        <input type="text" name="invoiceID" value="{{ $invoiceTotal->id }}">
                                        <div class="form-group">
                                            <label for="productName">Product Name</label>
                                            <select type="text" class="form-control form-select" id="productName" name="productName" required>
                                                <option value="">Select Product</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="qty">Product Qty</label>
                                            <input type="text" name="qty" class="form-control" value="" id="qty" oninput="calculateTotalPrice()" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="productRate">Product Rate</label>
                                            <input type="text" name="productRate" class="form-control" value="" id="productRate" oninput="calculateTotalPrice()" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="salePrice">Total price</label>
                                            <input type="text" name="salePrice" class="form-control" value="" id="salePrice" readonly>
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
                    <hr class="bg-dark "/>
                    <div class="row px-2 py-2">
                            <div class="col-md-3">Name : <strong>{{ $customerDetails->name }}</strong></div>
                            <div class="col-md-3">Mobile : <strong>{{ $customerDetails->mobile }}</strong></div>
                            <div class="col-md-3">Total : <strong>{{ $invoiceTotal->total }}</strong></div>
                            <div class="col-md-3">Payable : <strong>{{ $invoiceTotal->payable }}</strong></div>
                    </div>
                    <div class="row">
                       
                        
                        @foreach ($invoiceProduct as $product)
                        <div class="col-md-3">
                            <div class="card justify-content-center">
                                
                                <div class="card-body">
                                    <div class="card-image">
                                        <img src="{{ asset($product->product->img_url) }}" alt="product image" style="width: 100%; height:110px;">
                                    </div>
                                    <p>
                                        <strong>Product Name:</strong> {{ $product->product->name }} <br>
                                        <strong>Product Quantity:</strong> {{ $product->qty }}<br>
                                        <strong>Product Rate:</strong> {{ $product->rate }}<br>
                                        <strong>Product Price:</strong> {{ $product->sale_price }}<br>
                                    </p>
                                </div>
                                <div class="card-footer">
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
                                                <input type="text" class="d-none" name="productID" value="{{ $product->id }}">
                                                <input type="text" class="d-none" name="invoiceID" value="{{ $invoiceTotal->id }}">
                                                <div class="form-group">
                                                    <label for="productName">Product Name</label>
                                                    <input type="text" name="productName" class="form-control" value="{{ $product->product->name }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="qty">Product Qty</label>
                                                    <input type="text" name="qty" class="form-control" value="{{ $product->qty }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="productRate">Product Rate</label>
                                                    <input type="text" name="productRate" class="form-control" value="{{ $product->rate }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="salePrice">Total price</label>
                                                    <input type="text" name="salePrice" class="form-control" value="{{ $product->sale_price }} " readonly>
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
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                  <button type="submit" class="btn btn-primary">Confirm</button>
                                                </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        FillCategoryDropDown();

        async function FillCategoryDropDown(){
            let res = await axios.get("/list-product")
            res.data.data.forEach(function (item,i) {
                let option=`<option value="${item['id']}">${item['name']}</option>`
                $("#productName").append(option);
            })
        }
        function calculateTotalPrice() {
            let qty = parseFloat(document.getElementById("qty").value) || 0;
            let productRate = parseFloat(document.getElementById("productRate").value) || 0;

            let totalSalePrice = qty * productRate;
            document.getElementById('salePrice').value = totalSalePrice.toFixed(2); // Set the value in the input field
        }
    </script>
@endsection
