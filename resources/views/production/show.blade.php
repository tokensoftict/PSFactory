@extends('layouts.app')
@section('pageHeaderTitle1', $title.' Production')
@section('pageHeaderDescription', $subtitle.' Production')

@section('pageHeaderAction')

@endsection

@section('content')
    <livewire:production-manager.show.show-production-component :production="$production"/>
@endsection

