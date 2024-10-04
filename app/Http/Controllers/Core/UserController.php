<?php

namespace App\Http\Controllers\Core;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Resource\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $datatables)
    {
        $data['pageTitle'] = 'User List';
        return $datatables->render('core.users.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $defaultValue = [
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ];

        $user = User::create(array_merge($request->all(), $defaultValue))->assignRole($request->roles);
        $userResource = UserResource::make($user);

        return $this->sendResponse($userResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userResource = UserResource::make($user);
        return $this->sendResponse($userResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->handphone = $request->handphone;
        // $user->syncRoles($request->roles);
        // $user->save();

        $user->update($request->all());
        $user->syncRoles($request->roles);

        $userResource = UserResource::make($user);

        return $this->sendResponse($userResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->sendResponse([], 'Delete Data Successfully');
    }
}
