@extends('layout.sidenav-layout')
@section('content')
    @include('components.bank-balance.bank-balance-list')
    @include('components.bank-balance.bank-balance-delete')
    @include('components.bank-balance.bank-balance-create')
    @include('components.bank-balance.bank-balance-update')
@endsection
