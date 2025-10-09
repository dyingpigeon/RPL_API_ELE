<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// App\Http\Resources\UserResource.php
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'userId' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}

