@section('pageHeaderTitle','Tank or Lines Manager')
@section('pageHeaderDescription','Manage All Tank or Lines')

@section('pageHeaderAction')
    @if(userCanView('tank.create'))
        <div class="row">
            <div class="col-sm">
                <div class="mb-4">
                    <button  wire:click="new" wire:target="new" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-light">
                        <i wire:loading.remove wire:target="new" class="bx bx-plus me-1"></i>
                        <span wire:loading wire:target="new" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        New Tank or Lines
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
                        <th>Capacity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($this->get() as $tank)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tank->name }}</td>
                            <td>{{ number_format($tank->capacity,2) }}</td>
                            <td>
                                @if(userCanView('tank.toggle'))
                                    <div class="form-check form-switch mb-3" dir="ltr">
                                        <input wire:change="toggle({{ $tank->id }})" id="user{{ $tank->id }}" type="checkbox" class="form-check-input" id="customSwitch1" {{ $tank->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="customSwitch1">{{ $tank->status ? 'Active' : 'Inactive' }}</label>
                                    </div>
                                @else
                                    {{ $tank->status ? 'Active' : 'Inactive' }}
                                @endif
                            </td>
                            <td>
                                @if(userCanView('tank.update'))
                                    <a class="btn btn-outline-primary btn-sm edit" wire:click="edit({{ $tank->id }})" href="javascript:void(0);" >

                                        <span wire:loading wire:target="edit({{ $tank->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                        <i wire:loading.remove wire:target="edit({{ $tank->id }})" class="fas fa-pencil-alt"></i>

                                    </a>
                                @endif
                                @if(userCanView('tank.destroy'))
                                    <a class="btn btn-outline-primary btn-sm delete confirm-text"  wire:click="destroy({{ $tank->id }})" href="javascript:void(0);">

                                        <span wire:loading wire:target="destroy({{ $tank->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                        <i wire:loading.remove wire:target="destroy({{ $tank->id }})" class="fas fa-trash"></i>

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
