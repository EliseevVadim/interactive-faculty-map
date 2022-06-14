<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DayOfWeekResource;
use App\Http\Resources\PairRepeatingResource;
use App\Models\DayOfWeek;
use App\Models\PairRepeating;

class MetaInfoController extends BaseController
{
    public function loadAllPairsRepeatings()
    {
        $pairRepeatings = PairRepeating::all();
        return $this->sendSuccessResponse(PairRepeatingResource::collection($pairRepeatings), 'success');
    }

    public function loadAllDaysOfWeek()
    {
        $daysOfWeek = DayOfWeek::all();
        return $this->sendSuccessResponse(DayOfWeekResource::collection($daysOfWeek), 'success');
    }
}
