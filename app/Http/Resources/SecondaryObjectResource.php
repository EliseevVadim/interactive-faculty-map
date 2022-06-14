<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SecondaryObjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'object_name' => $this->object_name,
            'position_info' => $this->position_info,
            'floor' => $this->floor->name,
            'floor_id' => $this->floor_id,
            'object_type' => SecondaryObjectTypeResource::make($this->objectType),
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y')
        ];
    }
}
