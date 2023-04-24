@extends('layouts.app')
@section('pageHeaderTitle1','Product Transferred List')
@section('pageHeaderDescription','Final Product Transferred from Production')

@section('pageHeaderAction')

@endsection

@section('content')

    <livewire:product-module.datatable.product-transfer-list-datatable :filters="$filters"/>

    <script>
        window.onload = function (){
            let myModal = "";
            $(document).ready(function(){
                myModal = new bootstrap.Modal(document.getElementById("simpleDatatableComponentModal"), {});
            });
            window.addEventListener('openModal', (e) => {
                myModal.show();
            });
            window.addEventListener('closeModal', (e) => {
                myModal.hide();
            });
        }
    </script>
@endsection
