<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFortnoxRequest;
use App\Http\Requests\UpdateFortnoxRequest;
use App\Http\Resources\Admin\FortnoxResource;
use App\Models\Fortnox;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FortnoxApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fortnox_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FortnoxResource(Fortnox::with(['user'])->get());
    }

    public function store(StoreFortnoxRequest $request)
    {
        $fortnox = Fortnox::create($request->all());

        return (new FortnoxResource($fortnox))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fortnox $fortnox)
    {
        abort_if(Gate::denies('fortnox_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FortnoxResource($fortnox->load(['user']));
    }

    public function update(UpdateFortnoxRequest $request, Fortnox $fortnox)
    {
        $fortnox->update($request->all());

        return (new FortnoxResource($fortnox))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fortnox $fortnox)
    {
        abort_if(Gate::denies('fortnox_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fortnox->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
