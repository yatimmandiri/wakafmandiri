<?php

namespace App\Http\Controllers\Postingan;

use App\DataTables\PageDataTable;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\Resource\PageResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PageDataTable $datatables)
    {
        $data['pageTitle'] = 'Page List';
        return $datatables->render('postingan.pages.index', $data);
    }

    /**
     * Show the form for creating a Page resource.
     */
    public function create()
    {
        $data['pageTitle'] = 'Page Create';
        return view('postingan.pages.create', $data);
    }

    /**
     * Store a Pagely created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            $images = $request->file('feature_image')->store('uploads', 'public');
        } else {
            $images = 'images.png';
        }

        $page = Page::create([
            'title' => Str::title($request->name),
            'slug' => Str::slug($request->name),
            'content' => $request->description,
            'images' => $images
        ]);

        $pageResource = PageResource::make($page);

        return $this->sendResponse($pageResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $pageResource = PageResource::make($page);
        return $this->sendResponse($pageResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $data['pageTitle'] = 'Page List';
        $data['page'] = $page;
        return view('postingan.pages.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->title = Str::title($request->name);
        $page->slug = Str::slug($request->name);
        $page->content = $request->description;

        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            if ($page->images != 'images.png') {
                Storage::disk('public')->delete($page->images);
            }

            $paths = $request->file('feature_image')->store('uploads', 'public');
            $page->images = $paths;
        }

        $page->save();

        $pageResource = PageResource::make($page);
        return $this->sendResponse($pageResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return $this->sendResponse([], 'Delete Data Successfully');
    }
}
