<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CompanyNotIdentifiedException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'Success' => false,
            'Message' => 'Comapny identification failed.',
            'Title'   => 'Company Not Identified',
        ], 403);
    }
}
