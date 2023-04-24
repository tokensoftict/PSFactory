@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('js')

    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

@endsection

@section('content')

    <livewire:raw-material.returns.material-returns-component :materialReturn="$materialReturn"/>

@endsection
