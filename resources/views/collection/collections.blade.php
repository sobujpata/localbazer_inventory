@extends('layout.sidenav-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card px-1 py-4">
                    <div class="row justify-content-between ">

                        <div class="align-items-center col">
                            <h5>Daily Collection Amount</h5>
                        </div>

                        <div class="align-items-center col">
                            <button type="button" class="float-end btn m-0 bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                                + Add Invoice
                            </button>

                              <!-- Modal -->
                              <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Add Collection Amount</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{ url('/invoice-create-amount') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="invoice_id">Inviuce No</label>
                                            <input type="number" name="invoice_id" class="form-control" value="" id="invoice_id" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Collection Amount</label>
                                            <input type="text" name="amount" class="form-control" value="" id="amount" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="due">Due Amount</label>
                                            <input type="text" name="due" class="form-control" value="" id="due">
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
                    <div class="row">
                        <form action="{{ route('collection.index') }}" method="get">
                            <div class="col-md-4 col-12">
                                <input type="number" class="form-control" name="invoice_id" placeholder="Invoice No Search....">
                            </div>
                            <div class="col-3 mt-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if($errors->has('invoice_id'))
                            <div class="alert alert-danger">
                                {{ $errors->first('invoice_id') }}
                            </div>
                        @endif
                        <!-- Display Validation Errors if Any -->
                        @if ($errors->any())
                            <div class="alert alert-danger mt-2">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @foreach($collections as $index => $collection)
                        <div class="col-md-3 col-12 my-2">
                            <div class="card justify-content-center px-1 py-1 shadow" >
                                <div class="card-body">
                                    <h5 class="card-title">Invoice : <strong>{{ $collection['invoice_id'] }}</strong></h5>

                                    <p class="card-text">
                                        Name : <strong class="card-title">{{ $collection['customer_name'] ?? 'Unknown' }}</strong><br>
                                        Address : <strong>{{ $collection['customer_address'] }}</strong><br>
                                        Amount : <strong>{{ $collection['amount'] }}</strong><br>
                                        Due Amount : <strong>{{ $collection['due'] }}</strong> <br>
                                        Date : <strong>{{ $collection['updated_at'] }}</strong>
                                    </p>
                                    <button type="button" class="float-end btn m-0 bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#EditCollection{{ $collection['collection_id'] }}">
                                        Update Collection
                                    </button>

                                      <!-- Modal -->
                                      <div class="modal fade" id="EditCollection{{ $collection['collection_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h1 class="modal-title fs-5" id="exampleModalLabel">Update Collection Amount</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <form action="{{ Route('update.collection') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="collection_id" value="{{ $collection['collection_id']}}">
                                                <div class="form-group">
                                                    <label for="invoice_id">Inviuce No</label>
                                                    <input type="number" name="invoice_id" class="form-control" value="{{ $collection['invoice_id'] }}" id="invoice_id" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="amount">Collection Amount</label>
                                                    <input type="text" name="amount" class="form-control" value="{{ $collection['amount'] }}" id="amount" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="due">Due Amount</label>
                                                    <input type="text" name="due" class="form-control" value="{{ $collection['due'] ?? 0 }}" id="due">
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
                        </div>
                        @endforeach
                        <div class="pagination">
                            {{ $collections->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
