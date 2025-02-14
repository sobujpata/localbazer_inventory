@extends('layout.sidenav-layout')
@section('content')
    @include('components.banks.banks-list')
    @include('components.banks.banks-delete')
    @include('components.banks.banks-create')
    @include('components.banks.banks-update')
@endsection
