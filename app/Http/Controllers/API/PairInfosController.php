<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PairInfoResource;
use App\Models\PairInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PairInfosController extends BaseController
{
    public function index(): JsonResponse
    {
        $pairInfos = PairInfo::all();
        return $this->sendSuccessResponse(PairInfoResource::collection($pairInfos), 'success');
    }

    public function show($id): JsonResponse
    {
        $pairInfo = PairInfo::find($id);
        if (is_null($pairInfo))
            return $this->sendError('Pair info does not exist');
        return $this->sendSuccessResponse(new PairInfoResource($pairInfo), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'fio' => 'required|string',
                'photo_path' => 'required|string',
                'science_rank_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $pairInfo = PairInfo::create($input);
            return $this->sendSuccessResponse(new PairInfoResource($pairInfo), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, PairInfo $pairInfo): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'fio' => 'required|string',
                'photo_path' => 'required|string',
                'science_rank_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $pairInfo->update($input);
            return $this->sendSuccessResponse(new PairInfoResource($pairInfo), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(PairInfo $pairInfo): JsonResponse
    {
        try {
            $pairInfo->delete();
            return $this->sendSuccessResponse([], 'Pair info was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
