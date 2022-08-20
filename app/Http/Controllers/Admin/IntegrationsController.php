<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIntegrationRequest;
use App\Http\Requests\StoreIntegrationRequest;
use App\Http\Requests\UpdateIntegrationRequest;
use App\Models\Integration;
use App\Models\Platform;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IntegrationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('integration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $integrations = Integration::with(['user', 'platform'])->get();

        return view('admin.integrations.index', compact('integrations'));
    }

    public function create()
    {
        abort_if(Gate::denies('integration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $platforms = Platform::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.integrations.create', compact('users', 'platforms'));
    }

    public function store(StoreIntegrationRequest $request)
    {
        $integration = Integration::create($request->all());

        return redirect()->route('admin.integrations.index');
    }

    public function edit(Integration $integration)
    {
        abort_if(Gate::denies('integration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $platforms = Platform::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $integration->load('user', 'platform');

        return view('admin.integrations.edit', compact('users', 'platforms', 'integration'));
    }

    public function update(UpdateIntegrationRequest $request, Integration $integration)
    {
        $integration->update($request->all());

        return redirect()->route('admin.integrations.index');
    }

    public function show(Integration $integration)
    {
        abort_if(Gate::denies('integration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $integration->load('user', 'platform');

        return view('admin.integrations.show', compact('integration'));
    }

    public function destroy(Integration $integration)
    {
        abort_if(Gate::denies('integration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $integration->delete();

        return back();
    }

    public function massDestroy(MassDestroyIntegrationRequest $request)
    {
        Integration::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
