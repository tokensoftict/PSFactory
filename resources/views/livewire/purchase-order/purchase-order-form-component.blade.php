<div x-data="purchases()" x-init="totalPurchase()">
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Supplier Name</label>
                <div class="row">
                    <div class="col-lg-10 col-sm-10 col-10">
                        <select class="form-control" x-init="select2Alpine('supplier_id')" id="supplier_id" x-ref="supplier_id" x-model="supplier_id" name="supplier_id">
                            <option value="">Select Supplier</option>
                            @foreach($this->listSuppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label> Date </label>
                <div class="input-groupicon">
                    <input type="text" class="form-control" x-init="datepickerInit('purchase_date')" id="purchase_date" x-model="purchase_date" x-ref="purchase_date" name="purchase_date" placeholder="YYYY-MM-DD" class="">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Reference No.</label>
                <input type="text" class="form-control" readonly name="reference"  x-model="reference" placeholder="Reference No">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control"  id="status_id" x-init="select2Alpine('status_id')"  x-ref="status_id" x-model="status_id" name="status_id">
                    @foreach($this->listStatuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="form-group">
                <label>Department</label>
                <select class="form-control" x-init="select2Alpine('department_id')" id="department_id"  x-ref="department_id" x-model="department_id" name="department_id">
                    @foreach($this->listDepartments as $department)
                        <option {{ $this->department_id === $department->id ? 'selected' : "" }} value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        -->
    </div>
    <hr/>
    <div class="row mt-5">
        <div class="col-lg-12 col-sm-4 col-12">
            <div class="row">
                <div class="col-lg-4 col-sm-7 col-12" style="position:relative;">
                    <div class="form-group">
                        <label>Search for Material</label>
                        <div class="input-groupicon">
                            <input class="form-control" type="text" x-model="searchString" x-on:keyup.debounce="searchMaterial(this.value)"  placeholder="Search for Material by code and select...">
                        </div>
                    </div>
                    <template x-if="(searchproduct.length > 0)">
                        <div  class="np-result-container">
                            <template x-for="product in searchproduct">
                                <div  x-on:click="selectProduct(product)">
                                    <div class="np-result-item">
                                        <div class="np-ib np-text-container">
                                            <div x-text="product.name">

                                            </div>
                                            <div class="np-result-description">
                                                Recent Cost Price : <span x-text="product.cost_price"></span>
                                                &nbsp; &nbsp;
                                                <span x-text="product.description"></span>,   &nbsp; &nbsp; Expiry : <span x-text="(product.expiry ? 'Yes' : 'No')"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="col-lg-2 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Cost Price</label>
                        <div class="input-groupicon">
                            <input  type="number" x-model="cost_price" class="form-control" placeholder="Cost Price">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Expiry Date</label>

                        <div class="input-groupicon">
                            <input type="text" x-init="datepickerInit('expiry_date')" id="expiry_date" x-model="expiry_date" x-ref="expiry_date" name="expiry_date" placeholder="YYYY-MM-DD" class="form-control">

                        </div>

                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Measurement / Quantity</label>
                        <div class="input-groupicon">
                            <input type="text"  x-model="quantity" class="form-control" placeholder="Total Measurement">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12">
                    <label style="visibility: hidden" class=" d-block">Quantity</label>
                    <button type="button" x-on:click="addItem()" class="btn btn-primary">Add Material</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Name</th>
                    <th class="text-center">Expiry Date</th>
                    <th class="text-center">Measurement</th>
                    <th class="text-end">Cost Price</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="(pItem,index) in items" :key="pItem.purchase_id">
                    <tr>
                        <td x-text="(index+1)"></td>
                        <td class="text-left" x-text="pItem.name"></td>
                        <td class="text-center" x-text="pItem.expiry_date"></td>
                        <td class="text-center" x-text="numberFormat(pItem.measurement) + ' '+pItem.unit"></td>
                        <td class="text-end" x-text="numberFormat(pItem.cost_price)"></td>
                        <td class="text-end" x-text="numberFormat(pItem.total)"></td>
                        <td class="text-end"><button class="btn btn-sm btn-primary" x-on:click="deleteItem(pItem.purchase_id)">Delete</button> </td>
                    </tr>
                </template>
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-end">Sub Total</th>
                    <th class="text-end" x-text="numberFormat(netTotal)"></th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-end">Grand Total</th>
                    <th class="text-end" x-text="numberFormat(netTotal)"></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <div class="col-lg-12">

        <button  wire:target="savePurchaseOrder" wire:loading.attr="disabled" type="button" x-on:click="postPurchaseOrder()"  class="btn btn-primary btn-lg me-2">
            <i wire:loading.remove wire:target="savePurchaseOrder" class="fa fa-check"></i>
            <span wire:loading wire:target="savePurchaseOrder" class="spinner-border spinner-border-sm me-2" role="status"></span>
            Submit
        </button>

        <a href="{{ route('purchaseorders.index') }}" class="btn btn-danger btn-lg">Cancel</a>
    </div>
    <script>
        function purchases() {
            return {
                items: @this.get('addedMaterial') ? JSON.parse(@this.get('addedMaterial')) : [],
                searchString : "",
                unitConfig : JSON.parse(@this.get('unitConfig')),
            searchproduct : [],
                netTotal : 0,
                cost_price : "",
                quantity : "",
                //department_id : @this.get('department_id') ? @this.get('department_id') : "",
                selectedProduct : {},
            supplier_id :  @this.get('supplier_id') ? @this.get('supplier_id') : "",
                purchase_date :  @this.get('purchase_date') ? @this.get('purchase_date') : "",
                status_id : @this.get('status_id') ? @this.get('status_id') : "",
                expiry_date : "",
                reference : (@this.get('reference')  ?  @this.get('reference') : 'xxxx-PUR-PFxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(8);
            })),
            selectProduct(product){
                this.selectedProduct = product;
                this.searchString = product.name;
                this.cost_price = product.cost_price;
                this.searchproduct = [];
            },
            addItem() {
                if((this.items.filter(e => e.purchase_id === this.selectedProduct.id)).length > 0){
                    alert("Item already exists");
                    return;
                }

                if(this.selectedProduct.expiry === 1 &&  this.expiry_date == "")
                {
                    alert("Please select expiry Date for "+this.selectedProduct.name);
                    return;
                }

                this.items.push({
                    purchase_id: this.selectedProduct.id,
                    purchase_type : '{{ \App\Models\Rawmaterial::class }}',
                    batch_type : '{{ \App\Models\Rawmaterialbatch::class }}',
                    name: this.selectedProduct.name,
                    batch_id:0,
                    measurement: this.quantity,
                    department_id : this.selectedProduct.department_id,
                    unit : this.unitConfig[this.selectedProduct.materialtype.storage_measurement_unit]['code'],
                    added_by:{{ auth()->id() }},
                    selling_price:this.cost_price,
                    expiry_date: this.selectedProduct.expiry === 1  ? this.expiry_date : null,
                    expiry: this.selectedProduct.expiry,
                    cost_price: this.cost_price,
                    total: (this.quantity * this.cost_price)
                })
                this.searchproduct = [];
                this.searchString = "";
                this.quantity = "";
                this.cost_price = "";
                this.expiry_date = "";
                this.selectedProduct = {};
                this.totalPurchase();

            },

            deleteItem(id) {
                this.items = this.items.filter(item => id !== item.purchase_id);
                this.totalPurchase();
            },


            totalPurchase() {
                this.netTotal = this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
                    return result + item.total;
                }, 0) : 0);
                return true;
            },

            async searchMaterial() {
                if (this.searchString !== "") {
                    this.searchproduct = await (await fetch('{{ route('findpurchaseorderstock') }}?query=' + this.searchString
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
                    this[referred+'_select2'].select2('val', this[referred]);
                }
            },

            numberFormat(amount) {
                return String(amount).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            async postPurchaseOrder(){
                if(this.status === "") {
                    alert("Please select purchase order Status")
                    return ;
                }
                if(this.purchase_date === "") {
                    alert("Please select purchase date")
                    return ;
                }
                if(this.supplier_id === "") {
                    alert("Please select supplier")
                    return ;
                }
                if(this.items.length === 0) {
                    alert("Add Purchase material item")
                    return ;
                }

                if(this.status === "6")
                {
                    let error = false;
                    this.items.forEach(function(item){
                        if(item.expiry === 1 && item.expiry_date == "")
                        {
                            error = true;
                        }
                    });
                    if(error === true)
                    {
                        alert("Please add expiry date to required item list")
                        return ;
                    }
                }


                @this.set("supplier_id",this.supplier_id,true);
                @this.set("purchase_date",this.purchase_date,true);
                @this.set("reference",this.reference,true);
                @this.set("status_id",this.status_id,true);
                //@this.set("department_id",this.department_id,true);
                @this.set("addedMaterial",JSON.stringify(this.items),true);

                @if(isset($this->purchaseorder->id))
                @this.updatePurchaseOrder().then((response)=>{
                    setTimeout(()=>{
                        window.location.href = '{{ route('purchaseorders.show', $this->purchaseorder->id) }}';
                    },1500)
                });
                @else
                @this.savePurchaseOrder().then((response)=>{
                    setTimeout(()=>{
                        window.location.reload();
                    },1500)
                });

                @endif
            },
        }
        }

    </script>
</div>


