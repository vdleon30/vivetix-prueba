<?php

namespace App\Http\Requests\Tickets;

use App\Shared\Enum\TicketEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class SaveOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            TicketEnum::QUANTITY => ['required', 'numeric'],
            TicketEnum::CLIENT_NAME => ['required', 'string', 'max:255'],
            TicketEnum::CLIENT_EMAIL => ['required', 'string', 'max:255'],
            TicketEnum::EVENT_ID => ['required', 'numeric', 'exists:events,id'],
            TicketEnum::FILE  =>  ['required', 'file', 'mimes:pdf,jpg,jpeg,png,gif,bmp,svg,webp', 'max:100000'], # 10000kb = 10mb

        ];
    }
}
