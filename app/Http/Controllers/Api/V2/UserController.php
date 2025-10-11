<?php
// app/Http/Controllers/Api/V2/UserController.php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\V2\UpdateUserRequest;
use App\Http\Resources\V2\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $extension = $request->file('photo')->getClientOriginalExtension();
            $timestamp = time();

            // Format: user_{id}_{timestamp}.{ext}
            $fileName = 'user_' . $user->id . '_' . $timestamp . '.' . $extension;

            $path = $request->file('photo')->storeAs('users', $fileName, 'public');
            $data['photo'] = $path;
        }

        $user->update($data);

        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function deletePhoto(User $user)
    {
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
            $user->update(['photo' => null]);
        }

        return new UserResource($user);
    }
}
