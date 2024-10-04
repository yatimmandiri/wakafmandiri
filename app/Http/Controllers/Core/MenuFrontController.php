<?php

namespace App\Http\Controllers\Core;

use App\DataTables\MenuFrontDataTable;
use App\Http\Controllers\Controller;
use App\Models\MenuFront;
use App\Http\Requests\StoreMenuFrontRequest;
use App\Http\Requests\UpdateMenuFrontRequest;
use App\Http\Resources\Resource\MenuFrontResource;
use Illuminate\Http\Request;

class MenuFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MenuFrontDataTable $datatables)
    {
        $data['pageTitle'] = 'Menu List';
        return $datatables->render('core.menus-front.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuFrontRequest $request)
    {
        $menus = MenuFront::create($request->all());

        $MenuFrontResource = MenuFrontResource::make($menus)->roles()->sync($request->roles);

        return $this->sendResponse($MenuFrontResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuFront $menu)
    {
        $menusResource = MenuFrontResource::make($menu);
        return $this->sendResponse($menusResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuFrontRequest $request, MenuFront $menu)
    {
        $menu->update($request->all());
        $menu->roles()->sync($request->roles);

        // $menu->name = $request->name;
        // $menu->link = $request->link;
        // $menu->icon = $request->icon;
        // $menu->parent = $request->parent;
        // $menu->roles()->sync($request->roles);
        // $menu->save();

        $menusResource = MenuFrontResource::make($menu);

        return $this->sendResponse($menusResource, 'Update Data Successfully');
    }

    public function menuOrder(Request $request, MenuFront $menu)
    {
        $menu->order = $request->order;
        $menu->save();

        $menusResource = MenuFrontResource::make($menu);

        return $this->sendResponse($menusResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuFront $menu)
    {
        $menu->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
