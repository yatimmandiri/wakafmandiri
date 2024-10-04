<?php

namespace App\Http\Controllers\Master;

use App\DataTables\PartnerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Http\Resources\Resource\PartnerResource;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PartnerDataTable $datatables)
    {
        $data['pageTitle'] = 'Partner List';
        return $datatables->render('master.partners.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartnerRequest $request)
    {
        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            $images = $request->file('images')->store('uploads', 'public');
        } else {
            $images = 'images.png';
        }

        $partners = Partner::create(array_merge($request->all(), [
            'logo' => $images
        ]));

        $partnerResource = PartnerResource::make($partners);
        return $this->sendResponse($partnerResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        $partnersResource = PartnerResource::make($partner);
        return $this->sendResponse($partnersResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner->name = $request->name;

        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            if ($partner->logo != null || $partner->logo != '') {
                Storage::disk('public')->delete($partner->images);
            }

            $paths = $request->file('images')->store('uploads', 'public');
            $partner->logo = $paths;
        }

        $partner->save();

        $partnersResource = PartnerResource::make($partner);
        return $this->sendResponse($partnersResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
