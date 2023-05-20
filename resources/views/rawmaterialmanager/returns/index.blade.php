@extends('layouts.app')
@section('pageHeaderTitle1','Material Return List')
@section('pageHeaderDescription','List of Material Return from Production or Outside production')

@section('pageHeaderAction')
    @if(userCanView('rawmaterial.new_return'))
        <div class="row">
            <div class="col-sm">
                <div class="mb-4">
                    <a href="{{ route('rawmaterial.new_return') }}"  type="button" class="btn btn-primary waves-effect waves-light">
                        <i  class="bx bx-plus me-1"></i>
                        Return  Material
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
    <livewire:raw-material.returns.datatable.material-return-datatable  :filters="$filters"/>
    </div>
@endsection
