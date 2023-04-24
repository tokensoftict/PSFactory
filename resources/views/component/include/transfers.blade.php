<div wire:ignore.self class="modal fade" id="simpleDatatableComponentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label>Transfer Date</label>
                            <strong class="form-control">{{ isset($this->productTransfer->transfer_date) ?  eng_str_date($this->productTransfer->transfer_date) : "" }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label>Transfer Time</label>
                            <strong class="form-control">{{ isset($this->productTransfer->transfer_time) ?  twelveHourClock($this->productTransfer->transfer_time) : "" }}</strong>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label>Transferred By</label>
                            <strong class="form-control">{{ isset($this->productTransfer->transfer_by->name) ? $this->productTransfer->transfer_by->name: ""  }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label>Final Product</label>
                            <strong class="form-control">{{ isset($this->productTransfer->stock->name) ? $this->productTransfer->stock->name: ""  }}</strong>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label>Quantity (carton)</label>
                            <strong class="form-control">{{ isset($this->productTransfer->quantity) ? $this->productTransfer->quantity: ""  }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label>Quantity (pieces)</label>
                            <strong class="form-control">{{ isset($this->productTransfer->pieces) ?  $this->productTransfer->pieces : "" }}</strong>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label>Status</label>
                            <strong class="form-control">{!! isset($this->productTransfer->status_id) ? showStatus($this->productTransfer->status) : ""  !!}</strong>
                        </div>
                    </div>

                </div>


                @if(isset($this->productTransfer->status_id) && $this->productTransfer->status_id == status('Approved'))
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label>Approved Quantity (carton)</label>
                                <strong class="form-control">{{ isset($this->productTransfer->approved_quantity) ?  $this->productTransfer->approved_quantity : "" }}</strong>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label>Approved Quantity (carton)</label>
                                <strong class="form-control">{{ isset($this->productTransfer->approved_pieces) ?  $this->productTransfer->approved_pieces : "" }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label>Approved By</label>
                                <strong class="form-control">{{ isset($this->productTransfer->resolve_by_id) ?  $this->productTransfer->resolve_by->name : "" }}</strong>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label>Approved Date / Time</label>
                                <strong class="form-control">{{ isset($this->productTransfer->resolve_time) ?  (eng_str_date($this->productTransfer->resolve_date)." ".twelveHourClock($this->productTransfer->resolve_time)) : "" }} </strong>
                            </div>
                        </div>
                    </div>

                @elseif(isset($this->productTransfer->status_id) && $this->productTransfer->status_id == status('Pending'))

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label>Quantity Received (carton)</label>
                                <input type="number"  placeholder="Quantity Received (carton)" class="form-control" wire:model.defer="quantity_carton"/>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label>Approved Received (pieces)</label>
                                <input type="number"  placeholder="Approved Received (pieces)" class="form-control" wire:model.defer="quantity_pieces"/>
                            </div>
                        </div>
                    </div>


                @endif
            </div>

            <div class="modal-footer ">
                @if(isset($this->productTransfer->status_id) && $this->productTransfer->status_id == status('Pending'))
                <button type="button" wire:target="approve" wire:click="approve" wire:loading.attr="disabled" class="btn btn-primary btn-lg">
                    <span wire:loading wire:target="approve" class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Approve
                </button>
                @endif
                <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


