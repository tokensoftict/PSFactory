<div>
    @foreach($this->departments as $department)
        @php
            $items = $this->production->production_material_items()
            ->with(['rawmaterial','rawmaterial.department', 'rawmaterial.materialtype','approved'])
             ->where('department_id', $department->id)->where(function($query){
                 $query->orWhere('status_id', status('Pending'));
                  $query->orWhere('status_id', status('Declined'));
             })->get();
        @endphp
        @if($items->count() > 0)
            <hr>
            <h5>{{ $department->name }} Material</h5>
            <hr>
            <div class="col-md-12">
                <br/>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Total Cost Price</th>
                            <th>Measurement / Pieces</th>
                            <th>Unit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->department->name }}</td>
                                <td>{{ money($item->total_cost_price)  }}</td>
                                <td><input type="text" wire:model.defer="production_items.{{ $item->id }}" class="form-control form-control-sm" name="quantity"/></td>
                                <td>{{ $item->rawmaterial->materialtype->production_measurement_unit }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endforeach

    <br/>
        <div class="row">
            <div class="col-lg-12 mt-4">
                <button  wire:target="saveProductionItems" wire:loading.attr="disabled" type="button" wire:click="saveProductionItems"  class="btn btn-primary btn-lg">
                    <i wire:loading.remove wire:target="saveProductionItems" class="fa fa-check"></i>
                    <span wire:loading wire:target="saveProductionItems" class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Save Production Changes
                </button>
                <a href="{{ route('production.index') }}" class="btn btn-danger btn-lg">Cancel</a>
            </div>
        </div>
</div>
