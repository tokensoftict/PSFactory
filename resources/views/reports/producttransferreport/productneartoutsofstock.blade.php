@extends('layouts.app')

@section('pageHeaderTitle1', $title)
@section('pageHeaderDescription', $subtitle)

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/flatpickr/flatpickr.min.css') }}"/>
    <link href="{{ asset('libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')

    <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            flatpickr(".datepicker-basic", {  });
            var e = document.querySelectorAll("[data-trigger]");
            for (i = 0; i < e.length; ++i) {
                var a = e[i];
                new Choices(a, { placeholderValue: "This is a placeholder set in the config", searchPlaceholderValue: "This is a search placeholder" });
            }
        });

    </script>
@endsection

@section('pageHeaderAction')
    @if(app(\App\Classes\Settings::class)->get('p_run_nears') !== 'running' && app(\App\Classes\Settings::class)->get('p_run_nears') !== 'run')
        <div class="row">
            <div class="col-12">
                <a href="{{ route('run_p_nearos') }}"  class="btn btn-primary float-end">Run Product Near Os</a>
                <br/> <br/>  <br/>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                {!! alert_info('Near Os has been schedule to run or currently running') !!}
            </div>
        </div>
    @endif
@endsection

@section('content')
    <div class="table-responsive">
        <livewire:product-module.datatable.product-nearoutotstock :filters="$filters['filters']"/>
    </div>

@endsection
