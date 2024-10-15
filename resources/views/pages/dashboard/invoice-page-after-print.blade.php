@extends('layout.sidenav-layout')
@section('content')
    @include('components.invoice.invoice-list-after-print')
    @include('components.invoice.invoice-complete')
    @include('components.invoice.invoice-delete')
    @include('components.invoice.invoice-details')
@endsection
