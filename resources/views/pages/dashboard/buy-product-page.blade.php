@extends('layout.sidenav-layout')
@section('content')
    @include('components.product.buy-product-list')
    @include('components.product.buy-product-delete')
    @include('components.product.buy-product-create')
    @include('components.product.buy-product-update')
@endsection
