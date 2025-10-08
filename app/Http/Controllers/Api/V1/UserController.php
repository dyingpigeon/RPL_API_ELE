<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Models\User;
// use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only('name'));

        return response()->json([
            'message' => 'User name updated successfully!',
            'data' => $user,
        ]);
    }
}
