<?php

namespace App\Shared\Enum;

interface EventEnum
{

    const TABLE = "events";
    const TITLE = "title";
    const DESCRIPTION = "description";
    const QUANTITY = "quantity";
    const DATE = "date";
    const STATUS = "status";


    const BASIC_INFORMATION = [
        self::TITLE,
        self::DESCRIPTION,
        self::QUANTITY,
        self::DATE
    ];

} //end interface
