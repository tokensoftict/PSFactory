@extends('layouts.app')
@section('pageHeaderTitle1', $title.' Production')
@section('pageHeaderDescription', 'Transfer final product to sales inventory')

@section('pageHeaderAction')

@endsection

@section('content')
    <div class="table-responsive">
    <livewire:production-manager.transfer.transfer-production-component :production="$production"/>
    </div>
@endsection
