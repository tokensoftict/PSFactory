@section('pageHeaderTitle','Material Manager')
@section('pageHeaderDescription','Manage Material')

@section('pageHeaderAction')
    @if(userCanView('materialgroups.create'))
        <div class="row">
            <div class="col-sm">
                <div class="mb-4">
                    <button  wire:click="new" wire:target="new" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-light">
                        <i wire:loading.remove wire:target="new" class="bx bx-plus me-1"></i>
                        <span wire:loading wire:target="new" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        New Material Group
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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($this->get() as $materialgroup)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $materialgroup->name }}</td>
                            <td>
                                @if(userCanView('materialgroups.toggle'))
                                    <div class="form-check form-switch mb-3" dir="ltr">
                                        <input wire:change="toggle({{ $materialgroup->id }})" id="user{{ $materialgroup->id }}" type="checkbox" class="form-check-input" id="customSwitch1" {{ $materialgroup->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="customSwitch1">{{ $materialgroup->status ? 'Active' : 'Inactive' }}</label>
                                    </div>
                                @else
                                    <label class="form-check-label" >{{ $materialgroup->status ? 'Active' : 'Inactive' }}</label>
                                @endif
                            </td>
                            <td>
                                @if(userCanView('materialgroups.update'))
                                    <a class="btn btn-outline-primary btn-sm edit" wire:click="edit({{ $materialgroup->id }})" href="javascript:void(0);" >

                                        <span wire:loading wire:target="edit({{ $materialgroup->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                        <i wire:loading.remove wire:target="edit({{ $materialgroup->id }})" class="fas fa-pencil-alt"></i>

                                    </a>
                                @endif
                                @if(userCanView('materialgroups.destroy'))
                                    <a class="btn btn-outline-primary btn-sm delete confirm-text"  wire:click="destroy({{ $materialgroup->id }})" href="javascript:void(0);">

                                        <span wire:loading wire:target="destroy({{ $materialgroup->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                        <i wire:loading.remove wire:target="destroy({{ $materialgroup->id }})" class="fas fa-trash"></i>

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
