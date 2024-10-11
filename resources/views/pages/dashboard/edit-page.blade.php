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
                                            <input type="text" name="productName" class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="qty">Product Qty</label>
                                            <input type="text" name="qty" class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="productRate">Product Rate</label>
                                            <input type="text" name="productRate" class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="salePrice">Total price</label>
                                            <input type="text" name="salePrice" class="form-control" value="">
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
                    <form action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-grou">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $customerDetails->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-grou">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ $customerDetails->mobile }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-grou">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" class="form-control" value="{{ $invoiceTotal->total }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-grou">
                                    <label for="payable">Payable</label>
                                    <input type="text" name="payable" class="form-control" value="{{ $invoiceTotal->payable }}" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row justify-content-between py-4">
                        <div class="align-items-center col">
                            <h5>Product Details</h5>
                        </div>
                        <div class="align-items-center col">
                        </div>
                    </div>
                    <table class="table table-responsive" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Products</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                            @foreach ($invoiceProduct as $product)
                            <tr>
                                <td>1</td>
                                <td>{{ $product->product->name }}</td>
                                <td>{{ $product->qty }}</td>
                                <td>-</td>
                                <td>{{ $product->sale_price }}</td>
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
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
