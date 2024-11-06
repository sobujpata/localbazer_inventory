@extends('layout.sidenav-layout')
@section('content')
    @include('components.costing.costing-list')
    @include('components.costing.costing-create')
    @include('components.costing.costing-update')
@endsection
