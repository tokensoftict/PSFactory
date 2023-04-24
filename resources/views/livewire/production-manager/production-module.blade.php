<div  x-data="production()">
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Name</label>
                <input type="text" class="form-control" wire:model.defer="data.name" placeholder="Production Name">
                @if ($errors->has('data.name'))
                    <span class="text-danger">{{ $errors->first('data.name') }}</span>
                @endif
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Batch Number</label>
                <input type="text" class="form-control" wire:model.defer="data.batch_number" placeholder="Batch Number">
                @if ($errors->has('data.batch_number'))
                    <span class="text-danger">{{ $errors->first('data.batch_number') }}</span>
                @endif
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Date </label>
                    <input type="text" wire:model.defer="data.production_date" x-init="datepickerInit('production_date')" id="production_date" x-model="production_date" x-ref="production_date"  name="production_date" placeholder="YYYY-MM-DD" class="form-control">
                    @if ($errors->has('data.production_date'))
                        <span class="text-danger">{{ $errors->first('data.production_date') }}</span>
                    @endif
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12" wire:ignore>
            <div class="mb-3">
                <label>Stock</label>
                <select class="form-control" wire:model="data.stock_id" x-init="select2Alpine('stock_id')" id="stock_id"  x-ref="stock_id" x-model="stock_id" name="stock_id">
                    <option value="">Select Stock</option>
                    @foreach($this->stocks as $stock)
                        <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('data.stock_id'))
                    <span class="text-danger">{{ $errors->first('data.stock_id') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="mb-3">
                <label>Production Line</label>
                <select class="form-control" wire:model.defer="data.productionline_id"  id="productionline_id" name="productionline_id">
                    <option value="">Select Production Line</option>
                    @foreach($this->productionlines as $productionline)
                        <option  value="{{ $productionline->id }}">{{ $productionline->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('data.productionline_id'))
                    <span class="text-danger">{{ $errors->first('data.productionline_id') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Template</label>
                <select class="form-control" wire:model.defer="data.production_template_id"  id="production_template_id" name="production_template_id">
                    <option value="">Select Template</option>
                    @foreach($this->production_templates as $production_template)
                        <option  value="{{ $production_template->id }}">{{ $production_template->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('data.production_template_id'))
                    <span class="text-danger">{{ $errors->first('data.production_template_id') }}</span>
                @endif
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="mb-3">
                <label>Production Time </label>
                <div class="input-groupicon">
                    <input type="time" wire:model.defer="data.production_time"  id="production_time"  name="production_time"   class="form-control">
                    @if ($errors->has('data.production_time'))
                        <span class="text-danger">{{ $errors->first('data.production_time') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12"  wire:ignore>
            <div class="mb-3">
                <label>Status</label>
                <select class="form-control" wire:model.defer="data.status_id" x-init="select2Alpine('status_id')" id="status_id"  x-ref="status_id" x-model="status_id" name="status_id">
                    @foreach($this->listStatuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('data.status_id'))
                    <span class="text-danger">{{ $errors->first('data.status_id') }}</span>
                @endif
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="mb-3">
            <label>Remark</label>
            <textarea class="form-control"  wire:model.defer="data.remark" placeholder="Remark"></textarea>
            </div>
        </div>

        <div class="col-lg-12 mt-4">

            <button  wire:target="saveProduction" wire:loading.attr="disabled" type="button" wire:click="saveProduction"  class="btn btn-primary btn-lg">
                <i wire:loading.remove wire:target="saveProduction"  class="fa fa-check"></i>

                <span wire:loading wire:target="saveProduction" class="spinner-border spinner-border-sm me-2" role="status"></span>
                Submit
            </button>
            <a href="{{ route('production.index') }}" class="btn btn-danger btn-lg">Cancel</a>
        </div>
    </div>


    <script>

        function production() {
            return {
                "production_date" : @this.get("data.production_date") ? @this.get("data.production_date") : "" ,
                "stock_id" : @this.get("data.stock_id") ? @this.get("data.stock_id") : "" ,
                "status_id" : @this.get("data.status_id") ? @this.get("data.status_id") : "" ,
                datepickerInit(referred){
                    this.picker =  new Pikaday(
                        {
                            field: document.getElementById(referred),
                            format: 'YYYY-MM-DD',
                            onSelect: (date) => {
                                this[referred] = this.picker.getMoment().format('YYYY-MM-DD')
                                @this.set('data.'+referred,this.picker.getMoment().format('YYYY-MM-DD'), true);
                            }
                        }
                    );
                },
                select2Alpine(referred) {
                    this.select2 = $(document.getElementById(referred)).select2();
                    if(this[referred]  === ""){
                        this[referred] =  this.select2.val();
                        @this.set('data.'+referred, this.select2.val());
                    }
                    this.select2.on("select2:select", (event) => {
                        this[referred] = event.target.value;
                        @this.set('data.'+referred,event.target.value);
                    });

                },

            }
        }
    </script>

</div>
