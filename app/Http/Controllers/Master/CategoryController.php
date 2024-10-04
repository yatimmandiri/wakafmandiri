<?php

namespace App\Http\Controllers\Master;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Resource\CategoryResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $datatables)
    {
        $data['pageTitle'] = 'Categories List';
        return $datatables->render('master.categories.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            $images = $request->file('images')->store('uploads', 'public');
        } else {
            $images = 'images.png';
        }

        $categories = Category::create(array_merge($request->all(), [
            'feature_image' => $images,
            'slug' => Str::slug($request->name)
        ]));

        $categoryResource = CategoryResource::make($categories);
        return $this->sendResponse($categoryResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $categoriesResource = CategoryResource::make($category);
        return $this->sendResponse($categoriesResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            if ($category->images != null || $category->images != '') {
                Storage::disk('public')->delete($category->images);
            }

            $paths = $request->file('images')->store('uploads', 'public');
            $category->feature_image = $paths;
        }

        $category->save();

        $categoriesResource = CategoryResource::make($category);
        return $this->sendResponse($categoriesResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
