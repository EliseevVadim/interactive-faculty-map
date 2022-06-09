<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeachersController extends BaseController
{
    public function index(): JsonResponse
    {
        $teachers = Teacher::all();
        return $this->sendSuccessResponse(TeacherResource::collection($teachers), 'success');
    }

    public function show($id): JsonResponse
    {
        $teacher = Teacher::find($id);
        if (is_null($teacher))
            return $this->sendError('Teacher does not exist');
        return $this->sendSuccessResponse(new TeacherResource($teacher), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $file = $request->file('photo');
            if (is_null($file))
                $path = null;
            else {
                $filename = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $path = Storage::disk('public')->putFileAs('uploads', $file, $filename);
            }
            $input = $request->all();
            $input['photo_path'] = $path;
            $validator = Validator::make($input, [
                'fio' => 'required|string',
                'photo_path' => 'nullable|string',
                'science_rank_id' => 'required|integer',
                'email' => 'required|email',
                'birth_date' => 'required'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $teacher = Teacher::create($input);
            return $this->sendSuccessResponse(new TeacherResource($teacher), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, Teacher $teacher): JsonResponse
    {
        try {
            $file = $request->file('photo');
            if (is_null($file))
                $path = null;
            else {
                $filename = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $path = Storage::disk('public')->putFileAs('uploads', $file, $filename);
            }
            $input = $request->all();
            $input['photo_path'] = is_null($path) ? $teacher->photo_path : $path;
            $validator = Validator::make($input, [
                'fio' => 'required|string',
                'photo_path' => 'nullable|string',
                'science_rank_id' => 'required|integer',
                'email' => 'required|email',
                'birth_date' => 'required'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $teacher->update($input);
            return $this->sendSuccessResponse(new TeacherResource($teacher), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        try {
            $teacher->delete();
            return $this->sendSuccessResponse([], 'Teacher was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
