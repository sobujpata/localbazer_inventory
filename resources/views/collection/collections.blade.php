@extends('layout.sidenav-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card px-1 py-4">
                    <div class="row justify-content-between ">
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
                                            <label for="invoice_url">Invoice file</label>
                                            <input type="file" name="invoice_url" class="form-control" value="" id="invoice_url">
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
                        @foreach($collections as $index => $collection)
                        <div class="col-md-3 col-12 my-2">
                            <div class="card justify-content-center px-1 py-1">
                                <div class="card-body">
                                    <a class="" href="{{ $collection['invoice_url'] }}" target="_blank">

                                    <h5 class="card-title">{{ $collection['customer_name'] ?? 'Unknown' }}</h5>
                                    <p class="card-text">
                                        Invoice : <strong>{{ $collection['invoice_id'] }}</strong>
                                        Amount : <strong>{{ $collection['amount'] }}</strong>
                                        Date : <strong>{{ $collection['created_at'] }}</strong>
                                    </p>

                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
