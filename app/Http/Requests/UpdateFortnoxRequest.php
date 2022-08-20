<?php

namespace App\Http\Requests;

use App\Models\Fortnox;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFortnoxRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fortnox_edit');
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
                'unique:fortnoxes,client,' . request()->route('fortnox')->id,
            ],
            'secret' => [
                'string',
                'required',
            ],
            'access_code' => [
                'string',
                'required',
                'unique:fortnoxes,access_code,' . request()->route('fortnox')->id,
            ],
            'access_token' => [
                'string',
                'nullable',
            ],
        ];
    }
}
