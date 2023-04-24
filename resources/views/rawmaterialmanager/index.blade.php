@extends('layouts.app')

@section('content')
    <livewire:raw-material.raw-material-manager-component :filters="$filters"/>
@endsection
