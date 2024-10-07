<?php

namespace App\Http\Controllers\Master;

use App\DataTables\RekeningDataTable;
use App\Http\Controllers\Controller;
use App\Models\Rekening;
use App\Http\Requests\StoreRekeningRequest;
use App\Http\Requests\UpdateRekeningRequest;
use App\Http\Resources\Resource\RekeningResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RekeningDataTable $datatable)
    {
        $data['pageTitle'] = 'Rekening List';
        return $datatable->render('master.rekenings.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRekeningRequest $request)
    {
        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            $icon = $request->file('icon')->store('uploads', 'public');
        } else {
            $icon = null;
        }

        $rekening = Rekening::create(array_merge($request->all(), [
            'icon' => $icon,
        ]));

        $rekeningResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rekening $rekening)
    {
        $rekeningResource = RekeningResource::make($rekening);
        return $this->sendResponse($rekeningResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRekeningRequest $request, Rekening $rekening)
    {
        $rekening->name = $request->name;
        $rekening->bank = $request->bank;
        $rekening->number = $request->number;
        $rekening->provider = $request->provider;
        $rekening->group = $request->group;
        $rekening->token = $request->token;

        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            if ($rekening->icon != null || $rekening->icon != '') {
                Storage::disk('public')->delete($rekening->icon);
            }

            $paths = $request->file('icon')->store('uploads', 'public');
            $rekening->icon = $paths;
        }

        $rekening->save();

        $rekeningResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rekening $rekening)
    {
        $rekening->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }

    public function restore($id)
    {
        Rekening::withTrashed()->find($id)->restore();
        return $this->sendResponse([], 'Restore Data Successfully');
    }

    public function status(Rekening $rekening)
    {
        $rekenings = Rekening::find($rekening->id);

        if ($rekenings->status == 'Y') {
            $rekenings->status = 'N';
        } else {
            $rekenings->status = 'Y';
        }

        $rekenings->save();
        $rekeningsResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningsResource, 'Update Status Successfully');
    }

    public function recomendation(Rekening $rekening)
    {
        Rekening::where('recomendation', '=', 'Y')->update(['recomendation' => 'N']);

        $rekenings = Rekening::find($rekening->id);
        $rekenings->recomendation = 'Y';

        $rekenings->save();
        $rekeningsResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningsResource, 'Update Status Successfully');
    }

    public function getRekening(Request $request)
    {
        $data = Rekening::query()
            ->latest()
            ->get();

        return $this->sendResponse($data, 'Get Data Successfully');
    }
}
