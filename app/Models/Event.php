<?php

namespace App\Models;

use App\Shared\Enum\EventEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model implements EventEnum
{
    use HasFactory;

    protected $table = self::TABLE;
    protected $fillable = [
        self::TITLE,
        self::DESCRIPTION,
        self::QUANTITY,
        self::DATE,
        self::STATUS,
    ];


    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
