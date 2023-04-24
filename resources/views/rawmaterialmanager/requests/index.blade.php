@extends('layouts.app')
@section('pageHeaderTitle1','Material Transfer Request')
@section('pageHeaderDescription','Manage all Transfer Request')

@section('pageHeaderAction')
    @if(userCanView('rawmaterial.new_request'))
    <div class="row">
        <div class="col-sm">
            <div class="mb-4">
                <a href="{{ route('rawmaterial.new_request') }}"  type="button" class="btn btn-primary waves-effect waves-light">
                    <i  class="bx bx-plus me-1"></i>
                   Request For Material
                </a>
            </div>
        </div>
        <div class="col-sm-auto">

        </div>
    </div>
    @endif
@endsection

@section('content')
    <livewire:raw-material.requests.datatable.material-request-datatable  :filters="$filters"/>
@endsection
