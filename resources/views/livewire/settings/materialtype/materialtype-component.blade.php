@section('pageHeaderTitle','Material Manager')
@section('pageHeaderDescription','Manage Material')

@section('pageHeaderAction')
    @if(userCanView('materialtypes.create'))
        <div class="row">
            <div class="col-sm">
                <div class="mb-4">
                    <button  wire:click="new" wire:target="new" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-light">
                        <i wire:loading.remove wire:target="new" class="bx bx-plus me-1"></i>
                        <span wire:loading wire:target="new" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        New Material Type
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
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Storage Measurement unit</th>
                        <th>Production Measurement unit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($this->get() as $materialtype)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $materialtype->name }}</td>
                            <td>{{ $materialtype->storage_measurement_unit }}</td>
                            <td>{{ $materialtype->production_measurement_unit }}</td>
                            <td>
                                @if(userCanView('materialtypes.toggle'))
                                    <div class="form-check form-switch mb-3" dir="ltr">
                                        <input wire:change="toggle({{ $materialtype->id }})" id="user{{ $materialtype->id }}" type="checkbox" class="form-check-input" id="customSwitch1" {{ $materialtype->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="customSwitch1">{{ $materialtype->status ? 'Active' : 'Inactive' }}</label>
                                    </div>
                                @else
                                    <label class="form-check-label" >{{ $materialtype->status ? 'Active' : 'Inactive' }}</label>
                                @endif
                            </td>
                            <td>
                                @if(userCanView('materialtypes.update'))
                                    <a class="btn btn-outline-primary btn-sm edit" wire:click="edit({{ $materialtype->id }})" href="javascript:void(0);" >

                                        <span wire:loading wire:target="edit({{ $materialtype->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                        <i wire:loading.remove wire:target="edit({{ $materialtype->id }})" class="fas fa-pencil-alt"></i>

                                    </a>
                                @endif
                                @if(userCanView('materialtypes.destroy'))
                                    <a class="btn btn-outline-primary btn-sm delete confirm-text"  wire:click="destroy({{ $materialtype->id }})" href="javascript:void(0);">

                                        <span wire:loading wire:target="destroy({{ $materialtype->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                        <i wire:loading.remove wire:target="destroy({{ $materialtype->id }})" class="fas fa-trash"></i>

                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('component.include.modal')
</div>
