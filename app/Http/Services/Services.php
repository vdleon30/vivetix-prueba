<?php
namespace App\Http\Services;

interface Services
{

    public function getInstance(int $id);
    public function storeInstance($data);
    public function updateInstance($id, $data);
    public function query();


}
