@extends('layout.sidenav-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card px-1 py-4">
                    <div class="row justify-content-between ">
                        <div class="align-items-center col">
                            <h5>Due Amount</h5>
                        </div>
                    </div>
                    <hr class="bg-dark "/>
                    <div class="row">
                        <form action="{{ route('due.index') }}" method="get">
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
                        <div class="col-md-3 col-6 my-2">
                            <div class="card justify-content-center px-1 py-1 shadow" >
                                <div class="card-body">
                                    <h6 class="card-title">Invoice No : {{ $collection['invoice_id'] }}</h6>
                                    <p class="card-text">
                                        {{ $collection['customer_name'] ?? 'Unknown' }}<br>
                                        Due : <strong>{{ $collection['due'] }} Tk</strong> <br>
                                    </p>
                                    <button type="button" class="float-end btn m-0 bg-gradient-info" data-bs-toggle="modal" data-bs-target="#EditCollection{{ $collection['collection_id'] }}">
                                        Payment
                                    </button>
        
                                      <!-- Modal -->
                                      <div class="modal fade" id="EditCollection{{ $collection['collection_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h1 class="modal-title fs-5" id="exampleModalLabel">Update Due Amount</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <form action="{{ Route('update.due') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="collection_id" value="{{ $collection['collection_id']}}">
                                                <input type="hidden" name="amount" value="{{ $collection['amount']}}">
                                                <div class="form-group">
                                                    <label for="invoice_id">Inviuce No</label>
                                                    <input type="number" name="invoice_id" class="form-control" value="{{ $collection['invoice_id'] }}" id="invoice_id" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="due">Due Payment</label>
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
