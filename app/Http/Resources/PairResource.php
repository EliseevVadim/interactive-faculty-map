<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PairResource extends JsonResource
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
            'pair_name' => $this->pair_name,
            'teacher' => TeacherResource::make($this->teacher),
            'pairInfo' => PairInfoResource::make($this->pairInfo),
            'auditorium' => AuditoriumResource::make($this->auditorium),
            'discipline' => DisciplineResource::make($this->discipline),
            'dayOfWeek' => DayOfWeekResource::make($this->dayOfWeek),
            'repeating' => PairRepeatingResource::make($this->repeating),
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y')
        ];
    }
}
