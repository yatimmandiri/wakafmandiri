<?php

namespace App\Http\Controllers\Master;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Http\Resources\Resource\SliderResource;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $datatables)
    {
        $data['pageTitle'] = 'Slider List';
        return $datatables->render('master.sliders.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            $images = $request->file('images')->store('uploads', 'public');
        } else {
            $images = 'images.png';
        }

        $sliders = Slider::create(array_merge($request->all(), [
            'images' => $images
        ]));

        $sliderResource = SliderResource::make($sliders);
        return $this->sendResponse($sliderResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        $slidersResource = SliderResource::make($slider);
        return $this->sendResponse($slidersResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $slider->name = $request->name;
        $slider->link = $request->link;

        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            if ($slider->images != null || $slider->images != '') {
                Storage::disk('public')->delete($slider->images);
            }

            $paths = $request->file('images')->store('uploads', 'public');
            $slider->images = $paths;
        }

        $slider->save();

        $slidersResource = SliderResource::make($slider);
        return $this->sendResponse($slidersResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
