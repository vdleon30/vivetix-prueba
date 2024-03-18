<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class FormRequestCustom extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        return redirect()->back()->withErrors($validator)->withInput();
    } //end failedValidation()
} //end class
