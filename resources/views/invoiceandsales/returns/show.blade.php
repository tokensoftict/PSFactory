@extends('layouts.app')

@section('pageHeaderTitle1', "View Return Details")
@section('pageHeaderDescription', "View all item(s) and more info about the returned invoice")


@section('content')
    <livewire:invoice-and-sales.returns.show.show-invoice-return-component :invoiceReturn="$invoiceReturn"/>
@endsection
