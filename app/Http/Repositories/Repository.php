<?php


namespace App\Http\Repositories;


use App\Http\Services\Services;
use Illuminate\Database\Eloquent\Model;

class Repository implements Services
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    } //end __construct()

    public function getInstance(int $id)
    {
        return $this->model::find($id);
    }

    public function storeInstance($data)
    {
        return $this->model::create($data);
    }

    public function updateInstance($id, $data)
    {
        $instance = $this->getInstance($id);
        if ($instance) {
            $instance->update($data);
        }

    }//end updateInstance()

    public function query(){
        return $this->model;
    }

} //end class
