<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DisciplineResource;
use App\Models\Discipline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisciplinesController extends BaseController
{
    public function index(): JsonResponse
    {
        $disciplines = Discipline::all();
        return $this->sendSuccessResponse(DisciplineResource::collection($disciplines), 'success');
    }

    public function show($id): JsonResponse
    {
        $discipline = Discipline::find($id);
        if (is_null($discipline))
            return $this->sendError('Discipline does not exist');
        return $this->sendSuccessResponse(new DisciplineResource($discipline), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'discipline_name' => 'required|string'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $discipline = Discipline::create($input);
            return $this->sendSuccessResponse(new DisciplineResource($discipline), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, Discipline $discipline): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'discipline_name' => 'required|string'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $discipline->update($input);
            return $this->sendSuccessResponse(new DisciplineResource($discipline), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(Discipline $discipline): JsonResponse
    {
        try {
            $discipline->delete();
            return $this->sendSuccessResponse([], 'Discipline was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
