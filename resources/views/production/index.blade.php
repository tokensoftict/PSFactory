@extends('layouts.app')
@section('pageHeaderTitle1','Production List')
@section('pageHeaderDescription','Manage all Production')

@section('pageHeaderAction')
    <div class="row">
        <div class="col-sm">
            <div class="mb-4">
                <a href="{{ route('production.create') }}""  type="button" class="btn btn-primary waves-effect waves-light">
                <i  class="bx bx-plus me-1"></i>
                Add New Production
                </a>
            </div>
        </div>
        <div class="col-sm-auto">

        </div>
    </div>
@endsection



@section('content')
    <div class="table-responsive">
        <livewire:production-manager.datatable.production-manager-datatable-component :filters="$filter"/>
    </div>
@endsection

