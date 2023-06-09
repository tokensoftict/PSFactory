@extends('layouts.app')
@section('pageHeaderTitle1', $title.' Production')
@section('pageHeaderDescription', $subtitle.' Production')

@section('pageHeaderAction')

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pikaday.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .np-title {
            margin-left: 20px;
            margin-top: 30px;
            font-size: 18px;
            color: rgb(0, 64, 255);
        }

        .np-input-search:hover {
            background: rgb(225, 225, 225);
            transition: all 0.4s;
        }
        .np-result-container {
            margin-top: -10px;
            text-align: left;
            position: absolute;
            width: 100%;
            z-index: 1000000;
            border-radius: 4px;
            background-color: #fff;
            box-shadow: 0px 1px 6px 1px rgb(0 0 0 / 40%);
        }
        .np-result-item {
            width: 100%;
            border: 1px solid #eee;
            padding: 4px 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .np-result-item:hover {
            background: #eee;
            transition: all 0.3s;
        }
        .np-result-description {
            font-size: 11px;
        }
        .np-ib {
            display: inline-block;
        }

        .np-text-container {
            width: 100%;
            vertical-align: top;
            padding-left: 5px;
            color: black;
        }


        .np-result-details-title {
            font-size: 20px;
            padding: 8px 0px;
            font-weight: 500;
        }
        .np-result-details-description {
            font-size: 16px;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/pikaday.js') }}"></script>
@endsection

@section('content')

    <livewire:production-manager.production-module :production="$production"/>
@endsection

