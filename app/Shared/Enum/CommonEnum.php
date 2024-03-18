<?php

namespace App\Shared\Enum;

interface CommonEnum
{
    const ID = "id";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
    const DELETED_AT = "deleted_at";

    const MESSAGE_ERROR = "message_error";
    const MESSAGE_SUCCESS = "message_success";
    const LOG_TYPE_ERROR = "error";
    const LOG_TYPE_INFO = "info";
    const ERROR_MESSAGE = "Ha ocurrido un error, vuelva a intentar";
    const REGISTER_MESSAGE = "Registrado exitosamente";
    const UPDATE_MESSAGE = "Actualizado exitosamente";
} //end interface
