@extends('layouts.app')
@section('pageHeaderTitle1', $title.' Production')
@section('pageHeaderDescription', $subtitle.' Production')

@section('pageHeaderAction')

@endsection

@section('js')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/pikaday.js') }}"></script>
@endsection

@section('content')
    <livewire:production-manager.production-items.edit-production-items :production="$production"/>
@endsection