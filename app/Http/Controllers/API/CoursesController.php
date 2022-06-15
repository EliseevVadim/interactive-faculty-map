<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoursesController extends BaseController
{
    public function index(): JsonResponse
    {
        $courses = Course::all();
        return $this->sendSuccessResponse(CourseResource::collection($courses), 'success');
    }

    public function show($id): JsonResponse
    {
        $course = Course::find($id);
        if (is_null($course))
            return $this->sendError('Course does not exist');
        return $this->sendSuccessResponse(new CourseResource($course), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'course_name' => 'required|string',
                'course_number' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $course = Course::create($input);
            return $this->sendSuccessResponse(new CourseResource($course), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, Course $course): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'course_name' => 'required|string',
                'course_number' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $course->update($input);
            return $this->sendSuccessResponse(new CourseResource($course), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(Course $course): JsonResponse
    {
        try {
            $course->delete();
            return $this->sendSuccessResponse([], 'Course was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
