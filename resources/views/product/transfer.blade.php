@extends('layouts.app')
@section('pageHeaderTitle1','Product Transferred List')
@section('pageHeaderDescription','Final Product Transferred from Production')

@section('pageHeaderAction')

@endsection

@section('content')
    <div class="table-responsive">
    <livewire:product-module.datatable.product-transfer-list-datatable :filters="$filters"/>
    </div>
    <script>
        window.onload = function (){
            let myModal = "";
            $(document).ready(function(){
                myModal = new bootstrap.Modal(document.getElementById("simpleDatatableComponentModal"), {
                    backdrop : 'static',
                    keyboard : false,
                    focus : true
                });
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
