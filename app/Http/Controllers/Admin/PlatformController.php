<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlatformRequest;
use App\Http\Requests\StorePlatformRequest;
use App\Http\Requests\UpdatePlatformRequest;
use App\Models\Platform;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlatformController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('platform_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $platforms = Platform::all();

        return view('admin.platforms.index', compact('platforms'));
    }

    public function create()
    {
        abort_if(Gate::denies('platform_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.platforms.create');
    }

    public function store(StorePlatformRequest $request)
    {
        $platform = Platform::create($request->all());

        return redirect()->route('admin.platforms.index');
    }

    public function edit(Platform $platform)
    {
        abort_if(Gate::denies('platform_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.platforms.edit', compact('platform'));
    }

    public function update(UpdatePlatformRequest $request, Platform $platform)
    {
        $platform->update($request->all());

        return redirect()->route('admin.platforms.index');
    }

    public function show(Platform $platform)
    {
        abort_if(Gate::denies('platform_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.platforms.show', compact('platform'));
    }

    public function destroy(Platform $platform)
    {
        abort_if(Gate::denies('platform_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $platform->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlatformRequest $request)
    {
        Platform::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
