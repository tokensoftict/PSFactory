<div x-data="templateManager()">

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12" wire:ignore>
            <div class="mb-3" >
                <label>Template Name</label>
                <input type="text" class="form-control"  name="template_name"  x-model="template_name" placeholder="Template Name">
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12"  wire:ignore>
            <div class="mb-3">
                <label>Select Product</label>
                <select class="select form-control" x-init="select2Alpine('stock_id')" id="stock_id"  x-ref="stock_id" x-model="stock_id" name="stock_id">
                    <option value="">Select Stock</option>
                    @foreach($this->stocks as $stock)
                        <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12"  wire:ignore>
            <div class="mb-3">
                <label>Status</label>
                <select class="form-control" x-init="select2Alpine('status')" id="status"  x-ref="status" x-model="status" name="status">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12" wire:ignore>
            <div class="mb-3" >
                <label>Expected Production Quantity</label>
                <input type="number" class="form-control"  name="expected_quantity"  x-model="expected_quantity" placeholder="Expected Production Quantity">
            </div>
        </div>


    </div>

    <hr/>

    <div class="row">
        <div class="col-lg-12 col-sm-4 col-12">
            <div class="row">
                <div class="col-lg-6 col-sm-7 col-12" style="position:relative;">
                    <div class="form-group">
                        <label>Search for Material</label>
                        <div class="input-groupicon">
                            <input type="text" class="form-control" x-model="searchString" x-on:keyup.debounce="searchMaterial(this.value)"  placeholder="Search for Material by code and select...">

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
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Measurement / Quantity</label>
                        <div class="input-groupicon">
                            <input type="number" step="0.00000000000000000001"  x-model="quantity" class="form-control" placeholder="Total Measurement / Quantity">
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
    <div class="row mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Material Name</th>
                    <th class="text-center">Measurement</th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="(pItem,index) in items" :key="pItem.rawmaterial_id">
                    <tr>
                        <td x-text="(index+1)"></td>
                        <td class="text-left" x-text="pItem.name"></td>
                        <td class="text-center" x-text="parseFloat(pItem.measurement) + ' '+pItem.unit"></td>
                        <td class="text-end"><button class="btn btn-sm btn-primary" x-on:click="deleteItem(pItem.rawmaterial_id)">Delete</button> </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>

        <div class="col-lg-12">
            <br/> <br/>
            <button  wire:target="saveTemplate,updateTemplate" wire:loading.attr="disabled" type="button" x-on:click="postTemplate()"  class="btn btn-primary btn-lg me-2">
                <i wire:loading.remove wire:target="saveTemplate,updateTemplate" class="fa fa-check"></i>
                <span wire:loading wire:target="saveTemplate,updateTemplate" class="spinner-border spinner-border-sm me-2" role="status"></span>
                @if(isset($this->template->id)) Update @else  Submit  @endif
            </button>

            <a href="{{ route('template.index') }}" class="btn btn-danger btn-lg">Cancel</a>
        </div>

    </div>
    <script>

        function templateManager() {
            return {
                template_name :  @this.get('template_name') ? @this.get('template_name') : "",
                items: @this.get('addedMaterial') ? JSON.parse(@this.get('addedMaterial')) : [],
                searchString : "",
                quantity : "",
                status :  @this.get('status') ? @this.get('status') : "1",
                expected_quantity : @this.get('expected_quantity') ? @this.get('expected_quantity') : "",
                unitConfig : JSON.parse(@this.get('unitConfig')),
            searchproduct : [],
                selectedProduct : {},
            stock_id : @this.get('stock_id') ? @this.get('stock_id') : "",
                selectProduct(product){
                this.selectedProduct = product;
                this.searchString = product.name;
                this.searchproduct = [];
            },

            addItem() {

                if ((this.items.filter(e => e.rawmaterial_id === this.selectedProduct.id)).length > 0) {
                    alert("Item already exists");
                    return;
                }

                this.items.push({
                    rawmaterial_id: this.selectedProduct.id,
                    unit : this.selectedProduct.materialtype.production_measurement_unit,
                    date_created : '{{ dailyDate() }}',
                    measurement: this.quantity,
                    name: this.selectedProduct.name,
                });


                this.searchproduct = [];
                this.searchString = "";
                this.selectedProduct = {};
                this.quantity = "";



            },

            deleteItem(id) {
                this.items = this.items.filter(item => id !== item.rawmaterial_id);
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
                if( this[referred] !== "")
                {
                    this[referred+'_select2'].select2('val', this[referred]);
                }

            },

            numberFormat(amount) {
                return String(amount).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            async postTemplate(){

                if(this.status === "") {
                    alert("Please template  Status")
                    return ;
                }

                if(this.template_name === "") {
                    alert("Please enter template name for easy identification")
                    return ;
                }

                if(this.stock_id === "") {
                    alert("Please select stock ")
                    return ;
                }

                if(this.items.length === 0)
                {
                    alert("No material has been added to the template")
                    return ;
                }

                @this.set("status",this.status,true);
                @this.set("template_name",this.template_name,true);
                @this.set("stock_id",this.stock_id,true);
                @this.set("date_created",'{{ dailyDate() }}',true);
                @this.set("expected_quantity",this.expected_quantity,true);
                @this.set("addedMaterial",JSON.stringify(this.items),true);

                @if(isset($this->template->id))

                @this.updateTemplate().then((response)=>{
                    setTimeout(()=>{
                        window.location.reload();
                    },1500)
                });

                @else
                @this.saveTemplate().then((response)=>{
                    setTimeout(()=>{
                        window.location.reload();
                    },1500)
                });

                @endif

            }
        }
        }

    </script>
</div>

