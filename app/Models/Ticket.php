<?php

namespace App\Models;

use App\Shared\Enum\TicketEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model implements TicketEnum
{
    use HasFactory;
    protected $table = self::TABLE;
    protected $fillable = [
        self::CLIENT_NAME,
        self::CLIENT_EMAIL,
        self::QUANTITY,
        self::EVENT_ID,
        self::PROOF,
    ];




    public function event()
    {
        return $this->belongsTo(Event::class);
    }


    public function scopeEvents($query, $id){
        if(!$id)
            return $query;

        return $query->where(self::EVENT_ID, $id);

    }
}
