<?php

namespace App\Http\Requests;

use App\Models\Platform;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlatformRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('platform_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:platforms,name,' . request()->route('platform')->id,
            ],
        ];
    }
}
