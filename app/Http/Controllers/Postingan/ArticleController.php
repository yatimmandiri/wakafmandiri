<?php

namespace App\Http\Controllers\Postingan;

use App\DataTables\ArticleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\Resource\ArticleResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ArticleDataTable $datatables)
    {
        $data['pageTitle'] = 'Article List';
        return $datatables->render('postingan.articles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['pageTitle'] = 'Article Create';
        return view('postingan.articles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            $images = $request->file('feature_image')->store('uploads', 'public');
        } else {
            $images = 'images.png';
        }

        $article = Article::create([
            'title' => Str::title($request->name),
            'slug' => Str::slug($request->name),
            'content' => $request->description,
            'excerpt' => Str::limit(strip_tags($request->description), 100),
            'images' => $images
        ]);

        $articleResource = ArticleResource::make($article);

        return $this->sendResponse($articleResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $articleResource = ArticleResource::make($article);
        return $this->sendResponse($articleResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $data['pageTitle'] = 'Article List';
        $data['article'] = $article;
        return view('postingan.articles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->title = Str::title($request->name);
        $article->slug = Str::slug($request->name);
        $article->content = $request->description;
        $article->excerpt = Str::limit(strip_tags($request->description), 100);

        if ($request->hasFile('feature_image') && $request->file('feature_image')->isValid()) {
            if ($article->images != 'images.png') {
                Storage::disk('public')->delete($article->images);
            }

            $paths = $request->file('feature_image')->store('uploads', 'public');
            $article->images = $paths;
        }

        $article->save();

        $articleResource = ArticleResource::make($article);
        return $this->sendResponse($articleResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return $this->sendResponse([], 'Delete Data Successfully');
    }
}
