<div  x-data="createInvoiceReturn">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-sales-split">
                        <h2>Create New Return Invoice</h2>
                    </div>
                    <div class="col-12">
                        <p>Enter Invoice Number and click on continue
                        </p>
                        <br/>
                        <div class="form-group">
                            <label for="credit_payment">Enter Invoice Number</label>
                            <input type="text" wire:model.defer="invoice_number" x-model="invoice_number" class="form-control input-lg d-block" name="invoice_number" placeholder="Enter Invoice Number">
                        </div>
                        <button  x-on:click="getInvoice" wire:target="getInvoice" wire:loading.attr="disabled" class="btn btn-primary btn-lg d-block mt-3" style="width: 100%">Continue
                            <i wire:loading.remove wire:target="getInvoice" class="fa fa-angle-double-right"></i>
                            <span wire:loading wire:target="getInvoice" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div  class="modal fade" id="returnInvoiceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return Invoice</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <livewire:invoice-and-sales.returns.forms.return-invoice-form-component/>
                </div>
            </div>
        </div>
    </div>

    <script>

        let returnInvoiceModal = "";

        window.onload = function (){


            $(document).ready(function(){
                returnInvoiceModal = new bootstrap.Modal(document.getElementById("returnInvoiceModal"), {
                    'backdrop' : 'static',
                    'keyboard' : false,
                    'focus' : true
                });
            });
            window.addEventListener('openreturnInvoiceModal', (e) => {
                returnInvoiceModal.show();
            });
            window.addEventListener('closereturnInvoiceModal', (e) => {
                returnInvoiceModal.hide();
            });

            window.addEventListener('refresh', (e) => {
                setTimeout(()=>{window.location.reload();},1200);
            });
        }

        function createInvoiceReturn()
        {
            return {
                invoice_number : "",

                getInvoice(){
                    if(this.invoice_number === "")
                    {
                        alert("Please enter the invoice number");
                        return false;
                    }
                    @this.set('invoice_number', this.invoice_number, true);
                    @this.getInvoice().then(function(response){
                    });
                }
            }
        }

    </script>

</div>
