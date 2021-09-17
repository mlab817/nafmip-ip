<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'type'              => 'Feature',
            'properties'        => [
                'name'          => $this->title,
                'intervention'  => new InterventionResource($this->intervention),
                'target'        => $this->quantity,
                'cost'          => $this->cost,
            ],
            'geometry'          => $this->location_map,
        ];
    }
}
