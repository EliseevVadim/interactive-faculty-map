<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PairResource;
use App\Models\Pair;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PairsController extends BaseController
{
    public function index(): JsonResponse
    {
        $pairs = Pair::all();
        return $this->sendSuccessResponse(PairResource::collection($pairs), 'success');
    }

    public function show($id): JsonResponse
    {
        $pair = Pair::find($id);
        if (is_null($pair))
            return $this->sendError('Pair does not exist');
        return $this->sendSuccessResponse(new PairResource($pair), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'pair_name' => 'required|string',
                'pair_info_id' => 'required|integer',
                'teacher_id' => 'required|integer',
                'auditorium_id' => 'required|integer',
                'discipline_id' => 'required|integer',
                'day_of_week_id' => 'required|integer',
                'repeating_id' => 'required|integer',
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $pair = Pair::create($input);
            return $this->sendSuccessResponse(new PairResource($pair), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, Pair $pair): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'pair_name' => 'required|string',
                'pair_info_id' => 'required|integer',
                'teacher_id' => 'required|integer',
                'auditorium_id' => 'required|integer',
                'discipline_id' => 'required|integer',
                'day_of_week_id' => 'required|integer',
                'repeating_id' => 'required|integer',
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $pair->update($input);
            return $this->sendSuccessResponse(new PairResource($pair), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(Pair $pair): JsonResponse
    {
        try {
            $pair->delete();
            return $this->sendSuccessResponse([], 'Teacher was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
