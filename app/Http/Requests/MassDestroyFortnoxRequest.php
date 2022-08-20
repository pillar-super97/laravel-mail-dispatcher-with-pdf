<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Fortnox;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFortnoxRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('fortnox_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:fortnoxes,id',
]
    
}

}