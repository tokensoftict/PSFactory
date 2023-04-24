@section('pageHeaderTitle','Invoice Reason Manager')
@section('pageHeaderDescription','Manage all Reason to Return an Invoice')

@section('pageHeaderAction')

    @if(userCanView('reason.create'))
        <div class="row">
            <div class="col-sm">
                <div class="mb-4">
                    <button  wire:click="new" wire:target="new" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-light">
                        <i wire:loading.remove wire:target="new" class="bx bx-plus me-1"></i>
                        <span wire:loading wire:target="new" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        New Return Reason
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
                            <th>Title</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($this->get() as $reason)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $reason->title }}</td>
                                <td>{{ $reason->reason }}</td>
                                <td>
                                    @if(userCanView('reason.toggle'))
                                        <div class="form-check form-switch mb-3" dir="ltr">
                                            <input wire:change="toggle({{ $reason->id }})" id="user{{ $reason->id }}" type="checkbox" class="form-check-input" id="customSwitch1" {{ $reason->status ? 'checked' : '' }}>
                                            <label class="form-check-label" for="customSwitch1">{{ $reason->status ? 'Active' : 'Inactive' }}</label>
                                        </div>
                                    @else
                                        {{ $reason->status ? 'Active' : 'Inactive' }}
                                    @endif

                                </td>
                                <td>
                                    @if(userCanView('reason.update'))
                                        <a class="btn btn-outline-primary btn-sm edit" wire:click="edit({{ $reason->id }})" href="javascript:void(0);" >

                                            <span wire:loading wire:target="edit({{ $reason->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                            <i wire:loading.remove wire:target="edit({{ $reason->id }})" class="fas fa-pencil-alt"></i>

                                        </a>
                                    @endif

                                    @if(userCanView('reason.destroy'))
                                        <a class="btn btn-outline-primary btn-sm delete confirm-text"  wire:click="destroy({{ $reason->id }})" href="javascript:void(0);">

                                            <span wire:loading wire:target="destroy({{ $reason->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                            <i wire:loading.remove wire:target="destroy({{ $reason->id }})" class="fas fa-trash"></i>

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
