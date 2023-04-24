<div>

    <div class="card-sales-split">
        <h2>Reference : {{ $this->purchaseorder->reference }}</h2>
    </div>

    <div class="row mt-3">
        <div class="col-6">
            <address class="pt-1">
                <strong>General Drug Store:</strong><br>
                <span class="d-block pb-1 pt-1"> Created By : {{ $this->purchaseorder->create_by->name }}</span>
                <span class="d-block pb-1">Date : {{ str_date2($this->purchaseorder->purchase_date) }}</span>
                <span class="d-block pb-1"> Status: {!! showStatus($this->purchaseorder->status_id) !!}</span>
               <!-- <span class="d-block pb-1"> Department : {{ $this->purchaseorder->department->name ?? "" }}</span> -->
            </address>
        </div>

        <div class="col-6 text-end"><strong>Supplier:</strong><br>
            <address class="pt-1">
                <span class="d-block pb-1 pt-1">  {{ $this->purchaseorder->supplier->name }}</span>
                <span class="d-block pb-1"> {{ $this->purchaseorder->supplier->address }}</span>
                <span class="d-block pb-1"> {{ $this->purchaseorder->supplier->email }}</span>
                <span class="d-block pb-1"> {{ $this->purchaseorder->supplier->phonenumber }}</span>
            </address>
        </div>
    </div>

   <hr>
        <h5>Purchase Order Items</h5>
   <hr/>

    <div class="col-md-12">
        <br/>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Measurement</th>
                        <th>Cost Price</th>
                        <th>Expiry Date</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->purchaseorder->purchaseorderitems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->purchase->name }} </td>
                            <td>{{ $item->measurement }} {{ $item->purchase->materialtype->storage_measurement_unit }}</td>
                            <td>{{ number_format($item->cost_price,2) }}</td>
                            <td>{{ $item->expiry_date ?? eng_str_date($item->expiry_date) }}</td>
                            <td class="text-end">{{ number_format(($item->measurement * $item->cost_price),2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-end">Sub Total</th>
                        <th class="text-end">{{ number_format($this->purchaseorder->total,2) }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-end">Total</th>
                        <th class="text-end">{{ number_format($this->purchaseorder->total,2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>
