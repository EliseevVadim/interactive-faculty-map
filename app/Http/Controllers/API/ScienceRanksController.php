<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ScienceRankResource;
use App\Models\ScienceRank;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScienceRanksController extends BaseController
{
    public function index(): JsonResponse
    {
        $scienceRanks = ScienceRank::all();
        return $this->sendSuccessResponse(ScienceRankResource::collection($scienceRanks), 'success');
    }

    public function show($id): JsonResponse
    {
        $scienceRank = ScienceRank::find($id);
        if (is_null($scienceRank))
            return $this->sendError('Science rank does not exist');
        return $this->sendSuccessResponse(new ScienceRankResource($scienceRank), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'rank_name' => 'required|string'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $scienceRank = ScienceRank::create($input);
            return $this->sendSuccessResponse(new ScienceRankResource($scienceRank), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, ScienceRank $scienceRank): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'rank_name' => 'required|string'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $scienceRank->update($input);
            return $this->sendSuccessResponse(new ScienceRankResource($scienceRank), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(ScienceRank $scienceRank): JsonResponse
    {
        try {
            $scienceRank->delete();
            return $this->sendSuccessResponse([], 'Teacher was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
