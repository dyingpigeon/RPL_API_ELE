<?php
// app/Http/Controllers/Api/V2/UserController.php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\V2\UpdateUserRequest;
use App\Http\Resources\V2\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, User $user)
    {
        Log::info('=== CONTROLLER UPDATE METHOD START ===');
        Log::info('User ID from route: ' . $user->id);
        Log::info('User current data:', [
            'name' => $user->name,
            'photo' => $user->photo
        ]);

        try {
            Log::info('=== BEFORE VALIDATION ===');
            $data = $request->validated();
            Log::info('=== AFTER VALIDATION ===');
            Log::info('Validated data:', $data);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('VALIDATION FAILED:');
            Log::error('Validation errors:', $e->errors());
            Log::error('Request data:', $request->all());
            throw $e;
        } catch (\Exception $e) {
            Log::error('UNEXPECTED ERROR: ' . $e->getMessage());
            Log::error('Stack trace:', ['trace' => $e->getTraceAsString()]);
            throw $e;
        }

        // Debug detailed request information
        Log::info('=== REQUEST DETAILS ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request content type: ' . $request->header('Content-Type'));
        Log::info('Request has name: ' . ($request->has('name') ? 'YES' : 'NO'));
        Log::info('Request name value: ' . $request->input('name', 'NULL'));
        Log::info('Request has photo file: ' . ($request->hasFile('photo') ? 'YES' : 'NO'));
        
        // Check all input fields
        $allInput = $request->all();
        Log::info('All input fields: ' . implode(', ', array_keys($allInput)));
        foreach ($allInput as $key => $value) {
            if ($key !== '_token' && $key !== '_method') {
                Log::info("Input {$key}: " . (is_string($value) ? $value : json_encode($value)));
            }
        }

        // Check files
        $allFiles = $request->allFiles();
        Log::info('All files: ' . implode(', ', array_keys($allFiles)));
        foreach ($allFiles as $key => $file) {
            Log::info("File {$key}:", [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'is_valid' => $file->isValid()
            ]);
        }

        // Process photo upload
        if ($request->hasFile('photo')) {
            Log::info('=== PROCESSING PHOTO UPLOAD ===');
            try {
                $photoFile = $request->file('photo');
                Log::info('Photo file details:', [
                    'original_name' => $photoFile->getClientOriginalName(),
                    'size' => $photoFile->getSize(),
                    'mime_type' => $photoFile->getMimeType(),
                    'extension' => $photoFile->getClientOriginalExtension(),
                    'is_valid' => $photoFile->isValid()
                ]);

                // Delete old photo if exists
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Log::info('Deleting old photo: ' . $user->photo);
                    Storage::disk('public')->delete($user->photo);
                } else {
                    Log::info('No old photo to delete');
                }

                // Generate new filename
                $extension = $photoFile->getClientOriginalExtension();
                $timestamp = time();
                $fileName = 'user_' . $user->id . '_' . $timestamp . '.' . $extension;
                Log::info('Generated filename: ' . $fileName);

                // Store file
                $path = $photoFile->storeAs('users', $fileName, 'public');
                $data['photo'] = $path;
                Log::info('Photo stored at: ' . $path);

            } catch (\Exception $e) {
                Log::error('PHOTO UPLOAD ERROR: ' . $e->getMessage());
                throw $e;
            }
        } else {
            Log::info('No photo file provided for upload');
        }

        // Update user
        Log::info('=== UPDATING USER ===');
        Log::info('Data to update:', $data);
        
        try {
            $user->update($data);
            Log::info('User updated successfully');
            
            // Log updated user data
            $updatedUser = User::find($user->id);
            Log::info('User after update:', [
                'name' => $updatedUser->name,
                'photo' => $updatedUser->photo
            ]);
            
        } catch (\Exception $e) {
            Log::error('USER UPDATE ERROR: ' . $e->getMessage());
            Log::error('Update error details:', ['error' => $e->getTraceAsString()]);
            throw $e;
        }

        Log::info('=== RETURNING RESPONSE ===');
        return new UserResource($user);
    }

    public function show(User $user)
    {
        Log::info('=== SHOW USER ===');
        Log::info('Showing user ID: ' . $user->id);
        return new UserResource($user);
    }

    public function deletePhoto(User $user)
    {
        Log::info('=== DELETE PHOTO ===');
        Log::info('Deleting photo for user ID: ' . $user->id);
        Log::info('Current photo: ' . ($user->photo ?: 'NULL'));

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Log::info('Deleting photo file: ' . $user->photo);
            Storage::disk('public')->delete($user->photo);
            $user->update(['photo' => null]);
            Log::info('Photo deleted successfully');
        } else {
            Log::info('No photo to delete');
        }

        return new UserResource($user);
    }
}