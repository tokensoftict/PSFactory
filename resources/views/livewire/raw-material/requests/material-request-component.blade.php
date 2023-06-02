@section('pageHeaderTitle','Show Material Transfer Request')
@section('pageHeaderDescription','Show all Material Transfer Request Items, Approve or Decline')

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
                        <label>Request Type</label>
                        @php
                            $type = explode('\\',$this->materialRequest->request_type);
                        @endphp
                        <span class="form-control">{{  $type[count($type) -1] }}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-7 col-12">
                    <div class="mb-3">
                        <label>Date</label>
                        <span class="form-control">{{ eng_str_date($this->materialRequest->request_date) }}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-7 col-12">
                    <div class="mb-3">
                        <label>Time</label>
                        <span class="form-control">{{ twelveHourClock($this->materialRequest->request_time) }}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-7 col-12">
                    <div class="mb-3">
                        <label>Request By</label>
                        <span class="form-control">{{ $this->materialRequest->request_by->name }}</span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class=" col-12">
                    <div class="mb-3">
                        <label>Description</label>
                        <span class="form-control">{{  $this->materialRequest->description }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    @if($this->showApproval)
                        @if(userCanView('rawmaterial.approverequest'))
                            <a href="javascript:void(0);"  onclick="confirm('Are you sure you want to approve this request ?, this can not be reversed') || event.stopImmediatePropagation()"   wire:click.prevent="approveRequest" wire:loading.attr="disabled" wire:target="approveRequest,declineRequest" class="btn btn-success">Approve Request

                                <i wire:loading.remove wire:target="approveRequest" class="fa fa-check"></i>
                                <span wire:loading wire:target="approveRequest" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            </a>
                        @endif
                        &nbsp;  &nbsp;  &nbsp;
                        @if(userCanView('rawmaterial.declinerequest'))
                            <a href="javascript:void(0);" onclick="confirm('Are you sure you want to decline this request ?, this can not be reversed') || event.stopImmediatePropagation()" wire:click.prevent="declineRequest" wire:target="approveRequest,declineRequest" wire:loading.attr="disabled"  class="btn btn-primary">Decline Request

                                <i wire:loading.remove wire:target="declineRequest" class="fa fa-trash"></i>

                                <span wire:loading wire:target="declineRequest" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            </a>
                        @endif
                    @endif

                </div>
            </div>
            <h3>Request Item(s) List</h3>
            <div class="table-responsive">
                <br/>
                <table class="table" wire:ignore>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Material Name</th>
                        <th>Department</th>
                        <th>Request</th>
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
                            <td>{{ $item->resolve_by->name ?? "" }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
