<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Platform;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlatformRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('platform_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:platforms,id',
]
    
}

}