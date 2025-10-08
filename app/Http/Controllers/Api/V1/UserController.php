<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
// use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return new UserResource($user);
    }

    public function show(User $mahasiswa)
    {
        return new UserResource($mahasiswa);
    }
}
