<?php

namespace App\Http\Livewire\RawMaterial\Requests;

use App\Models\Department;
use App\Models\MaterialRequest;
use App\Models\Production;
use App\Repositories\MaterialRequestRepository;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateNewRawMaterialRequestComponent extends Component
{
    use LivewireAlert;


    protected MaterialRequestRepository $materialRequestRepository;

    public MaterialRequest $materialRequest;

    public $productions;

    public $listDepartments;

    public array $data;

    public function boot(MaterialRequestRepository $materialRequestRepository)
    {
        $this->materialRequestRepository = $materialRequestRepository;
    }

    public function mount()
    {
        $this->productions = Production::whereIn('status_id',[
            status('Draft'),
            status('Pending'),
            status('In-Progress'),
            status('Approved')
        ])->get();

        $this->listDepartments = Department::where('status',1)->get();

        $this->data = MaterialRequestRepository::materialRequest(new MaterialRequest());

        if(isset($this->materialRequest->id))
        {
            $this->data = MaterialRequestRepository::materialRequest($this->materialRequest);
        }

    }


    public function requestMaterial()
    {
        if(isset($this->materialRequest->id))
        {
            $this->data['material_request_items'] = json_decode( $this->data['material_request_items'] ,true);
            $request = $this->materialRequestRepository->updateRequest($this->materialRequest, $this->data);
            $message = "Request has been updated and sent successfully!";
        }else{
            $this->data['material_request_items'] = json_decode( $this->data['material_request_items'] ,true);
            $request = $this->materialRequestRepository->createRequest($this->data);
            $message = "Request has been sent successfully!";
        }


        $this->alert(
            "success",
            "Material Request",
            [
                'position' => 'center',
                'timer' => 6000,
                'toast' => false,
                'text' =>  $message,
            ]
        );

        return redirect()->route('rawmaterial.request');
    }



    public function render()
    {
        return view('livewire.raw-material.requests.create-new-raw-material-request-component');
    }
}
