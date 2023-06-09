<div>
    <form action="" method="post" class="border-bottom">
        @csrf
        <div class="row">

            @if(isset($filters['from']))
                <div class="col-auto">
                    <div class="mb-3">
                        <label class="form-label">From</label>
                        <input type="text" value="{{ $filters['from'] }}" class="form-control datepicker-basic" name="filter[from]" id="datepicker-basic">
                    </div>
                </div>
            @endif

            @if(isset($filters['to']))
                <div class="col-auto">
                    <div class="mb-3">
                        <label class="form-label">To</label>
                        <input type="text" value="{{ $filters['to'] }}" class="form-control datepicker-basic" name="filter[to]" id="datepicker-basic">
                    </div>
                </div>
            @endif

            @if(isset($filters['status_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">System Status</label>
                        <select class="form-control"  data-trigger name="filter[status_id]" id="choices-single-default" placeholder="Select Status">
                            @foreach($statuses as $status)
                                <option {{ $filters['status_id'] == $status->id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif


            @if(isset($filters['supplier_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Supplier</label>
                        <select class="form-control" data-trigger name="filter[supplier_id]" id="choices-single-default" placeholder="Select Supplier">
                            @foreach($suppliers as $supplier)
                                <option {{ $filters['supplier_id'] == $supplier->id ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if(isset($filters['customer_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <select class="form-control" data-trigger name="filter[customer_id]" id="choices-single-default" placeholder="Select Customer">
                            @foreach($customers as $customer)
                                <option {{ $filters['customer_id'] == $customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->firstname. " ".$customer->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif


            @if(isset($filters['department_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" data-trigger name="filter[department_id]" id="choices-single-default" placeholder="Select Supplier">
                            @foreach($departments as $department)
                                <option {{ $filters['department_id'] == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if(isset($filters['created_by']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">System User</label>
                        <select class="form-control" data-trigger name="filter[created_by]" id="choices-single-default" placeholder="Select System User">
                            @foreach($users as $user)
                                <option {{ $filters['created_by'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif


            @if(isset($filters['user_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">System User</label>
                        <select class="form-control" data-trigger name="filter[user_id]" id="choices-single-default" placeholder="Select System User">
                            @foreach($users as $user)
                                <option {{ $filters['user_id'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if(isset($filters['transfer_by_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">System User</label>
                        <select class="form-control" data-trigger name="filter[transfer_by_id]" id="choices-single-default" placeholder="Select System User">
                            @foreach($users as $user)
                                <option {{ $filters['transfer_by_id'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if(isset($filters['request_by_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">System User</label>
                        <select class="form-control" data-trigger name="filter[request_by_id]" id="choices-single-default" placeholder="Select System User">
                            @foreach($users as $user)
                                <option {{ $filters['request_by_id'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif


            @if(isset($filters['rawmaterial_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Raw Material</label>
                        <select class="form-control" data-trigger name="filter[rawmaterial_id]" id="choices-single-default" placeholder="Select Raw Material">
                            @foreach($materials as $material)
                                <option {{ $filters['rawmaterial_id'] == $material->id ? 'selected' : '' }} value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

                @if(isset($filters['purchase_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Raw Material</label>
                        <select class="form-control" data-trigger name="filter[purchase_id]" id="choices-single-default" placeholder="Select Raw Material">
                            @foreach($materials as $material)
                                <option {{ $filters['purchase_id'] == $material->id ? 'selected' : '' }} value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

                @if(isset($filters['batchno']))
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Batch Number</label>
                            <select class="form-control" data-trigger name="filter[batchno]" id="choices-single-default" placeholder="Select Batch Number">
                                @foreach($batch_numbers as $batch_number)
                                    <option {!! $filters['batchno'] == $batch_number ? 'selected' : '' !!} value="{!! $batch_number !!}">{!! $batch_number !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

            @if(isset($filters['paymentmethod_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-control" data-trigger name="filter[paymentmethod_id]" id="choices-single-default" placeholder="Select Payment Method">
                            @foreach($paymentMethods as $paymentMethod)
                                <option {{ $filters['paymentmethod_id'] == $paymentMethod->id ? 'selected' : '' }} value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif


            @if(isset($filters['stock_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select class="form-control" data-trigger name="filter[stock_id]" id="choices-single-default" placeholder="Select Product">
                            @foreach($stocks as $stock)
                                <option {{ $filters['stock_id'] == $stock->id ? 'selected' : '' }} value="{{ $stock->id }}">{{ $stock->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif



            @if(isset($filters['production_template_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Product Template</label>
                        <select class="form-control" data-trigger name="filter[production_template_id]" id="choices-single-default" placeholder="Select Product Template">
                            @foreach($templates as $template)
                                <option {{ $filters['production_template_id'] == $template->id ? 'selected' : '' }} value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif


            @if(isset($filters['productionline_id']))
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Production Line / Tank</label>
                        <select class="form-control" data-trigger name="filter[productionline_id]" id="choices-single-default" placeholder="Select Production Line / Tank">
                            @foreach($lines as $line)
                                <option {{ $filters['productionline_id'] == $line->id ? 'selected' : '' }} value="{{ $line->id }}">{{ $line->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <div class="col-auto">
                <button type="submit" class="btn btn-primary mt-4">Filter</button>
            </div>
        </div>
    </form>
    <br/>
</div>

