<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\FloorResource;
use App\Models\Floor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FloorsController extends BaseController
{
    public function index(): JsonResponse
    {
        $floors = Floor::all();
        return $this->sendSuccessResponse(FloorResource::collection($floors), 'success');
    }

    public function show($id): JsonResponse
    {
        $floor = Floor::find($id);
        if (is_null($floor))
            return $this->sendError('Floor does not exist');
        return $this->sendSuccessResponse(new FloorResource($floor), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|string',
                'bounds' => 'required|string',
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $floor = Floor::create($input);
            return $this->sendSuccessResponse(new FloorResource($floor), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, Floor $floor): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|string',
                'bounds' => 'required|string',
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $floor->update($input);
            return $this->sendSuccessResponse(new FloorResource($floor), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(Floor $floor): JsonResponse
    {
        try {
            $floor->delete();
            return $this->sendSuccessResponse([], 'Floor was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
