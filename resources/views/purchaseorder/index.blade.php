@extends('layouts.app')
@section('pageHeaderTitle1','Purchase List')
@section('pageHeaderDescription','Manage all Purchases')

@section('pageHeaderAction')
    <div class="row">
        <div class="col-sm">
            <div class="mb-4">
                <a href="{{ route('purchaseorders.create') }}"  type="button" class="btn btn-primary waves-effect waves-light">
                    <i  class="bx bx-plus me-1"></i>
                    Add New Purchases
                </a>
            </div>
        </div>
        <div class="col-sm-auto">

        </div>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
    <livewire:purchase-order.datatable.purchase-order-data-table :filters="$filters"/>
    </div>
@endsection

