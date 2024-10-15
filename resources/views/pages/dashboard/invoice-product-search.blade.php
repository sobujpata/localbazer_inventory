@extends('layout.sidenav-layout')
@section('content')
<div class="container-fluid">
    <div class="row" >
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-1 py-4">
                <div class="card-header">
                    <div class="row justify-content-between ">
                        <div class="align-items-center col">
                            <form action="{{ route('invoice.product.search') }}" method="get">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="invoice" placeholder="Search by Invoice IDs (use space to separate)" value="{{ request('invoice') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
    
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="invoice">
                    <div class="row justify-content-between ">
                        <div class="align-items-center col-md-6">
                            <h5 class="text-center">Invoices Products</h5>
                        </div>
                        <div class="align-items-center col-md-6">
                            <p class="text-center">Invoice No : {{ request('invoice') }}</p>
                        </div>
                    </div>
                    <hr class="bg-dark "/>
                    <!-- Display search results -->
                    @if($invoice_products->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product ID</th>
                                <th>Total Quantity</th>
                                <th>Store Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                            @foreach ($invoice_products as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- Row number -->
                                    <td>{{ $item->product->name }}</td> <!-- Product ID -->
                                    <td>{{ $item->total_qty }}</td> <!-- Total Quantity -->
                                    <td>{{ $item->product->buy_qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No products found for this invoice.</p>
                    @endif
                </div>
                
                <button onclick="PrintPage()" class="btn bg-gradient-success w-10">Print</button>
            </div>
        </div>
    </div>
</div>
<script>
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
@endsection
