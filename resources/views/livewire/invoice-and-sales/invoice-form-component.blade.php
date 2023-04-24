<div x-data="invoice()" x-init="totalInvoice(); newCustomerEvent()">

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-8"  style="position:relative;">

                    <div class="form-group">
                        <label>Search for Product</label>
                        <div class="input-groupicon">
                            <input type="text" class="form-control form-control-lg" x-model="searchString" x-on:keyup.debounce="searchProduct(this.value)"  placeholder="Search for Product by name, code and select...">
                        </div>
                    </div>
                    <template x-if="(searchproduct.length > 0)">
                        <div  class="np-result-container">
                            <template x-for="product in searchproduct">
                                <div  x-on:click="selectProduct(product)">
                                    <div class="np-result-item">
                                        <div class="np-ib np-text-container">
                                            <div x-text="product.name"></div>
                                            <div class="np-result-description">
                                                Selling Price : <span x-html="numberFormat(product.selling_price)"></span>
                                                &nbsp; &nbsp;
                                                Quantity : <span x-text="product.quantity"></span>
                                                &nbsp; &nbsp;
                                                <span x-text="product.description"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <br/>

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
                                        <td class="text-center">

                                            <div class="input-group form-group mb-0" style="width:120px;">
                                                <a x-on:click="incrementQuantity(index)" class="btn btn-sm btn-primary">
                                                   <i class="fa fa-plus"></i>
                                                </a>
                                                <input type="number" x-on:keyup="typeQuantity(index)"  x-model="items[index]['quantity']" value="1" class="form-control form-control-sm text-center">
                                                <a x-on:click="decrementQuantity(index)" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-minus"></i>
                                                </a>
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
                                    <th class="text-center"></th>
                                    <th class="text-right" colspan="2">Sub Total</th>
                                    <th class="text-right" colspan="2" id="sub_total" x-html="netTotal">0.00</th>
                                    <th class="text-right"></th>
                                </tr>
                                <tr>
                                    <th class="text-left"></th>
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

                </div>
                <div class="col-4">

                    <div class="card">
                        <div class="card-header border-bottom border-top">
                            <h2 class="card-title text-center total_invoice" style="font-size: 38px; margin-bottom: 0px"  x-html="netTotal"> 0.00</h2>
                        </div>
                    </div>

                    <div class="card">
                        <header class="card-header panel-border">
                            <h2 class="card-title border-bottom" style="margin-bottom: 0px;">Invoice Info.</h2>
                        </header>
                        <section class="card-body">
                            <div class="row">

                                <div class="col-sm-12" style="position:relative;">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Customer Name</label>
                                        <input type="text" x-model="searchCustomerString" class="form-control" x-on:keyup.debounce="searchCustomer(this.value)"  placeholder="Search for customer by phone number, name or email address">
                                        @if(userCanView('customer.create'))
                                        <a href="#" wire:click="newCustomer" class="text-success" style="display: block;text-align: center">Add New Customer</a>
                                        @endif
                                    </div>
                                    <template x-if="(searchCustomers.length > 0)">
                                        <div  class="np-result-container" style="margin-top: -40px">
                                            <template x-for="customer in searchCustomers">
                                                <div  x-on:click="selectCus(customer)">
                                                    <div class="np-result-item">
                                                        <div class="np-ib np-text-container">
                                                            <div x-text="(customer.firstname)+ ' '+(customer.lastname)"></div>
                                                            <div class="np-result-description">
                                                                Phone Number : <span x-html="customer.phone_number"></span>
                                                                &nbsp; &nbsp;
                                                                Company Name : <span x-text="customer.company_name"></span>
                                                                &nbsp; &nbsp;
                                                                <span x-text="customer.address"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="customer_id.firstname !== ''">
                                        <address class="bg-success text-white rounded-3 bg-gradient p-2" style="font-size: 12px;">
                                            <h6 style="font-size: 12px;">Selected Customer :</h6>
                                            <span class="d-block"><b x-html="customer_id.firstname +' '+customer_id.lastname"></b></span>
                                            <span class="d-block" x-text="customer_id.company_name"></span>
                                            <span class="d-block" x-text="customer_id.email"></span>  <span x-text="customer_id.phone_number"></span>
                                        </address>
                                    </template>
                                    <br/>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="invoice_date">Invoice / Sales date</label>
                                        <input readonly="" id="invoice_date" class="form-control" value="{{ dailyDate() }}" placeholder="Invoice / Sales date" type="text">
                                    </div>
                                    <div class="mb-3">
                                        <label for="invoice_number">Invoice Reference</label>
                                        <input readonly=""  x-model="invoice_number" x-ref="invoice_number" id="invoice_number" class="form-control" placeholder="Invoice Number" type="text">
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>

                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{ route('invoiceandsales.draft') }}" type="button" class="btn btn-danger btn-lg">Cancel

                            </a>
                            <button type="button"  x-on:click="saveInvoice"  class="btn btn-success btn-lg">
                                {{ $this->invoice->id ? 'Update Invoice' : ' Generate Invoice' }}

                                <span wire:loading wire:target="generateInvoice" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                <i wire:loading.remove wire:target="generateInvoice" class="fa fa-redo"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="simpleComponentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="post" wire:submit.prevent="{{ $this->modalTitle === "New" ? 'save()' : 'update('.$this->modelId.',)' }}">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $this->modalTitle }} {{ $this->modalName }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label>Firstname</label>
                                            <input class="form-control" type="text" wire:model.defer="firstname"  name="firstname" value="{{ $this->firstname }}" placeholder="Firstname">
                                            @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label>Lastname</label>
                                            <input class="form-control" type="text" wire:model.defer="lastname"  name="lastname" value="{{ $this->lastname }}" placeholder="Lastname">
                                            @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Company Name</label>
                                        <input class="form-control" type="text" wire:model.defer="company_name"  name="company_name" value="{{ $this->company_name }}" placeholder="Company Name">
                                        @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label>Email Address</label>
                                        <input class="form-control" type="email" wire:model.defer="email"  name="email" value="{{ $this->email }}" placeholder="Email Address">
                                    </div>

                                    <div class="mb-3">
                                        <label>Phone Number</label>
                                        <input class="form-control" type="text" wire:model.defer="phone_number"  name="phone_number" value="{{ $this->phone_number }}" placeholder="Phone Number">
                                        @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Customer Type</label>
                                        <select class="form-control" wire:model.defer="type" name="type">
                                            <option value="COMPANY" selected>COMPANY</option>
                                            <option value="INDIVIDUAL">INDIVIDUAL</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Address</label>
                                        <textarea class="form-control" wire:model.defer="address"  name="address" placeholder="Address"></textarea>
                                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" wire:target="save,update" wire:loading.attr="disabled" class="btn btn-primary btn-lg">
                            <span wire:loading wire:target="save,update" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            {{ $this->saveButton }}
                        </button>
                        <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>

            </div>
        </form>
    </div>


    <script>

        function invoice()
        {
            return {
                items : @this.get('items') ? JSON.parse(@this.get('items')) : [] ,
                searchString : "",
                searchproduct : [],
                searchCustomers : [],
                customer_id : @this.get('invoiceData.customer_id') ?  @this.get('invoiceData.customer_id') :  {"firstname" : ""},
                netTotal : 0.00,
                quantity : [],
                searchCustomerString : "",
                selectedProduct : {},
                invoice_date : @this.get('invoiceData.invoice_date') ?  @this.get('invoiceData.invoice_date') : '{{ dailyDate() }}',
                invoice_number : (@this.get('invoiceData.invoice_number')  ?  @this.get('invoiceData.invoice_number') : 'xxxx-INV-xxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(8);
                })),
                selectProduct(product){
                    this.selectedProduct = product;
                    this.selling_price = product.selling_price;
                    this.searchproduct = [];
                    this.searchString = "";
                    this.addItem();
                },
                addItem() {
                    if((this.items.filter(e => e.stock_id === this.selectedProduct.id)).length > 0){
                        alert("Product already exists");
                        return;
                    }

                    this.items.push({
                        "stock_id" : this.selectedProduct.id,
                        "quantity" : 1,
                        "name" : this.selectedProduct.name,
                        "added_by" : '{{ auth()->id() }}',
                        'cost_price' : this.selectedProduct.cost_price,
                        'selling_price' : this.selectedProduct.selling_price,
                        'profit' : (this.selectedProduct.selling_price - this.selectedProduct.cost_price),
                        'total_cost_price' : this.selectedProduct.cost_price,
                        'total_selling_price' : this.selectedProduct.selling_price,
                        'total_profit' :  (this.selectedProduct.selling_price - this.selectedProduct.cost_price),
                        'total_incentives' :  this.selectedProduct.selling_price,
                        'discount_type' : "None",
                        'av_qty' : this.selectedProduct.quantity,
                        'discount_amount' : 0,

                    });

                    this.searchproduct = [];
                    this.searchString = "";
                    this.quantity = "";
                    this.cost_price = "";
                    this.expiry_date = "";
                    this.selectedProduct = {};

                    this.totalInvoice();
                },

                incrementQuantity(index)
                {
                    let qty =  parseInt(this.items[index]['quantity']) + 1;
                    if(qty < this.items[index]['av_qty'])
                    {
                        this.items[index]['quantity'] = qty;
                        this.items[index]['total_cost_price'] = this.items[index]['cost_price'] * this.items[index]['quantity'];
                        this.items[index]['total_selling_price'] = this.items[index]['selling_price'] * this.items[index]['quantity'];
                        this.items[index]['total_profit'] =  (this.items[index]['selling_price'] - this.items[index]['cost_price']) * this.items[index]['quantity'];
                        this.items[index]['total_incentives'] =  this.items[index]['selling_price'] * this.items[index]['quantity'];
                        this.totalInvoice();
                    }
                },

                typeQuantity(index)
                {
                    if(this.items[index]['quantity'] > this.items[index]['av_qty'])
                    {
                        alert("Total available quantity is "+this.items[index]['av_qty']);
                        this.items[index]['quantity'] = this.items[index]['av_qty'];
                    }
                    this.items[index]['total_cost_price'] = this.items[index]['cost_price'] * this.items[index]['quantity'];
                    this.items[index]['total_selling_price'] = this.items[index]['selling_price'] * this.items[index]['quantity'];
                    this.items[index]['total_profit'] =  (this.items[index]['selling_price'] - this.items[index]['cost_price']) * this.items[index]['quantity'];
                    this.items[index]['total_incentives'] =  this.items[index]['selling_price'] * this.items[index]['quantity'];
                    this.totalInvoice();
                },

                decrementQuantity(index)
                {
                    let qty =  parseInt(this.items[index]['quantity']) - 1;
                    if(qty > 0)
                    {
                        this.items[index]['quantity'] = qty;
                        this.items[index]['total_cost_price'] = this.items[index]['cost_price'] * this.items[index]['quantity'];
                        this.items[index]['total_selling_price'] = this.items[index]['selling_price'] * this.items[index]['quantity'];
                        this.items[index]['total_profit'] =  (this.items[index]['selling_price'] - this.items[index]['cost_price']) * this.items[index]['quantity'];
                        this.items[index]['total_incentives'] =  this.items[index]['selling_price'] * this.items[index]['quantity'];
                        this.totalInvoice();
                    }
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

                async searchCustomer()
                {
                    if (this.searchCustomerString !== "" && this.searchCustomerString.length > 3) {
                        this.searchCustomers = await (await fetch('{{ route('findcustomer') }}?query=' + this.searchCustomerString
                        )).
                        json();
                    }
                    else{
                        this.searchCustomers = [];
                    }
                },

                newCustomerEvent()
                {
                    let myModal = "";
                    $(document).ready(function(){
                        myModal = new bootstrap.Modal(document.getElementById("simpleComponentModal"), {});
                    });
                    window.addEventListener('openModal', (e) => {
                        myModal.show();
                    });

                    window.addEventListener('newCustomer', (event) => {
                        this.customer_id = event.detail.customer;
                        myModal.hide();
                    });
                    window.addEventListener('invoiceLink', (event) => {
                        setTimeout(()=>{
                            window.location.href = event.detail.link;
                        },1500)
                    });
                },
                selectCus(customer)
                {
                    this.customer_id = customer;
                    this.searchCustomerString = "";
                    this.searchCustomers = [];
                },
                async searchProduct() {
                    if (this.searchString !== "" && this.searchString.length > 3) {
                        this.searchproduct = await (await fetch('{{ route('findstock') }}?query=' + this.searchString
                        )).
                        json();
                    }else
                    {
                        this.searchproduct = [];
                    }

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
                    this.select2 = $(document.getElementById(referred)).select2();
                    if(this[referred]  === ""){
                        this[referred] =  this.select2.val();
                    }
                    this.select2.on("select2:select", (event) => {
                        this[referred] = event.target.value;
                    });

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

                saveInvoice()
                {

                    if(this.invoice_date === "") {
                        alert("Please select invoice date")
                        return ;
                    }

                    if(this.customer_id.firstname === "") {
                        alert("You have not select a customer for this invoice,  please select a customer by searching!...")
                        return ;
                    }

                    if(this.items.length === 0)
                    {
                        alert("Invoice items list is empty, please add at least one product to generate invoice")
                        return ;
                    }


                    @this.set('invoiceData.invoice_number',this.invoice_number, true);
                    @this.set('invoiceData.invoice_date',this.invoice_date, true);
                    @this.set('invoiceData.customer_id',this.customer_id.id, true);
                    @this.set('items', JSON.stringify(this.items), true);
                    @this.generateInvoice();
                }


            };



        }


    </script>

</div>
