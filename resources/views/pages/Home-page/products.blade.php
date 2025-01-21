@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-5 mb-5 mb-lg-0">
                <h3 class="fw-bold">Products List</h3>
            </div>
        </div>
        <form action="{{ route('product.list') }}" method="get">
            <div class="row">
                <div class="form-group col-md-3">
                    <select name="category" id="category" class="form-control"> <!-- Changed from car_type to category -->
                        <option value="">Select Category</option>
                        @foreach ($categorys as $item)
                        <option value="{{ $item->id }}" {{ request('category') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Bangla name" value="{{ request('name') }}">
                </div>
                <div class="form-group col-md-3">
                    <input class="form-control" type="text" name="eng_name" id="eng_name" placeholder="Enter English name" value="{{ request('eng_name') }}">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ url('/products-list') }}" class="btn btn-info">Reset Filter</a>
                </div>
            </div>
        </form>

        <div class="row mt-1">
            @if($products->isEmpty())
                <p>No product found.</p>
            @else
            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-3 col-lg-2 col-6 my-1 mread px-1">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ $product->img_url }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="w-100" style="border-radius: 10px; height:155px;">
                            <p>
                                <span><strong>{{ $product->name }}</strong></span><br>
                                <span><strong>{{ $product->eng_name }}</strong></span><br>
                                <span><strong>Price : {{ $product->wholesale_price }}</strong></span>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @endif
            <div class="pagination">
                {{ $products->links() }} <!-- Correct usage for pagination -->
            </div>
        </div>
    </div>
    
@endsection
