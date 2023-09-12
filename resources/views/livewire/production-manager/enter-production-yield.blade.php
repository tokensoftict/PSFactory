<div>
    <hr>
    <h5>Production Yield List(s)
        <button wire:click="new" wire:target="new" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-light btn-sm float-end">
            <i wire:loading.remove="" wire:target="new" class="bx bx-plus me-1"></i>
            <span wire:loading="" wire:target="new" class="spinner-border spinner-border-sm me-2" role="status"></span>
            Add New Yield
        </button>
    </h5>
    <hr>

    <div class="col-md-12">
        <br/>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Yield</th>
                    <th>Added By</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($this->production->production_yield_histories as $history)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $history->yield }}</td>
                        <td>{{ $history->user->name }}</td>
                        <td>{{ twelveHourClock($history->time_added) }}</td>
                        <td>{{ eng_str_date($history->date_added) }}</td>
                        <td><button wire:click="deleteItem({{ $history->id }})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button> </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th>Total Yield : {{ $this->production->yield_quantity }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="enterYield" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enter Product Yield</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="number" wire:model.defer="yield" name="yield" class="form-control form-control-lg" autofocus placeholder="Enter Yield Amount">
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" wire:click="save" wire:target="save" wire:loading.attr="disabled" class="btn btn-primary btn-lg">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Add Yield
                    </button>
                    <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        window.onload = function (){
            let myModal = "";
            $(document).ready(function(){
                myModal = new bootstrap.Modal(document.getElementById("enterYield"), {
                    backdrop : 'static',
                    keyboard : false,
                    focus : true
                });
            });
            window.addEventListener('openModal', (e) => {
                myModal.show();
            });
            window.addEventListener('closeModal', (e) => {
                myModal.hide();
            });

            window.addEventListener('refreshPage', (e) => {
               setTimeout(function(){
                   window.location.reload()
               }, 800)
            });
        }
    </script>


</div>
