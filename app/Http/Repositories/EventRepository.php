<?php


namespace App\Http\Repositories;

use App\Models\Event;
use App\Http\Services\EventServices;
use Illuminate\Database\Eloquent\Model;

class EventRepository extends Repository implements EventServices
{
    protected $model;
    public function __construct(Event $model)
    {
        $this->model = $model;
        parent::__construct($model);

    } //end __construct()

} //end class
