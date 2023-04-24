@extends('layouts.app')

@section('pageHeaderTitle1', $title)
@section('pageHeaderDescription',$subtitle)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pikaday.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/pikaday.js') }}"></script>
@endsection

@section('content')

    <livewire:invoice-and-sales.returns.return-invoice-form-component :invoiceReturn="$invoiceReturn"/>

@endsection
