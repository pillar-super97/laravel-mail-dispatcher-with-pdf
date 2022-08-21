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
        $filter->multipleJpgIntoPdf = $request->multipleJpgIntoPdf;
        $filter->sizeLimit = $request->sizeLimit ? 1 : 0;
        $filter->sizeUnit = $request->sizeUnit;
        $filter->minSize = $request->minSize;
        $filter->maxSize = $request->maxSize;
        $filter->extensionLimit = $request->extensionLimit ? 1 : 0;
        $filter->exExtension = $request->exExtension ? $request->exExtension : '';
        $filter->wordLimit = $request->wordLimit ? 1 : 0;
        $filter->inWord = $request->inWord ? $request->inWord : '';
        $filter->save();
        $filters = Filter::all();
        return view('admin.mail.filter', compact('filters'));
    }
}
