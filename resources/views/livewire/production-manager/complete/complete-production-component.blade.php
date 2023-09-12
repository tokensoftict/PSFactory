<div  x-data="completeProduction()">

    <hr/>
    <h2>Production Details</h2>
    <hr/>

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Name</label>
                <strong class="form-control">{{ $this->production->name }}</strong>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Batch Number</label>
                <strong class="form-control">{{ $this->production->batch_number }}</strong>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Date </label>
                <strong class="form-control">{{ eng_str_date($this->production->production_date) }}</strong>

            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Stock</label>
                <strong class="form-control">{{ $this->production->stock->name }}</strong>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Template</label>
                <strong class="form-control">{{ $this->production->production_template->name }}</strong>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Time </label>
                <strong class="form-control">{{ twelveHourClock($this->production->production_time) }}</strong>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Status</label>
                <strong class="form-control">{!! _status($this->production->status) !!}</strong>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Expected Quantity</label>
                <strong class="form-control">{{ $this->production->expected_quantity }}</strong>
            </div>
        </div>

    </div>

    <hr/>
    <h2>Production Material Logs</h2>
    <hr/>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Material Name</th>
            <th>Department</th>
            <th>Quantity / Measurement</th>
            <th>Rough</th>
            <th>Returns</th>
        </tr>
        </thead>
        <tbody>
        @foreach($this->productionItems as $key=>$item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['rawmaterial']['name'] }}</td>
                <td>{{ $item['rawmaterial']['department']['name'] }}</td>
                <td>{{ $item['measurement'] }}</td>
                <td>
                    <input type="number" step="0.000001" wire:model.defer="productionItems.{{ $key }}.rough" class="form-control">
                    @if(isset($item['error']))
                        <span class="font-size-13 text-danger d-block">{{ $item['error'] }}</span>
                    @endif
                </td>
                <td>
                    @if($item['rawmaterial']['materialgroup_id'] !== NULL)
                        <input type="number" step="0.000001" wire:model.defer="productionItems.{{ $key }}.returns" class="form-control">
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <hr/>
    <h2>Complete Production</h2>
    <hr/>

    <div class="row">


        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Starting Unscrabler</label>
                <input type="number" class="form-control" wire:model.defer="data.starting_unscrabler" placeholder="Starting Unscrabler">
                @error('data.starting_unscrabler') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Starting Unibloc</label>
                <input type="number" class="form-control" wire:model.defer="data.starting_unibloc" placeholder="Starting Unibloc">
                @error('data.starting_unibloc') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Starting Oriental</label>
                <input type="text" class="form-control" wire:model.defer="data.starting_oriental" placeholder="Starting Oriental">
                @error('data.starting_oriental') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>


        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Starting Labelling</label>
                <input type="text" class="form-control" wire:model.defer="data.starting_labelling" placeholder="Starting Labelling">
                @error('data.starting_labelling') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>


    </div>

    <div class="row mt-2">


        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Ending Unscrabler</label>
                <input type="number" class="form-control" wire:model.defer="data.ending_unscrabler" placeholder="Ending Unscrabler">
                @error('data.quantity_1') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Ending Unibloc</label>
                <input type="number" class="form-control" wire:model.defer="data.ending_unibloc" placeholder="Ending Unibloc">
                @error('data.ending_unibloc') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Ending Oriental</label>
                <input type="text" class="form-control" wire:model.defer="data.ending_oriental" placeholder="Ending Oriental">
                @error('data.ending_oriental') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>


        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Ending Labelling</label>
                <input type="text" class="form-control" wire:model.defer="data.ending_labelling" placeholder="Ending Labelling">
                @error('data.ending_labelling') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

    </div>


    <div class="row mt-2">

        <div class="col-lg-4 col-sm-6 col-12">
            <div class="mb-3">
                <label>Yield</label>
                <input type="text" readonly class="form-control" wire:model.defer="data.yield_quantity" placeholder="Yield Quantity">
                @error('data.yield_quantity') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="col-lg-4 col-sm-6 col-12">
            <div class="mb-3">
                <label>Expiry Date</label>
                <div class="input-groupicon">
                    <input type="text" wire:model.defer="data.expiry_date"  x-init="datepickerInit('expiry_date')" id="expiry_date"   name="expiry_date" placeholder="YYYY-MM-DD" class="form-control">
                    @error('data.expiry_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="mb-3">
                <label>Remark</label>
                <textarea class="form-control"  wire:model.defer="data.remark" placeholder="Remark"></textarea>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 mt-4">

            <button  wire:target="completeProduction" wire:loading.attr="disabled" type="button" wire:click="completeProduction"  class="btn btn-primary btn-lg">
                <i wire:loading.remove wire:target="completeProduction" class="fa fa-check"></i>
                <span wire:loading wire:target="completeProduction" class="spinner-border spinner-border-sm me-2" role="status"></span>
                Complete Production
            </button>
            <a href="{{ route('production.index') }}" class="btn btn-danger btn-lg">Cancel</a>
        </div>
    </div>
    <script>

        function completeProduction()
        {
            return {
                datepickerInit(referred){
                    this.picker =  new Pikaday(
                        {
                            field: document.getElementById(referred),
                            format: 'YYYY-MM-DD',
                            onSelect: (date) => {
                                @this.set('data.'+referred,this.picker.getMoment().format('YYYY-MM-DD'), true);
                            }
                        }
                    );
                },
            }
        }

    </script>

</div>
