<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['pageTitle'] = 'Settings Website';
        return view('settings.website', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        $settings = $settings->first();

        return $this->sendResponse($settings, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request, string $id)
    {
        $settings = Settings::find($id);

        $settings->name = $request->name;
        $settings->description = $request->description;
        $settings->address = $request->address;
        $settings->phone = $request->phone;
        $settings->handphone = $request->handphone;
        $settings->email = $request->email;
        $settings->facebook = $request->facebook;
        $settings->twitter = $request->twitter;
        $settings->instagram = $request->instagram;
        $settings->youtube = $request->youtube;
        $settings->save();

        return $this->sendResponse($settings, 'Update Data Successfully');
    }

    public function updateLogo(Request $request)
    {
        $settings = Settings::find(1);

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if ($settings->logo != 'logo.png') {
                Storage::disk('public')->delete($settings->logo);
            }

            $paths = $request->file('logo')->store('uploads', 'public');
            $settings->logo = $paths;
        }

        if ($request->hasFile('logoWhite') && $request->file('logoWhite')->isValid()) {
            if ($settings->logoWhite != 'logoWhite.png') {
                Storage::disk('public')->delete($settings->logoWhite);
            }

            $paths = $request->file('logoWhite')->store('uploads', 'public');
            $settings->logoWhite = $paths;
        }

        if ($request->hasFile('favicon') && $request->file('favicon')->isValid()) {
            if ($settings->favicon != 'favicon.png') {
                Storage::disk('public')->delete($settings->favicon);
            }

            $paths = $request->file('favicon')->store('uploads', 'public');
            $settings->favicon = $paths;
        }

        if ($request->hasFile('sertifikat') && $request->file('sertifikat')->isValid()) {
            if ($settings->sertifikat != 'sertifikat.png') {
                Storage::disk('public')->delete($settings->sertifikat);
            }

            $paths = $request->file('sertifikat')->store('uploads', 'public');
            $settings->sertifikat = $paths;
        }

        $settings->save();

        return $this->sendResponse($settings, 'Update Data Successfully');
    }

    public function ckEditorUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
}
