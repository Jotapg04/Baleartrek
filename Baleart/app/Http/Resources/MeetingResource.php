<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'day'      => $this->day,
            'time'     => $this->time,
            'users'    => $this->users,
            'comments' => $this->comments,
        ];
    }
}
