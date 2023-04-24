<?php

namespace App\Http\Livewire\Settings\Returnreason;


use App\Models\InvoiceReturnsReason;
use App\Traits\SimpleComponentTrait;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InvoiceReturnReasonComponent extends Component
{
    use LivewireAlert;
    use SimpleComponentTrait;

    public function mount()
    {
        $this->model = InvoiceReturnsReason::class;
        $this->modalName = "Invoice Return Reason";
        $this->data = [
            'title' => ['label' => 'Title', 'type'=>'text'],
            'reason' => ['label' => 'Reason Description', 'type'=>'textarea'],
        ];

        $this->newValidateRules = [
            'title' => 'required|min:1',
        ];

        $this->updateValidateRules = $this->newValidateRules;

        $this->initControls();

    }

    public function render()
    {
        return view('livewire.settings.returnreason.invoice-return-reason-component');
    }
}
