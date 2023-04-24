@extends('layouts.app')
@section('pageHeaderTitle1','Show Product')
@section('pageHeaderDescription','Show product Information')

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

    <div class="row">

        <div class="col-lg-4 col-sm-6 col-12">
            <div class="form-group">
                <label>Product Name</label>
                <b>{{ $product->name }}</b>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Code</label>
                <b>{{ $product->code }}</b>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group" wire:ignore>
                <label>Category</label>
                <b>{{ $product->category_id ? $product->category->name : 'Un-categorized' }}</b>
            </div>
        </div>

        <div class="col-lg-2 col-sm-6 col-12" >
            <div class="form-group" wire:ignore>
                <label>Can Product Expiry ?</label>
                <b>{{ $product->expiry ? "Yes" : "No" }}</b>
            </div>
        </div>


        <div class="col-lg-4 col-sm-6 col-12">
            <div class="form-group">
                <label>Selling Price</label>
                <b>{{ money($product->selling_price)  }}</b>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6 col-12">
            <div class="form-group">
                <label>Cost Price</label>
                <b>{{ money($product->cost_price)  }}</b>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6 col-12">
            <div class="form-group">
                <label>Carton Content</label>
                <b>{{ $product->carton  }}</b>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Description</label>
                <b>{{ $product->description  }}</b>
            </div>
        </div>




    </div>
    <hr/>
    <h3>
        Product Template
        @if(userCanView('template.create'))
            <a href="{{ route('template.create',['product_id'=>$product->id]) }}" class="btn btn-primary pull-right btn-sm">Add Template</a>
        @endif
    </h3>

    <hr/>
    <div class="row">
        <div class="col-12">
            <livewire:product-module.template.datatable.product-template-component-datatable  :product="$product"/>

        </div>
    </div>
@endsection
