<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SecondaryObjectTypeResource;
use App\Models\SecondaryObjectType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecondaryObjectTypesController extends BaseController
{
    public function index(): JsonResponse
    {
        $objectTypes = SecondaryObjectType::all();
        return $this->sendSuccessResponse(SecondaryObjectTypeResource::collection($objectTypes), 'success');
    }

    public function show($id): JsonResponse
    {
        $objectType = SecondaryObjectType::find($id);
        if (is_null($objectType))
            return $this->sendError('Secondary object type does not exist');
        return $this->sendSuccessResponse(new SecondaryObjectTypeResource($objectType), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'object_type_name' => 'required|string',
                'type_path' => 'required|string'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $objectType = SecondaryObjectType::create($input);
            return $this->sendSuccessResponse(new SecondaryObjectTypeResource($objectType), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, SecondaryObjectType $secondaryObjectType): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'object_type_name' => 'required|string',
                'type_path' => 'required|string'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $secondaryObjectType->update($input);
            return $this->sendSuccessResponse(new SecondaryObjectTypeResource($secondaryObjectType), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(SecondaryObjectType $secondaryObjectType): JsonResponse
    {
        try {
            $secondaryObjectType->delete();
            return $this->sendSuccessResponse([], 'Secondary object type was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
