@section('pageHeaderTitle','Show Material  Return')
@section('pageHeaderDescription','Show all Material Return Items, Approve or Decline')

@section('pageHeaderAction')

@endsection

<div>

    @if(View::hasSection('pageHeaderTitle'))
        @include('shared.pageheader')
    @endif

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-lg-3 col-sm-7 col-12">
                    <div class="mb-3">
                        <label>Return Type</label>
                        @php
                            $type = explode('\\',$this->materialReturn->return_type);
                        @endphp
                        <span class="form-control">{{  $type[count($type) -1] }}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-7 col-12">
                    <div class="mb-3">
                        <label>Date</label>
                        <span class="form-control">{{ eng_str_date($this->materialReturn->return_date) }}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-7 col-12">
                    <div class="mb-3">
                        <label>Time</label>
                        <span class="form-control">{{ twelveHourClock($this->materialReturn->return_time) }}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-7 col-12">
                    <div class="mb-3">
                        <label>Return By</label>
                        <span class="form-control">{{ $this->materialReturn->return_by->name }}</span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class=" col-12">
                    <div class="mb-3">
                        <label>Description</label>
                        <span class="form-control">{{  $this->materialReturn->description }}</span>
                    </div>
                </div>
            </div>

            <div class="table-top">
                <div class="search-set">
                </div>
                <div class="float-end">
                    @if($this->showApproval)

                        @if(userCanView('rawmaterial.approvereturns'))
                            <a href="javascript:void(0);"  onclick="confirm('Are you sure you want to approve this return ?, this can not be reversed') || event.stopImmediatePropagation()"   wire:click.prevent="approveReturn" wire:loading.attr="disabled" wire:target="approveReturn,declineReturn" class="btn btn-success">Approve Return

                                <i wire:loading.remove wire:target="approveReturn" class="fa fa-check"></i>
                                <span wire:loading wire:target="approveReturn" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            </a>
                        @endif
                        &nbsp;  &nbsp;  &nbsp;
                        @if(userCanView('rawmaterial.declinereturns'))
                            <a href="javascript:void(0);" onclick="confirm('Are you sure you want to decline this return ?, this can not be reversed') || event.stopImmediatePropagation()" wire:click.prevent="declineReturn" wire:target="approveReturn,declineReturn" wire:loading.attr="disabled"  class="btn btn-primary">Decline Return

                                <i wire:loading.remove wire:target="declineReturn" class="fa fa-trash"></i>

                                <span wire:loading wire:target="declineReturn" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            </a>
                        @endif
                    @endif

                </div>
            </div>
            <h3>Return Item(s) List</h3>
            <div class="table-responsive">
                <br/>
                <table class="table" wire:ignore>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Material Name</th>
                        <th>Department</th>
                        <th>Return</th>
                        <th>Status</th>
                        <th>Convert Measurement</th>
                        <th>Resolved Date</th>
                        <th>Resolved Time</th>
                        <th>Resolved By</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($this->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->department->name }}</td>
                            <td>{{ $item->measurement }} {{ $item->unit }}</td>
                            <td>{!! showStatus($item->status_id) !!}</td>
                            <td> {{ $item->convert_measurement }} {{ $item->convert_unit }}</td>
                            <td>{{ $item->resolve_date ? eng_str_date($item->resolve_date) : "" }}</td>
                            <td>{{ $item->resolve_time ? twelveHourClock($item->resolve_time) : "" }}</td>
                            <td>{{ $item->resolve_by->name ?? ""  }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
