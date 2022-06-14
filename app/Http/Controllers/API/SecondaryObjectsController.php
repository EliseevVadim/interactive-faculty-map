<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SecondaryObjectResource;
use App\Models\SecondaryObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecondaryObjectsController extends BaseController
{
    public function index(): JsonResponse
    {
        $secondaryObjects = SecondaryObject::all();
        return $this->sendSuccessResponse(SecondaryObjectResource::collection($secondaryObjects), 'success');
    }

    public function show($id): JsonResponse
    {
        $secondaryObject = SecondaryObject::find($id);
        if (is_null($secondaryObject))
            return $this->sendError('Secondary object does not exist');
        return $this->sendSuccessResponse(new SecondaryObjectResource($secondaryObject), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'object_name' => 'required|string',
                'position_info' => 'required|string',
                'object_type_id' => 'required|integer',
                'floor_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $secondaryObject = SecondaryObject::create($input);
            return $this->sendSuccessResponse(new SecondaryObjectResource($secondaryObject), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, SecondaryObject $secondaryObject): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'object_name' => 'required|string',
                'position_info' => 'required|string',
                'object_type_id' => 'required|integer',
                'floor_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $secondaryObject->update($input);
            return $this->sendSuccessResponse(new SecondaryObjectResource($secondaryObject), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(SecondaryObject $secondaryObject): JsonResponse
    {
        try {
            $secondaryObject->delete();
            return $this->sendSuccessResponse([], 'Secondary object was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
