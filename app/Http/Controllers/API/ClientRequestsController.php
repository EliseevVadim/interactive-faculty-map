<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PairResource;
use App\Models\Auditorium;
use App\Models\Pair;

class ClientRequestsController extends BaseController
{
    public function loadAuditoriumInfo($id)
    {
        $auditorium = Auditorium::find($id);
        return $this->sendSuccessResponse([
            'auditorium_name' => $auditorium->auditorium_name,
            'teacher_name' => $auditorium->teacher->fio,
            'pairs' => PairResource::collection($auditorium->pairs)
        ], 'success');
    }

    public function loadGroupScheduleById($groupId)
    {
        $pairs = Pair::where('group_id', $groupId)->get()->all();
        return $this->sendSuccessResponse(PairResource::collection($pairs), 'success');
        dd($pairs);
    }
}
