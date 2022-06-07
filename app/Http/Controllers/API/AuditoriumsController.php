<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AuditoriumResource;
use App\Models\Auditorium;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuditoriumsController extends BaseController
{
    public function index(): JsonResponse
    {
        $auditoriums = Auditorium::all();
        return $this->sendSuccessResponse(AuditoriumResource::collection($auditoriums), 'success');
    }

    public function show($id): JsonResponse
    {
        $auditorium = Auditorium::find($id);
        if (is_null($auditorium))
            return $this->sendError('Auditorium does not exist');
        return $this->sendSuccessResponse(new AuditoriumResource($auditorium), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'auditorium_name' => 'required|string',
                'position_info' => 'required|string',
                'floor_id' => 'required|integer',
                'holder_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $auditorium = Auditorium::create($input);
            return $this->sendSuccessResponse(new Auditorium($auditorium), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, Auditorium $auditorium): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'auditorium_name' => 'required|string',
                'position_info' => 'required|string',
                'floor_id' => 'required|integer',
                'holder_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $auditorium->update($input);
            return $this->sendSuccessResponse(new AuditoriumResource($auditorium), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(Auditorium $auditorium): JsonResponse
    {
        try {
            $auditorium->delete();
            return $this->sendSuccessResponse([], 'Auditorium was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
