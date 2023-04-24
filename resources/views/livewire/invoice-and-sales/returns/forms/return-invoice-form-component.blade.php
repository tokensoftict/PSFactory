<div >
    <div  x-data="returnInvoice" x-init="InvoiceEvent(); totalInvoice()">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-4">

                        @if(isset($this->invoice->id))

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
                            <h5><strong>Bill To</strong> </h5>
                            <hr/>
                            <address class="pt-1 mb-3">
                                <strong>CUSTOMER:</strong><br>
                                <span class="d-block pb-1 pt-1"> Name :  <strong>{{ $this->invoice->customer->firstname ?? "" }} {{ $this->invoice->customer->lastname ?? "" }}</strong></span>
                                <span class="d-block pb-1">Company : <strong>{{ $this->invoice->customer->company_name ?? "" }}</strong></span>
                                <span class="d-block pb-1"> Phone Number: <strong>{{ $this->invoice->customer->phone_number ?? "" }}</strong></span>
                                <span class="d-block pb-1"> Address : <strong>{{ $this->invoice->customer->address ?? "" }}</strong></span>
                            </address>
                            <br/>
                            <div class="mb-3">
                                <span><strong>Invoice Sub Total</strong></span><br/>
                                <span class="form-control"><strong>{{ money($this->invoice->sub_total) }}</strong></span>
                            </div>

                            <div class="mb-3">
                                <span><strong>Invoice Discount</strong></span><br/>
                                <span class="form-control"><strong>{{ money($this->invoice->discount_amount) }}</strong></span>
                            </div>

                            <div class="mb-3">
                                <span><strong>Invoice Total</strong></span><br/>
                                <span class="form-control"><strong>{{ money($this->invoice->sub_total - $this->invoice->discount_amount) }}</strong></span>
                            </div>

                        @endif
                    </div>
                    <div class="col-8">

                        <div class="row">
                            <div class="col-6">
                            <div class="mb-3">
                                <label>Return Reason</label>
                                <select class="form-control" id="invoice_returns_reason_id" name="invoice_returns_reason_id" x-model="invoice_returns_reason_id" x-init="select2Alpine('invoice_returns_reason_id')">
                                    <option value="">Select Reason</option>
                                    @foreach( $this->invoiceReasons as $reason)
                                        <option value="{{ $reason->id }}">{{ $reason->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                   <label>Return Date </label>
                                    <input type="text" class="form-control" x-model="return_date" id="return_date" name="return_date" x-init="datepickerInit('return_date')">
                                </div>
                            </div>
                        </div>

                        <div class="card" style="height: 80vh;">
                            <div class="card-header border-bottom border-top">
                                <h2 class="card-title">Invoice Items</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-condensed table-striped table-bordered mt-3" style="font-size: 13px">
                                    <thead>
                                    <tr>
                                        <th class="text-left">#</th>
                                        <th class="text-left" width="25%">Name</th>
                                        <th class="text-center" width="25%">Quantity</th>
                                        <th class="text-center" width="25%">Quantity Returned</th>
                                        <th class="text-center" width="15%">Price</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="appender">
                                    <template x-for="(product,index) in items" :key="product.stock_id">
                                        <tr>
                                            <td class="text-left" x-text="(index+1)"></td>
                                            <td class="text-left" x-text="product.name"></td>
                                            <td class="text-center" x-text="product.quantity"></td>
                                            <td class="text-center">
                                                <div class="input-group form-group mb-0" style="width:120px;">
                                                    <input type="number" x-on:change="typeQuantity(index)" x-on:keyup="typeQuantity(index)"  x-model="items[index]['returnquantity']" value="1" class="form-control form-control-sm text-center">
                                                </div>

                                            </td>
                                            <td class="text-center" x-html="numberFormat(product.selling_price)"></td>
                                            <td class="text-center" x-html="numberFormat(product.total_selling_price)"></td>
                                            <td class="text-right"><button class="btn btn-sm btn-primary" x-on:click="deleteItem(product.stock_id)"><i class="fa fa-trash"></i> </button> </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-left"></th>
                                        <th class="text-left"></th>
                                        <th class="text-left"></th>
                                        <th class="text-center"></th>
                                        <th class="text-right" colspan="2">Sub Total</th>
                                        <th class="text-right" colspan="2" id="sub_total" x-html="netTotal">0.00</th>
                                        <th class="text-right"></th>
                                    </tr>
                                    <tr>
                                        <th class="text-left"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-right" colspan="2">Total</th>
                                        <th class="text-right total_invoice" colspan="2" style="font-size: 15px;"  x-html="netTotal">0.00</th>
                                        <th class="text-right"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        @if(isset($this->invoice->id))
                            <div class="card mt-2">
                                <div class="card-body text-center">
                                    <a href="{{ route('returns.index') }}" type="button" class="btn btn-danger btn-lg">Cancel
                                    </a>
                                    <button type="button"  x-on:click="saveReturns"  class="btn btn-success btn-lg">
                                        Return Invoice
                                        <span wire:loading wire:target="saveReturns" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        <i wire:loading.remove wire:target="saveReturns" class="fa fa-redo"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <script>
            function returnInvoice(){
                return {
                    items : @this.get('invoiceData.items') ? JSON.parse(@this.get('invoiceData.items')) : [] ,
                    netTotal : 0.00,
                    invoice_returns_reason_id : @this.get('invoiceData.invoice_returns_reason_id') ? @this.get('invoiceData.invoice_returns_reason_id') : "",
                    return_date :  @this.get('invoiceData.return_date') ? @this.get('invoiceData.return_date') : "",
                typeQuantity(index){

                    if(this.items[index]['returnquantity'] > this.items[index]['quantity'])
                    {
                        alert("You can not return more than "+this.items[index]['quantity']);
                        this.items[index]['returnquantity'] = this.items[index]['quantity'];
                    }
                    this.items[index]['total_cost_price'] = this.items[index]['cost_price'] * this.items[index]['returnquantity'];
                    this.items[index]['total_selling_price'] = this.items[index]['selling_price'] * this.items[index]['returnquantity'];
                    this.items[index]['total_profit'] =  (this.items[index]['selling_price'] - this.items[index]['cost_price']) * this.items[index]['returnquantity'];
                    this.items[index]['total_incentives'] =  this.items[index]['selling_price'] * this.items[index]['returnquantity'];
                    this.totalInvoice();
                },
                deleteItem(id) {
                    this.items = this.items.filter(item => id !== item.stock_id);
                    this.totalInvoice();
                },
                totalInvoice() {
                    this.netTotal = this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
                        return result + item.total_selling_price;
                    }, 0) : 0);
                    return true;
                },
                datepickerInit(referred){
                    this.picker =  new Pikaday(
                        {
                            field: document.getElementById(referred),
                            format: 'YYYY-MM-DD',
                            onSelect: (date) => {
                                this[referred] = this.picker.getMoment().format('YYYY-MM-DD')
                            }
                        }
                    );
                },
                select2Alpine(referred) {
                    this[referred+'_select2'] = $(document.getElementById(referred)).select2();
                    this[referred+'_select2'].on("select2:select", (event) => {
                        this[referred] = event.target.value;
                    });
                    if( this[referred] === "")
                    {
                        this[referred] = this[referred+'_select2'].val();
                    }
                    if( this[referred] !== "")
                    {
                        this[referred+'_select2'].select2('val', this[referred]+"");

                    }
                },
                numberFormat(amount, decimalCount = 2, decimal = ".", thousands = ",") {
                    try {
                        decimalCount = Math.abs(decimalCount);
                        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                        const negativeSign = amount < 0 ? "-" : "";

                        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                        let j = (i.length > 3) ? i.length % 3 : 0;

                        return "&#8358;"+negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
                    } catch (e) {
                        console.log(e)
                    }
                },
                InvoiceEvent()
                {
                    window.addEventListener('displayInvoice', (e) => {
                        @this.displayInvoice(e.detail).then((response)=>{
                            this.items = JSON.parse(response.items);
                            this.totalInvoice();
                            returnInvoiceModal.show();
                        })
                    });
                },
                saveReturns(){

                    @this.set('invoiceData.items', JSON.stringify(this.items), true);
                    @this.set('invoiceData.invoice_returns_reason_id', this.invoice_returns_reason_id, true);
                    @this.set('invoiceData.return_date', this.return_date, true);

                    @this.saveReturns().then((response) => {

                    });

                }
            }
            }

        </script>
    </div>
</div>
