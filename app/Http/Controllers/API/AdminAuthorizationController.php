<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminAuthorizationController extends BaseController
{
    public function createAdmin(Request $request): JsonResponse
    {
        if ($request->securityKey !== env('APP_SECRET'))
            return $this->sendError('You don\'t have permissions to do that', ['error' => 'Forbidden'], 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password'
        ]);
        if ($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 422);
        }
        $input = $request->all();
        $input['password'] = sha1($input['password']);
        $user = User::create($input);
        $success['id'] = $user->id;
        $success['name'] =  $user->name;
        Auth::login($user);
        return $this->sendSuccessResponse($success, 'User created successfully');
    }

    public function loginAsAdministrator(Request $request) : JsonResponse
    {
        if ($request->securityKey !== env('APP_SECRET'))
            return $this->sendError('You don\'t have permissions to do that', ['error' => 'Forbidden'], 403);
        $user = User::where([
            'email' => $request->email,
            'password' => sha1($request->password)
        ])->first();
        if (!is_null($user)) {
            Auth::login($user);
            $success['name'] = $user->name;
            $success['id'] = $user->id;
            return $this->sendSuccessResponse($success, 'User signed in');
        }
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();
        return $this->sendSuccessResponse([], 'User successfully logged out');
    }
}
