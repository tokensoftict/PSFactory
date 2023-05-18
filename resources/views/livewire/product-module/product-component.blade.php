<div>
    <form method="post" wire:submit.prevent="saveStock">
        <div class="row">

            <div class="col-lg-4 col-sm-6 col-12">
                <div class="mb-3">
                    <label>Product Name</label>
                    <input name="name" class="form-control" placeholder="Product Name" wire:model.defer="name" type="text">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="mb-3">
                    <label>Code</label>
                    <input name="code" class="form-control" placeholder="Code" wire:model.defer="code" type="text">
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="mb-3" wire:ignore>
                    <label>Category</label>
                    <select class="form-control" name="category_id" wire:model.defer="category_id">
                        <option value="">Choose Category</option>
                        @foreach($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-12" >
                <div class="mb-3" wire:ignore>
                    <label>Can Product Expiry ?</label>
                    <select class="form-control" name="expiry" wire:model.defer="expiry">
                        <option value="">Select One</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('expiry') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>


            <div class="col-lg-3 col-sm-6 col-12">
                <div class="mb-3">
                    <label>Selling Price</label>
                    <input name="selling_price" class="form-control" placeholder="Selling Price" wire:model.defer="selling_price" type="text">
                    @error('selling_price') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="mb-3">
                    <label>Cost Price</label>
                    <input name="cost_price" class="form-control" placeholder="Cost Price" wire:model.defer="cost_price"  type="text">
                    @error('cost_price') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="mb-3">
                    <label>Carton Content</label>
                    <input name="carton" placeholder="Carton Content" wire:model.defer="carton" class="form-control" type="number">
                    @error('carton') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="mb-3">
                    <label>Lead Time</label>
                    <input name="lead_time" placeholder="Lead Time" wire:model.defer="lead_time" class="form-control" type="number">
                    @error('carton') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="mb-3">
                    <label>Incentives Percentage</label>
                    <input name="incentives_percentage" placeholder="Incentive Percentage" wire:model.defer="incentives_percentage" class="form-control" type="value" step="0.000000001">
                    @error('incentives_percentage') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-12">
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" placeholder="Description" wire:model.defer="description"></textarea>
                </div>
            </div>

            <div class="col-lg-12 mt-4">
                <button type="submit" class="btn btn-primary btn-lg me-2" wire:loading.attr="disabled">Save

                    <i wire:loading.remove wire:target="saveStock" class="fa fa-check"></i>

                    <span wire:loading wire:target="saveStock" class="spinner-border spinner-border-sm me-2" role="status"></span>
                </button>
                <a href="{{ route('product.index') }}" class="btn btn-danger btn-lg">Cancel</a>
            </div>


        </div>
    </form>
</div>
