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
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Type</th>
                        <th>Credit Balance</th>
                        <th>Deposit  Balance</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($this->get() as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->firstname }} {{ $customer->lastname }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ ucwords(strtolower($customer->type)) }}</td>
                            <td>{{ money($customer->credit_balance) }}</td>
                            <td>{{ money($customer->deposit_balance) }}</td>
                            <td>
                                @if(userCanView('customer.update'))
                                    <a class="btn btn-outline-primary btn-sm edit" wire:click="edit({{ $customer->id }})" href="javascript:void(0);" >

                                        <span wire:loading wire:target="edit({{ $customer->id }})" class="spinner-border spinner-border-sm me-2" role="status"></span>

                                        <i wire:loading.remove wire:target="edit({{ $customer->id }})" class="fas fa-pencil-alt"></i>

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
