<div>

    <div class="border-bottom">
        <h2>
            Production Name : {{ $this->production->name }}

            @if(can(['edit','transfer','complete', 'delete'], $this->production))
                <div class="btn-group float-end" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                            @can('edit', $this->production)
                                <li><a class="dropdown-item" href="{{ route('production.edit', $this->production->id) }}">Edit Production</a></li>
                            @endcan
                            @can('transfer', $this->production)
                                <li><a class="dropdown-item" href="{{ route('production.transfer', $this->production->id) }}">Transfer Production</a></li>
                            @endcan
                            @can('enter_yield', $this->production)
                                <li><a class="dropdown-item" href="{{ route('production.enter_yield', $this->production->id) }}">Enter Production Yield</a></li>
                            @endcan
                            @can('edit_production_item', $this->production)) {
                                <li><a class="dropdown-item" href="{{ route('production.edit_production_item', $row->id) }}" class="dropdown-item">Edit Production Items</a></li>
                            @endcan
                            @can('rollback', $this->production)
                                <li><a onclick="confirm('Are you sure you want to rollback this production to complete  ?') || event.stopImmediatePropagation()" wire:click.prevent="rollbackProduction({{ $this->production->id }})" href="javascript:" class="dropdown-item">RollBack Complete</a></li>
                            @endcan
                            @can('complete', $this->production)
                                <li><a class="dropdown-item" href="{{ route('production.complete', $this->production->id) }}">Complete Production</a></li>
                            @endcan
                            @can('delete', $this->production)
                                <li><a onclick="confirm('Are you sure you want to delete this production  ?') || event.stopImmediatePropagation()" wire:click.prevent="deleteProduction" href="javascript:" class="dropdown-item">Delete Production</a></li>
                            @endcan
                        </ul>
                    </div>
                    @endif
                </div>
        </h2>
        <br/>




    </div>

    <div class="row mt-3">
        <address class="pt-1 col-3">
            <h6 class="pb-2"><strong>Basic Information</strong>:</h6>
            <span class="d-block pb-2 "> <strong>Created By :</strong> {{ $this->production->user->name }}</span>
            <span class="d-block pb-2"><strong>Date :</strong> {{ str_date($this->production->production_date) }}</span>
            <span class="d-block pb-2"><strong>Expiry Date :</strong> {{ str_date($this->production->expiry_date) }}</span>
            <span class="d-block pb-2"> <strong>Status : </strong>{!! showStatus($this->production->status) !!}</span>
            <span class="d-block pb-2 "> <strong>Completed By :</strong> {{ $this->production->completed_by->name ?? "" }}</span>
            <span class="d-block pb-2 "> <strong>Remark :</strong> {{ $this->production->remark }}</span>
            <span class="d-block pb-2"> <strong>Production Line : </strong>{{ $this->production->productionline->name }}</span>
            <span class="d-block pb-2"> <strong>Department : </strong>{{ $this->production->department?->name }}</span>
        </address>

        <address class="pt-1 col-3">
            <h6 class="pb-2"><strong>Production Information</strong>:</h6>
            <span class="d-block pb-2"> <strong>Time : </strong>{{ twelveHourClock($this->production->production_time) }}</span>
            <span class="d-block pb-2"> <strong>Product :</strong> <b class="text-primary">{{ $this->production->stock->name }}</b></span>
            <span class="d-block pb-2"> <strong>Template :</strong> <b class="text-green">{{ $this->production->production_template->name }}</b></span>
            <span class="d-block pb-2"> <strong>Batch Number : </strong>{{ $this->production->batch_number }}</span>
            <span class="d-block pb-2"> <strong>Expected Quantity : </strong>{{ $this->production->expected_quantity }}</span>
            <span class="d-block pb-2"> <strong>Yield Quantity: </strong>{{ $this->production->yield_quantity }}</span>
            <span class="d-block pb-2"> <strong>Total Transfer: </strong>{{ $this->production->total_transferred }}</span>
        </address>


        <address class="pt-1 col-3">
            <h6 class="pb-2"><strong>Process Information</strong>:</h6>
            <span class="d-block pb-2"><strong>Starting Unscrabler : </strong>{{ $this->production->starting_unscrabler }}</span>
            <span class="d-block pb-2"><strong>Starting Unibloc : </strong>{{ $this->production->starting_unibloc }}</span>
            <span class="d-block pb-2"><strong>Starting Oriental : </strong>{{ $this->production->starting_oriental }}</span>
            <span class="d-block pb-2"><strong>Starting Labelling : </strong>{{ $this->production->starting_labelling }}</span>
            <span class="d-block pb-2"><strong>Ending Unscrabler : </strong>{{ $this->production->ending_unscrabler }}</span>
            <span class="d-block pb-2"><strong>Ending Unibloc : </strong>{{ $this->production->ending_unibloc }}</span>
            <span class="d-block pb-2"><strong>Ending Oriental : </strong>{{ $this->production->ending_oriental }}</span>
            <span class="d-block pb-2"><strong>Ending Labelling : </strong>{{ $this->production->ending_labelling }}</span>
        </address>

        <address class="pt-1 col-3">
            <h6 class="pb-2"><strong>Result Information</strong>:</h6>
            <span class="d-block pb-2"><strong>Unscrabler : </strong>{{$this->production->ending_unscrabler -$this->production->starting_unscrabler }}</span>
            <span class="d-block pb-2"><strong>Unibloc : </strong>{{$this->production->ending_unibloc- $this->production->starting_unibloc }}</span>
            <span class="d-block pb-2"><strong>Oriental : </strong>{{ $this->production->ending_oriental-$this->production->starting_oriental }}</span>
            <span class="d-block pb-2"><strong>Labelling : </strong>{{ $this->production->ending_labelling- $this->production->starting_labelling }}</span>
            @php
                $collectReport = collect($this->packageReport);
                $count = $collectReport->filter(function($item){
                    return $item['type'] == 'group';
                })->count();
            @endphp
            @if($count > 0)
                @foreach($this->packageReport as $report)
                    @if($report['type'] == "group")
                        <span>{{ $report['name'] }} (Returns): {{ $report['returns'] }}</span>
                    @endif
                @endforeach
            @endif
        </address>

    </div>
    <br/>
    @foreach($this->departments as $department)
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
                        <th>Rough</th>
                        <th>Returns</th>
                        <th>Resolved Date</th>
                        <th>Resolved Time</th>
                        <th>Status</th>
                        <th>Resolved By</th>
                    </tr>
                    </thead>
                    @foreach($this->production->production_material_items()
            ->with(['rawmaterial','rawmaterial.department', 'rawmaterial.materialtype','approved'])
            ->select(
            'rawmaterial_id',
                DB::raw('MAX(rough) as rough'),
                    DB::raw('MAX(returns) as returns'),
            DB::raw('SUM(measurement) as measurement'),
            DB::raw('SUM(total_cost_price) as total_cost_price'),
            DB::raw('Max(approved_date) as approved_date'),
            DB::raw('Max(approved_time) as approved_time'),
            DB::raw('Max(approved_by) as approved_by'),
            DB::raw('Max(status_id) as status_id'),
        )
            ->where('department_id', $department->id)
            ->groupBy('rawmaterial_id')
            ->get()
            ->map(function($item){
                $item['rough'] = $item['rough'] > 0 ? $item['rough'] : 0;
                $item['returns'] =  $item['returns'] > 0 ?  $item['returns'] : 0;
                return $item;
            }) as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->rawmaterial->name }}</td>
                            <td>{{ $department->name  }}</td>
                            <td>{{ money($item->total_cost_price)  }}</td>
                            <td>{{ money($item->measurement)  }} {{ $item->rawmaterial->materialtype->production_measurement_unit }}</td>
                            <td>{{ $item->rawmaterial->materialtype->production_measurement_unit }}</td>
                            <td>{{ $item->rough }} {{ $item->rawmaterial->materialtype->production_measurement_unit }}</td>
                            <td>{{ $item->returns }} {{ $item->rawmaterial->materialtype->production_measurement_unit }}</td>
                            <td>{{ $item->approved_date ?  eng_str_date($item->approved_date) : "" }}</td>
                            <td>{{ $item->approved_time ? twelveHourClock($item->approved_time) : "" }}</td>
                            <td>{!! showStatus($item->status_id) !!}</td>
                            <td>{{ $item->approved->name ?? "" }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <br/>
    @endforeach

</div>
