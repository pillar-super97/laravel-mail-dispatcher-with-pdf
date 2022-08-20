<?php

namespace App\Http\Requests;

use App\Models\Fortnox;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFortnoxRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fortnox_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'client' => [
                'string',
                'required',
                'unique:fortnoxes',
            ],
            'secret' => [
                'string',
                'required',
            ],
            'access_code' => [
                'string',
                'required',
                'unique:fortnoxes',
            ],
            'access_token' => [
                'string',
                'nullable',
            ],
        ];
    }
}
