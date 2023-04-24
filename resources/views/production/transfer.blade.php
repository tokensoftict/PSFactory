@extends('layouts.app')
@section('pageHeaderTitle1', $title.' Production')
@section('pageHeaderDescription', 'Transfer final product to sales inventory')

@section('pageHeaderAction')

@endsection

@section('content')
    <livewire:production-manager.transfer.transfer-production-component :production="$production"/>
@endsection
