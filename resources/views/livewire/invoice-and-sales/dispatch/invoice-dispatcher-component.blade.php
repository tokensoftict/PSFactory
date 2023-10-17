<div>

    <div class="row  border-bottom">
        <div class="col-12">
            <div class="card-sales-split" style="border-bottom: none">
                <h2>Invoice Reference : {{ $this->invoice->invoice_number }}</h2>
            </div>
        </div>
        <div class="col-12">

            <div class="mb-3">
                <label>Picked By</label>
                <select class="form-control form-control-lg"   wire:model.defer="data.picked_by">
                    <option value="">Select User</option>
                    @foreach($this->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('data.picked_by') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>

            <div class="mb-3">
                <label>Checked By</label>
                <select class="form-control form-control-lg"   wire:model.defer="data.checked_by">
                    <option value="">Select User</option>
                    @foreach($this->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('data.checked_by') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>

            <div class="mb-3">
                <label>Packed By</label>
                <select class="form-control form-control-lg"   wire:model.defer="data.packed_by">
                    <option value="">Select User</option>
                    @foreach($this->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('data.packed_by') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>

            <div class="mb-3">
                <label>Dispatched By</label>
                <select class="form-control form-control-lg"  wire:model.defer="data.dispatched_by">
                    <option value="">Select User</option>
                    @foreach($this->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('data.dispatched_by') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>

            <div class="mb-3">
                <label>Vehicle Number</label>
                <input type="text" name="vehicle_number" wire:model.defer="data.vehicle_number" placeholder="Vehicle Number" id="vehicle_number" class="form-control form-control-lg">
                @error('data.vehicle_number') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>

            <div class="mb-3">
                <label>Driver Name</label>
                <input type="text" name="driver_name" wire:model.defer="data.driver_name" placeholder="Driver Name" id="driver_name" class="form-control form-control-lg">
                @error('data.driver_name') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>

            <div class="mb-3">
                <label>Driver Phone Number</label>
                <input type="text" name="driver_phone_number" wire:model.defer="data.driver_phone_number" placeholder="Driver Phone Number" id="driver_phone_number" class="form-control form-control-lg">
                @error('data.driver_phone_number') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>

            <div class="mb-3">
                <label>Received By</label>
                <input type="text" name="received_by" wire:model.defer="data.received_by"  placeholder="Received By" id="received_by" class="form-control form-control-lg">
                @error('data.received_by') <span class="text-danger">{{ $message }}</span>  @enderror
            </div>


            <br/>  <br/>
            <button wire:click="dispatchedInvoice" wire:target="dispatchedInvoice" wire:loading.attr="disabled" style="width: 100%"  class="btn btn-primary btn-lg d-block bottom-100">
                Dispatched Invoice
                <i wire:loading.remove wire:target="dispatchedInvoice" class="fa fa-check"></i>
                <span wire:loading wire:target="dispatchedInvoice" class="spinner-border spinner-border-sm me-2" role="status"></span>
            </button>

        </div>
    </div>

</div>
