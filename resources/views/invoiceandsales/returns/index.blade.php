@extends('layouts.app')

@section('pageHeaderTitle1', $title)
@section('pageHeaderDescription', $subtitle)


@section('content')
    <div class="table-responsive">
    <livewire:invoice-and-sales.returns.datatable.invoice-return-datatable :filters="$filters"/>
    </div>
@endsection
