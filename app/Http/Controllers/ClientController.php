<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ClientLoginRequest;
use App\Services\Auth\IAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Services\Responses\IResponseService;
use App\Enums\SuccessMessages;

class ClientController extends Controller
{
    private IAuthService $authService;
    private IResponseService $responseService;

    public function __construct(IAuthService $authService,
                                IResponseService $responseService)
    {
        $this->authService = $authService;
        $this->responseService = $responseService;
    }

    /**
     * Client Apps Authentication Endpoint
     *
     *
     * @param ClientLoginRequest $request
     * @return JsonResponse
     */
    public function getToken(ClientLoginRequest $request): JsonResponse
    {
        $clientLogin = $request->validated();
        $clientToken = $this->authService->clientLogin($clientLogin['client_id'], $clientLogin['client_secret']);

        $tokenResponse = [
            'access_token' => $clientToken->plainTextToken,
            'created_at' => $clientToken->accessToken->created_at,
            'expires_in' => config('sanctum.expiration')
        ];

        return response()->json(
            $this->responseService->resultWithMsg(
                SuccessMessages::success, $tokenResponse
            ),
            Response::HTTP_OK
        );
    }
}
