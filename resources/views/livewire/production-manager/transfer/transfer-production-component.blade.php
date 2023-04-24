<div>

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="mb-3">
                <label>Quantity in Pieces</label>
                <input type="text" class="form-control" readonly wire:model.defer="data.yield_quantity" placeholder="Quantity">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="mb-3">
                <label>Quantity in Carton</label>
                <input type="text" class="form-control"  readonly wire:model.defer="data.tt_transfer" placeholder="Quantity">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">

            <a  href="javascript:" onclick="confirm('Are you sure you want to initiate this transfer ?, it can not be reverse') || event.stopImmediatePropagation()"  wire:target="transferProduction" wire:loading.attr="disabled" type="button" wire:click="transferProduction"  class="btn btn-primary btn-lg">
                <i wire:loading.remove wire:target="transferProduction" class="fa fa-check"></i>
                <span wire:loading wire:target="transferProduction" class="spinner-border spinner-border-sm me-2" role="status"></span>
                Transfer
            </a>
            <a href="{{ route('production.index') }}" class="btn btn-danger btn-lg">Cancel</a>

        </div>
    </div>
</div>
