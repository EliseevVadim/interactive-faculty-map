<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TeacherDicsiplineResource;
use App\Models\TeacherDiscipline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeachersDisciplinesController extends BaseController
{
    public function index(): JsonResponse
    {
        $teachersDisciplines = TeacherDiscipline::all();
        return $this->sendSuccessResponse(TeacherDicsiplineResource::collection($teachersDisciplines), 'success');
    }

    public function show($id): JsonResponse
    {
        $teacherDiscipline = TeacherDiscipline::find($id);
        if (is_null($teacherDiscipline))
            return $this->sendError('Teacher discipline pair does not exist');
        return $this->sendSuccessResponse(new TeacherDicsiplineResource($teacherDiscipline), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'discipline_id' => 'required|integer',
                'teacher_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $teacherDiscipline = TeacherDiscipline::create($input);
            return $this->sendSuccessResponse(new TeacherDicsiplineResource($teacherDiscipline), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, TeacherDiscipline $teachersDiscipline): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'discipline_id' => 'required|integer',
                'teacher_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $teachersDiscipline->update($input);
            return $this->sendSuccessResponse(new TeacherDicsiplineResource($teachersDiscipline), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(TeacherDiscipline $teachersDiscipline): JsonResponse
    {
        try {
            $teachersDiscipline->delete();
            return $this->sendSuccessResponse([], 'Teacher discipline was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
