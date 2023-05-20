@extends('layouts.app')
@section('pageHeaderTitle1','Product  List')
@section('pageHeaderDescription','Manage all Finished Product')

@section('pageHeaderAction')
    @if(userCanView('product.create'))
    <div class="row">
        <div class="col-sm">
            <div class="mb-4">
                <a href="{{ route('product.create') }}"  type="button" class="btn btn-primary waves-effect waves-light">
                    <i  class="bx bx-plus me-1"></i>
                    Add New Product
                </a>
            </div>
        </div>
        <div class="col-sm-auto">

        </div>
    </div>
    @endif
@endsection

@section('content')
    <div class="table-responsive">
    <livewire:product-module.datatable.product-component-datatable :filters="$filters"/>
    </div>
@endsection
