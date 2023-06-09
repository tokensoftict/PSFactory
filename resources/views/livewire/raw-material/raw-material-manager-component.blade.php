@section('pageHeaderTitle','Raw Material Manager')
@section('pageHeaderDescription','Manage all Raw Material')

@section('pageHeaderAction')
    @if(userCanView('rawmaterial.create'))
    <div class="row">
        <div class="col-sm">
            <div class="mb-4">
                <button  wire:click="new" wire:target="new" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-light">
                    <i wire:loading.remove wire:target="new" class="bx bx-plus me-1"></i>
                    <span wire:loading wire:target="new" class="spinner-border spinner-border-sm me-2" role="status"></span>
                    New Raw Material
                </button>
            </div>
        </div>
        <div class="col-sm-auto">

        </div>
    </div>
    @endif
@endsection


<div>
    @if(View::hasSection('pageHeaderTitle'))
        @include('shared.pageheader')
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <livewire:raw-material.datatable.raw-material-data-table/>
            </div>
        </div>
    </div>
    @include('component.include.modal')
</div>
