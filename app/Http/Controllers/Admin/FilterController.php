<?php

namespace App\Http\Controllers\Admin;

use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController
{
    public function index()
    {
        $filters = Filter::all();
        return view('admin.mail.filter', compact('filters'));
    }

    public function set(Request $request)
    {
        $filter = Filter::find(1);
        $filter->mailto = $request->mailto;
        $filter->pdfFromBody = $request->pdfFromBody;
        $filter->logo = $request->logo;
        $filter->profile = $request->profile;
        $filter->allowEmptyContent = $request->allowEmptyContent;
        $filter->save();
        $filters = Filter::all();
        return view('admin.mail.filter', compact('filters'));
    }
}
