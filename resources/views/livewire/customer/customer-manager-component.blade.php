@section('pageHeaderTitle','Customer Manager')
@section('pageHeaderDescription','Manage all Customer')

@section('pageHeaderAction')
    @if(userCanView('customer.create'))
        <div class="row">
            <div class="col-sm">
                <div class="mb-4">
                    <button  wire:click="new" wire:target="new" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-light">
                        <i wire:loading.remove wire:target="new" class="bx bx-plus me-1"></i>
                        <span wire:loading wire:target="new" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        New Customer
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
               <livewire:customer.datatable.customer-data-table :filter="[]"/>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="simpleComponentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="post" wire:submit.prevent="{{ $this->modalTitle === "New" ? 'save()' : 'update('.$this->modelId.',)' }}">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $this->modalTitle }} {{ $this->modalName }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label>Firstname</label>
                                            <input class="form-control" type="text" wire:model.defer="firstname"  name="firstname" value="{{ $this->firstname }}" placeholder="Firstname">
                                            @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label>Lastname</label>
                                            <input class="form-control" type="text" wire:model.defer="lastname"  name="lastname" value="{{ $this->lastname }}" placeholder="Lastname">
                                            @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Company Name</label>
                                        <input class="form-control" type="text" wire:model.defer="company_name"  name="company_name" value="{{ $this->company_name }}" placeholder="Company Name">
                                        @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" wire:model.defer="email"  name="email" value="{{ $this->email }}" placeholder="Email Address">
                                    </div>

                                    <div class="mb-3">
                                        <label>Phone Number</label>
                                        <input class="form-control" type="text" wire:model.defer="phone_number"  name="phone_number" value="{{ $this->phone_number }}" placeholder="Phone Number">
                                        @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Customer Type</label>
                                        <select class="form-control" wire:model.defer="type" name="type">
                                            <option value="COMPANY" selected>COMPANY</option>
                                            <option value="INDIVIDUAL">INDIVIDUAL</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>State</label>
                                        <select class="form-control" wire:model.defer="state_id" name="type">
                                            <option value="">Select State</option>
                                            @foreach($this->states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <textarea class="form-control" wire:model.defer="address"  name="address" placeholder="Address"></textarea>
                                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" wire:target="save,update" wire:loading.attr="disabled" class="btn btn-primary">
                            <span wire:loading wire:target="save,update" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            {{ $this->saveButton }}
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>

            </div>
        </form>
    </div>


    <script>
        window.onload = function (){
            let myModal = "";
            $(document).ready(function(){
                myModal = new bootstrap.Modal(document.getElementById("simpleComponentModal"), {});
            });
            window.addEventListener('openModal', (e) => {
                myModal.show();
            });
            window.addEventListener('closeModal', (e) => {
                myModal.hide();
            });
        }
    </script>

</div>
