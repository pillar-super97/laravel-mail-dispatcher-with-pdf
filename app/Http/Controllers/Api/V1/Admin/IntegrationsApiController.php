<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntegrationRequest;
use App\Http\Requests\UpdateIntegrationRequest;
use App\Http\Resources\Admin\IntegrationResource;
use App\Models\Integration;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IntegrationsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('integration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IntegrationResource(Integration::with(['user', 'platform'])->get());
    }

    public function store(StoreIntegrationRequest $request)
    {
        $integration = Integration::create($request->all());

        return (new IntegrationResource($integration))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Integration $integration)
    {
        abort_if(Gate::denies('integration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IntegrationResource($integration->load(['user', 'platform']));
    }

    public function update(UpdateIntegrationRequest $request, Integration $integration)
    {
        $integration->update($request->all());

        return (new IntegrationResource($integration))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Integration $integration)
    {
        abort_if(Gate::denies('integration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $integration->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
