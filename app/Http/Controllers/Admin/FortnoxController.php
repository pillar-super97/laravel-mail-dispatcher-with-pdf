<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFortnoxRequest;
use App\Http\Requests\StoreFortnoxRequest;
use App\Http\Requests\UpdateFortnoxRequest;
use App\Models\Fortnox;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FortnoxController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fortnox_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fortnoxes = Fortnox::with(['user'])->get();

        return view('admin.fortnoxes.index', compact('fortnoxes'));
    }

    public function create()
    {
        abort_if(Gate::denies('fortnox_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.fortnoxes.create', compact('users'));
    }

    public function store(StoreFortnoxRequest $request)
    {
        $fortnox = Fortnox::create($request->all());

        return redirect()->route('admin.fortnoxes.index');
    }

    public function edit(Fortnox $fortnox)
    {
        abort_if(Gate::denies('fortnox_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fortnox->load('user');

        return view('admin.fortnoxes.edit', compact('users', 'fortnox'));
    }

    public function update(UpdateFortnoxRequest $request, Fortnox $fortnox)
    {
        $fortnox->update($request->all());

        return redirect()->route('admin.fortnoxes.index');
    }

    public function show(Fortnox $fortnox)
    {
        abort_if(Gate::denies('fortnox_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fortnox->load('user');

        return view('admin.fortnoxes.show', compact('fortnox'));
    }

    public function destroy(Fortnox $fortnox)
    {
        abort_if(Gate::denies('fortnox_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fortnox->delete();

        return back();
    }

    public function massDestroy(MassDestroyFortnoxRequest $request)
    {
        Fortnox::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
