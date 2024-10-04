<?php

namespace App\Http\Controllers\Master;

use App\DataTables\CampaignDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Resources\Resource\CampaignResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CampaignDataTable $datatable)
    {
        $data['pageTitle'] = 'Campaigns List';
        return $datatable->render('master.campaigns.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['pageTitle'] = 'Campaigns Create';
        return view('master.campaigns.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            $feature_image = $request->file('feature_image')->store('uploads', 'public');
        } else {
            $feature_image = 'images.png';
        }

        $defaultValue = [
            'name' => Str::title($request->name),
            'slug' => Str::slug($request->name, '-'),
            'excerpt' => Str::limit(strip_tags($request->description), 200),
            'feature_image' => $feature_image,
        ];

        $campaigns = Campaign::create(array_merge($request->all(), $defaultValue));

        $campaignsResource = CampaignResource::make($campaigns);

        return $this->sendResponse($campaignsResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $data['pageTitle'] = 'Campaign Show';
        $data['campaign'] = $campaign;
        return view('master.campaigns.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $data['pageTitle'] = 'Campaigns Update';
        $data['campaign'] = $campaign;
        return view('master.campaigns.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $campaign->name = Str::title($request->name);
        $campaign->slug = Str::slug($request->name, '-');
        $campaign->description = $request->description;
        $campaign->categories_id = $request->categories_id;
        $campaign->excerpt = Str::limit(strip_tags($request->description), 200);

        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            if ($campaign->feature_image != 'images.png') {
                Storage::disk('public')->delete($campaign->feature_image);
            }

            $paths = $request->file('feature_image')->store('uploads', 'public');
            $campaign->feature_image = $paths;
        }

        $campaign->save();

        return $this->sendResponse($campaign, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }

    public function restore($id)
    {
        Campaign::withTrashed()->find($id)->restore();
        return $this->sendResponse([], 'Restore Data Successfully');
    }

    public function status(Campaign $campaign)
    {
        $campaigns = Campaign::find($campaign->id);

        if ($campaign->status == 'Y') {
            $campaigns->status = 'N';
        } else {
            $campaigns->status = 'Y';
        }

        $campaigns->save();
        $campaignsResource = CampaignResource::make($campaign);

        return $this->sendResponse($campaignsResource, 'Update Status Successfully');
    }
}
