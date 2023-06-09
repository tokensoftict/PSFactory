@extends('layouts.app')

@section('pageHeaderTitle1','List Production Template')
@section('pageHeaderDescription','Production template list')


@section('pageHeaderAction')
    @if(userCanView('template.create'))
        <div class="row">
            <div class="col-sm">
                <div class="mb-4">
                    <a href="{{ route('template.create') }}"  type="button" class="btn btn-primary waves-effect waves-light">
                        <i  class="bx bx-plus me-1"></i>
                        Add New Template
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
    <livewire:product-module.template.datatable.product-template-component-datatable/>
    </div>
@endsection
