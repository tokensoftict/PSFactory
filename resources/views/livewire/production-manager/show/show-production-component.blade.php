<div>

    <div class="border-bottom">
        <h2>
            Production Name : {{ $this->production->name }}

            @can(['edit','transfer','complete', 'delete'], $this->production)
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
                            @can('complete', $this->production)
                                <li><a class="dropdown-item" href="{{ route('production.complete', $this->production->id) }}">Complete Production</a></li>
                            @endcan
                            @can('delete', $this->production)
                                <li><a onclick="confirm('Are you sure you want to delete this production  ?') || event.stopImmediatePropagation()" wire:click.prevent="deleteProduction" href="javascript:" class="dropdown-item">Delete Production</a></li>
                            @endcan
                        </ul>
                    </div>
                    @endcan
                </div>
        </h2>
        <br/>




    </div>

    <div class="row mt-3">
        <address class="pt-1 col-4">
            <h6 class="pb-2"><strong>Basic Information</strong>:</h6>
            <span class="d-block pb-2 "> <strong>Created By :</strong> {{ $this->production->user->name }}</span>
            <span class="d-block pb-2"><strong>Date :</strong> {{ str_date($this->production->production_date) }}</span>
            <span class="d-block pb-2"> <strong>Status : </strong>{!! showStatus($this->production->status) !!}</span>
            <span class="d-block pb-2 "> <strong>Completed By :</strong> {{ $this->production->completed_by->name ?? "" }}</span>
            <span class="d-block pb-2 "> <strong>Remark :</strong> {{ $this->production->remark }}</span>
        </address>

        <address class="pt-1 col-4">
            <h6 class="pb-2"><strong>Production Information</strong>:</h6>
            <span class="d-block pb-2"> <strong>Time : </strong>{{ twelveHourClock($this->production->production_time) }}</span>
            <span class="d-block pb-2"> <strong>Product :</strong> <b class="text-primary">{{ $this->production->stock->name }}</b></span>
            <span class="d-block pb-2"> <strong>Template :</strong> <b class="text-green">{{ $this->production->production_template->name }}</b></span>
            <span class="d-block pb-2"> <strong>Batch Number : </strong>{{ $this->production->batch_number }}</span>
            <span class="d-block pb-2"> <strong>Expected Quantity : </strong>{{ $this->production->expected_quantity }}</span>
            <span class="d-block pb-2"> <strong>Production Line : </strong>{{ $this->production->productionline->name }}</span>
        </address>


        <address class="pt-1 col-4">
            <h6 class="pb-2"><strong>Quantity Information</strong>:</h6>
            <span class="d-block pb-2"> <strong>Yield : </strong>{{ $this->production->yield_quantity }}</span>
            <!--<span class="d-block pb-2"> <strong>Rough : </strong>{{ $this->production->rough_quantity }}</span>-->
            <span class="d-block pb-2"> <strong>Starting Quantity : </strong>{{ $this->production->quantity_1 }}</span>
            <span class="d-block pb-2"> <strong>Middle Quantity : </strong>{{ $this->production->quantity_2 }}</span>
            <span class="d-block pb-2"> <strong>End Quantity : </strong>{{ $this->production->quantity_3 }}</span>
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
                        <th>Measurement / Pieces</th>
                        <th>Unit</th>
                        <th>Returns</th>
                        <th>Status</th>
                        <th>Extra</th>
                        <th>Remaining</th>
                        <th>Resolved Date</th>
                        <th>Resolved Time</th>
                        <th>Resolved By</th>
                    </tr>
                    </thead>
                    @foreach($this->production->production_material_items()->where('department_id', $department->id)->get() as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $department->name  }}</td>
                            <td>{{ money($item->measurement)  }} {{ $item->unit }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ money($item->returns) }} {{ $item->unit }}</td>
                            <td>{!! showStatus($item->status_id) !!}</td>
                            <td>{!! $item->extra ? 'Yes' : 'No' !!}</td>
                            <td>{{ money($item->measurement - $item->returns) }} {{ $item->unit }}</td>
                            <td>{{ $item->approved_date ?  eng_str_date($item->approved_date) : "" }}</td>
                            <td>{{ $item->approved_time ? twelveHourClock($item->approved_time) : "" }}</td>
                            <td>{{ $item->approved->name ?? "" }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <br/>
    @endforeach

</div>
