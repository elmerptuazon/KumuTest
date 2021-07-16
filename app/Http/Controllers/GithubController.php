<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Github\ListOfUsersRequest;
use App\Services\Responses\IResponseService;
use App\Enums\SuccessMessages;
use App\Services\ThirdParty\SocialMedia\Github\IGithubService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GithubController extends Controller
{
    private IResponseService $responseService;
    private IGithubService $githubService;

    public function __construct(IResponseService $responseService,
                                IGithubService $githubService)
    {
        $this->responseService = $responseService;
        $this->githubService = $githubService;
    }

    public function getUsernames(ListOfUsersRequest $request): JsonResponse
    {
        $data = $request->validated();
        asort($data['usernames']);
        $response = $this->githubService->process($data);

        return response()->json(
            $this->responseService->resultWithMsg(
                SuccessMessages::success, $response
            ),
            Response::HTTP_OK
        );
    }
}
