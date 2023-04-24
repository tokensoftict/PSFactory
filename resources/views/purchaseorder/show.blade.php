@extends('layouts.app')
@section('pageHeaderTitle1','View Purchase')
@section('pageHeaderDescription','View Purchase')

@section('js')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/pikaday.js') }}"></script>
@endsection

@section('content')
    <livewire:purchase-order.show.show-purchase-order :purchaseorder="$purchaseorder" />
@endsection






