<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'fio' => $this->fio,
            'photo_path' => $this->photo_path,
            'scienceRank' => $this->scienceRank->rank_name,
            'science_rank_id' => $this->science_rank_id,
            'pairs' => PairResource::collection($this->pairs),
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'teachersDisciplines' => TeacherDicsiplineResource::collection($this->teachersDisciplines),
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y')
        ];
    }
}
