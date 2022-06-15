<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupsController extends BaseController
{
    public function index(): JsonResponse
    {
        $groups = Group::all();
        return $this->sendSuccessResponse(GroupResource::collection($groups), 'success');
    }

    public function show($id): JsonResponse
    {
        $group = Group::find($id);
        if (is_null($group))
            return $this->sendError('Group does not exist');
        return $this->sendSuccessResponse(new GroupResource($group), 'success');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'group_name' => 'required|string',
                'course_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $group = Group::create($input);
            return $this->sendSuccessResponse(new GroupResource($group), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function update(Request $request, Group $group): JsonResponse
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'group_name' => 'required|string',
                'course_id' => 'required|integer'
            ]);
            if ($validator->fails())
                return $this->sendError('Validation fails', $validator->errors(), 422);
            $group->update($input);
            return $this->sendSuccessResponse(new GroupResource($group), 'success');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy(Group $group): JsonResponse
    {
        try {
            $group->delete();
            return $this->sendSuccessResponse([], 'Group was deleted');
        }
        catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), ['error' => $exception->getMessage()], 400);
        }
    }
}
