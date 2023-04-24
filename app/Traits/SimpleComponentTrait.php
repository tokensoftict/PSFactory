<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait SimpleComponentTrait
{
    use LivewireAlert;

    public $model;

    public array $data;

    public String $modalTitle = "New";

    public String $saveButton = "Save";

    public String $modalName = "";

    public array $unitConfig = [];

    public $modelId;

    public array $newValidateRules;

    public array $editcallback;

    public array $updateValidateRules;


    public function boot()
    {
        $this->listeners = [
            'editData' => 'edit',
            'toggleData' => 'toggle',
            'destoryData' => 'destroy',
        ];

        $this->unitConfig = config('convert');
    }

    public function initControls()
    {
        foreach($this->data as $key=>$value)
        {
            $this->{$key} = "";
        }

    }

    public function save()
    {

        $this->validate($this->newValidateRules);

        $model = new $this->model();
        $model = $this->parseData($model);
        $model->save();
        $this->emit('refreshData',[]);
        $this->dispatchBrowserEvent("closeModal", []);
    }


    protected function parseData($model)
    {
        foreach($this->data as $key=>$value)
        {
            if($key === "password") {
                if(!empty($this->{$key})){
                    $model->{$key} = bcrypt($this->{$key});
                    continue;
                }else {
                    continue;
                }
            }
            $model->{$key} = $this->{$key} === "" ? NULL : $this->{$key};
        }
        return $model;
    }

    public function update($id)
    {
        $this->modelId = $id;

        $this->validate($this->updateValidateRules);

        $model = $this->model::find($id);
        $model = $this->parseData($model);
        $model->save();
        $this->emit('refreshData',[]);
        $this->dispatchBrowserEvent("closeModal", []);
    }

    public function get()
    {
        return $this->model::all();
    }

    public function edit($id)
    {
        $this->modelId = $id;
        $data = $this->model::find($id);
        foreach($this->data as $key=>$value)
        {
            $this->{$key} = $data->{$key};
        }

        if(isset($this->password)){
            $this->password = "";
        }

        $this->modalTitle = "Update";

        $this->saveButton = "Update";

        if(isset($this->editcallback) && count($this->editcallback) > 0)
        {
            foreach ($this->editcallback as $callback)
            {
                $this->$callback();
            }

        }


        $this->emit('refreshData',[]);
        $this->dispatchBrowserEvent("openModal", []);
    }


    public function new()
    {
        foreach($this->data as $key=>$value)
        {
            $this->{$key} = "";
        }

        $this->modalTitle = "New";

        $this->saveButton = "Save";

        $this->dispatchBrowserEvent("openModal", []);
    }

    public function toggle($id)
    {
        $this->modelId = $id;
        $model = $this->model::find($id);
        $model->status = !$model->status;
        $model->save();
        $this->emit('refreshData',[]);
    }

    public function destroy($id)
    {
        $this->modelId = $id;
        $this->model::find($id)->delete();
        $this->emit('refreshData',[]);
    }



}
