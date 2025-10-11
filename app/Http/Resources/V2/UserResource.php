<?php
// app/Http/Resources/V2/UserResource.php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'userId' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'photo' => $this->photo, // path file di storage
            'photo_url' => $this->photo_url, // full URL untuk akses foto
        ];
    }
}