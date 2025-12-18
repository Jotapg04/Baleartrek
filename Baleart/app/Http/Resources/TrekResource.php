<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrekResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'regNumber' => $this->reg_number,
            'name'      => $this->name,
            'available' => $this->available,

            'municipality' => [
                'name'   => $this->municipality->name,
                'zone'   => $this->municipality->zone->name,
                'island' => $this->municipality->island->name,
            ],

            'places'   => $this->places,
            'meetings' => $this->meetings,
        ];
    }
}
