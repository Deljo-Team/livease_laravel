<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $error = $errors->first();
        throw new HttpResponseException(response()->json([
            'Success' => false,
            'Message' => $error,
            'Title' => 'Error',
            'Data' => ['error' => $validator->errors()]
        ], 422));
    }
}
