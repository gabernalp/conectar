<?php

namespace App\Http\Controllers\Frontend;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDeviceRequest;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DevicesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('device_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $devices = Device::all();

        return view('frontend.devices.index', compact('devices'));
    }

    public function create()
    {
        abort_if(Gate::denies('device_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.devices.create');
    }

    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->all());

        return redirect()->route('frontend.devices.index');
    }

    public function edit(Device $device)
    {
        abort_if(Gate::denies('device_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.devices.edit', compact('device'));
    }

    public function update(UpdateDeviceRequest $request, Device $device)
    {
        $device->update($request->all());

        return redirect()->route('frontend.devices.index');
    }

    public function show(Device $device)
    {
        abort_if(Gate::denies('device_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.devices.show', compact('device'));
    }

    public function destroy(Device $device)
    {
        abort_if(Gate::denies('device_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $device->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeviceRequest $request)
    {
        Device::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
