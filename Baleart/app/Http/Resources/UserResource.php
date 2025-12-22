<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'     => $this->name,
            'lastname' => $this->lastname,
            'email'    => $this->email,
            'dni'      => $this->dni,
            'phone'    => $this->phone,
            'role'     => $this->role->name,
            'meetings' => $this->meetings,
            'comments' => $this->comments,
            'images'   => $this->images,
        ];
    }
}
