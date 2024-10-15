@extends('layout.sidenav-layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-1 py-4">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h5>Invoices Products</h5>
                    </div>
                    <div class="align-items-center col">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="search" class="form-control" name="search" placeholder="Search Invoice No">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <hr class="bg-dark "/>
                <table class="table table-responsive" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>Ser No</th>
                            <th>Name</th>
                            <th>Total Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">
                        @foreach ($invoice_products as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td> <!-- Incremental number -->
                                <td>{{ $item->product_id }}</td> <!-- Display the product ID -->
                                <td>{{ $item->total_qty }}</td> <!-- Display the summed quantity for each product -->
                                <td></td> <!-- You can add more data here if needed -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
