<div>

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-12">
                    <div class="float-end">
                        @if(userCanView('returns.edit') || userCanView('returns.view') || userCanView('returns.destroy'))
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Invoice Return Action <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">

                                    @if (userCanView('returns.view'))
                                        <li><a href="{{ route('returns.view', $this->invoiceReturn->id) }}" class="dropdown-item">View Invoice Return</a></li>
                                    @endif

                                    @if (userCanView('returns.destroy') && $this->invoiceReturn->status_id != status('Approved'))
                                        <li><a href="javascript:" onclick="confirm('Are you sure you want to delete this invoice return ?') || event.stopImmediatePropagation()" wire:click.prevent="delete" class="dropdown-item">Delete Invoice Return</a></li>
                                    @endif

                                    @if (userCanView('returns.edit') && $this->invoiceReturn->status_id != status('Approved'))
                                        <li> <a href="{{route('returns.edit',$this->invoiceReturn->id) }}" class="dropdown-item">Edit Invoice Return</a></li>
                                    @endif

                                    @if (userCanView('returns.approve') && $this->invoiceReturn->status_id != status('Approved'))
                                        <li> <a href="javascript:" onclick="confirm('Are you sure you want to approve this invoice return ?') || event.stopImmediatePropagation()" wire:click.prevent="approve"  class="dropdown-item">Approve Invoice Return</a></li>
                                    @endif

                                    @if (userCanView('returns.decline') && $this->invoiceReturn->status_id != status('Approved'))
                                        <li> <a href="javascript:" onclick="confirm('Are you sure you want to decline this invoice return ?') || event.stopImmediatePropagation()" wire:click.prevent="decline" class="dropdown-item">Decline Invoice Return</a></li>
                                    @endif

                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">

                    <h5><strong>Invoice Return Details</strong> </h5>

                    <hr/>
                    <div class="mb-3">
                        <span><strong>Return Date</strong></span>
                        <span class="form-control"><strong>{{ convert_date($this->invoiceReturn->return_date) }}</strong></span>
                    </div>
                    <div class="mb-3">
                        <span><strong>Return Reference</strong></span>
                        <span class="form-control"><strong>{{ $this->invoiceReturn->return_number }}</strong></span>
                    </div>

                    <div class="mb-3">
                        <span><strong>Status</strong></span>
                        <span class="form-control"><strong>{!! showStatus($this->invoiceReturn->status_id) !!}</strong></span>
                    </div>

                    <div class="mb-3">
                        <span><strong>Return Reason</strong></span>
                        <span class="form-control"><strong>{{ $this->invoiceReturn->invoiceReturnsReason->title }}</strong></span>
                        <span class="form-control bg-primary mt-1 text-white font-size-12">{{  $this->invoiceReturn->invoiceReturnsReason->reason }}</span>
                    </div>

                    <div class="mb-3">
                        <span><strong>Sales Representative</strong></span>
                        <span class="form-control"><strong>{{ $this->invoiceReturn->create_by->name }}</strong></span>
                    </div>

                    <address class="pt-1 mb-3">
                        <strong>CUSTOMER:</strong><br>
                        <span class="d-block pb-1 pt-1"> Name :  <strong>{{ $this->invoiceReturn->customer->firstname ?? "" }} {{ $this->invoice->customer->lastname ?? "" }}</strong></span>
                        <span class="d-block pb-1">Company : <strong>{{ $this->invoiceReturn->customer->company_name ?? "" }}</strong></span>
                        <span class="d-block pb-1"> Phone Number: <strong>{{ $this->invoiceReturn->customer->phone_number ?? "" }}</strong></span>
                        <span class="d-block pb-1"> Address : <strong>{{ $this->invoiceReturn->customer->address ?? "" }}</strong></span>
                    </address>


                    <div class="col-12">
                        <span class="d-block  text-center"  style="font-weight: bolder; font-size: 14px">Total Returned</span>
                        <span class="d-block bg-success mt-2 pt-3 pb-3 rounded-1 text-white text-center" style="font-weight: bolder; font-size: 30px">{{ money($this->invoiceReturn->sub_total) }}</span>
                    </div>
                    <br/>
                    <hr/>
                    <h5><strong>Invoice Details</strong> </h5>

                    <h5><strong>Invoice ID #{{ $this->invoice->id }}</strong></h5>
                    <hr/>
                    <div class="mb-3">
                        <span><strong>Invoice Date</strong></span>
                        <span class="form-control"><strong>{{ convert_date($this->invoice->invoice_date) }}</strong></span>
                    </div>
                    <div class="mb-3">
                        <span><strong>Invoice Reference</strong></span>
                        <span class="form-control"><strong>{{ $this->invoice->invoice_number }}</strong></span>
                    </div>
                    <div class="mb-3">
                        <span><strong>Sales Representative</strong></span><br/>
                        <span class="form-control"><strong>{{ $this->invoice?->create_by?->name }}</strong></span>
                    </div>


                </div>
                <div class="col-8">
                    <h5><strong>Invoice Return item List(s)</strong> </h5>
                    <hr/>
                    <table class="table table-condensed table-striped table-bordered mt-3" style="font-size: 13px">
                        <thead>
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left" width="25%">Name</th>
                            <th class="text-center" width="25%">Quantity</th>
                            <th class="text-center" width="15%">Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                        </thead>
                        <tbody id="appender">
                        @foreach($this->invoiceReturn->invoice_returns_items as $item)
                            <tr>
                                <td class="text-left">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $item->stock->name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">{{ money($item->selling_price) }}</td>
                                <td class="text-right">{{ money($item->total_selling_price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="text-left"></th>
                            <th class="text-left"></th>
                            <th class="text-left"></th>
                            <th class="text-right">Sub Total</th>
                            <th class="text-right">{{ money($this->invoiceReturn->sub_total) }}</th>
                        </tr>
                        <tr>
                            <th class="text-left"></th>
                            <th class="text-left"></th>
                            <th class="text-left"></th>
                            <th class="text-right">Total</th>
                            <th class="text-right">{{ money($this->invoiceReturn->sub_total) }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
