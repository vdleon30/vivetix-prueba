<?php

namespace App\Http\Requests\Events;

use Carbon\Carbon;
use App\Shared\Enum\EventEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            EventEnum::TITLE => ['required', 'string', 'max:255'],
            EventEnum::DESCRIPTION => ['required', 'string', 'max:255'],
            EventEnum::DATE => ['required', 'date', 'after:' . Carbon::now()->format('Y-m-d')],
            EventEnum::QUANTITY => ['required', 'numeric', 'min:1'],
        ];
    }
}
