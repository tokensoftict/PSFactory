<div x-data="request()">
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="form-group">
                <label>Production(optional)</label>
                <div class="row">
                    <div class="col-lg-10 col-sm-10 col-10">
                        <select class="form-control" x-init="select2Alpine('request_id')" id="request_id" x-ref="production_id" x-model="request_id" name="request_id">
                            <option value="">Select Production</option>
                            @foreach($this->productions as $production)
                                <option value="{{ $production->id }}">{{ $production->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="form-group">
                <label> Date </label>
                <div class="input-groupicon">
                    <input type="text" class="form-control" x-init="datepickerInit('request_date')" id="request_date" x-model="request_date" x-ref="request_date" name="request_date" placeholder="YYYY-MM-DD" class="">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mb-3">
            <label>Description</label>
            <textarea class="form-control" name="description" wire:model.defer="data.description" placeholder="Description"></textarea>
        </div>
    </div>
    <hr/>

    <div class="row">
        <div class="col-lg-12 col-sm-4 col-12">
            <div class="row">
                <div class="col-lg-6 col-sm-7 col-12" style="position:relative;">
                    <div class="mb-3">
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
                    <div class="mb-3">
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

    <hr/>
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
                <template x-for="(pItem,index) in material_request_items" :key="pItem.rawmaterial_id">
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
            <button  wire:target="requestMaterial" wire:loading.attr="disabled" type="button" x-on:click="requestMaterial()"  class="btn btn-primary btn-lg me-2">
                <i wire:loading.remove wire:target="requestMaterial" class="fa fa-check"></i>
                <span wire:loading wire:target="requestMaterial" class="spinner-border spinner-border-sm me-2" role="status"></span>
                @if(isset($this->materialRequest->id)) Update @else  Submit  @endif
            </button>

            <a href="{{ route('rawmaterial.request') }}" class="btn btn-danger btn-lg">Cancel</a>
        </div>

    </div>

    <script>
        function request() {
            return {
                material_request_items : JSON.parse(@this.get('data.material_request_items')),
            request_date : @this.get('data.request_date'),
                request_time : @this.get('data.request_time'),
                request_id : @this.get('data.request_id'),
                searchproduct : [],
                selectedProduct : {},
            searchString : "",
                quantity : "",
                selectProduct(product){
                this.selectedProduct = product;
                this.searchString = product.name;
                this.searchproduct = [];
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
            deleteItem(id) {
                this.material_request_items = this.material_request_items.filter(item => id !== item.rawmaterial_id);
            },

            addItem() {

                if ((this.material_request_items.filter(e => e.rawmaterial_id === this.selectedProduct.id)).length > 0) {
                    alert("Material already exists");
                    return;
                }
                this.material_request_items.push({
                    rawmaterial_id: this.selectedProduct.id,
                    unit : this.selectedProduct.materialtype.production_measurement_unit,
                    measurement: this.quantity,
                    name: this.selectedProduct.name,
                });
                this.searchproduct = [];
                this.searchString = "";
                this.selectedProduct = {};
                this.quantity = "";
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

            requestMaterial()
            {
                if(this.material_request_items.lenght == 0)
                {
                    alert('Material List is empty, Please add material to continue');
                    return
                }


                @this.set('data.material_request_items', JSON.stringify(this.material_request_items), true);
                @this.set('data.request_id', this.request_id , true);
                @this.set('data.request_date', this.request_date, true);


                @this.requestMaterial();
            }

        };
        }
    </script>
</div>
