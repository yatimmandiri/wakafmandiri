<?php

namespace App\Http\Controllers\Postingan;

use App\DataTables\NewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\Resource\NewsResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NewsDataTable $datatables)
    {
        $data['pageTitle'] = 'News List';
        return $datatables->render('postingan.news.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['pageTitle'] = 'News Create';
        return view('postingan.news.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            $images = $request->file('feature_image')->store('uploads', 'public');
        } else {
            $images = 'images.png';
        }

        $news = News::create([
            'title' => Str::title($request->name),
            'slug' => Str::slug($request->name),
            'content' => $request->description,
            'excerpt' => Str::limit(strip_tags($request->description), 100),
            'images' => $images
        ]);

        $newsResource = NewsResource::make($news);

        return $this->sendResponse($newsResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $newsResource = NewsResource::make($news);
        return $this->sendResponse($newsResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $data['pageTitle'] = 'News List';
        $data['news'] = $news;
        return view('postingan.news.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $news->title = Str::title($request->name);
        $news->slug = Str::slug($request->name);
        $news->content = $request->description;
        $news->excerpt = Str::limit(strip_tags($request->description), 100);

        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            if ($news->images != 'images.png') {
                Storage::disk('public')->delete($news->images);
            }

            $paths = $request->file('feature_image')->store('uploads', 'public');
            $news->images = $paths;
        }

        $news->save();

        $newsResource = NewsResource::make($news);
        return $this->sendResponse($newsResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();
        return $this->sendResponse([], 'Delete Data Successfully');
    }
}
