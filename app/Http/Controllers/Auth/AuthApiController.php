<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthApiRequest;
use App\Interfaces\UserRepositoryInterface;

class AuthApiController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function auth(AuthApiRequest $request)
    {
        $user = $this->userRepositoryInterface->getByEmail($request->email);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponseClass::sendResponse('The provided credentials are incorrect', '', 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('myToken')->plainTextToken;
        return ApiResponseClass::sendResponse(['token' => $token], '', 200);
    }
}
