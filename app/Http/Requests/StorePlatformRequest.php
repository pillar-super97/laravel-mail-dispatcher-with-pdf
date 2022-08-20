<?php

namespace App\Http\Requests;

use App\Models\Platform;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePlatformRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('platform_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:platforms',
            ],
        ];
    }
}
