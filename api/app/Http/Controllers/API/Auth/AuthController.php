<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Service\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->service->register($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'message' =>  'Success'
        ],200);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $token = $this->service->login($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'token' =>  $token,
        ],200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return new JsonResponse([
            'user'  =>  $request->user()
        ],200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return new JsonResponse([
            'message'   =>  'Success!'
        ],200);
    }
}
