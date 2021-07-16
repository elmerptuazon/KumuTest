<?php


namespace App\Services\Responses;


use App\Enums\SuccessMessages;
use App\Services\Encryption\IEncryptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseService implements IResponseService
{
    private IEncryptionService $encryptionService;

    public function __construct(IEncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function successResponse(array $data = null, string $message = SuccessMessages::success): JsonResponse
    {
        return $this->success($message, Response::HTTP_OK, $data);
    }

    public function createdResponse(array $data = null, string $message = SuccessMessages::success): JsonResponse
    {
        return $this->success($message, Response::HTTP_CREATED, $data);
    }

    public function noContentResponse(string $message = SuccessMessages::recordDeleted): JsonResponse
    {
        return $this->success($message, Response::HTTP_NO_CONTENT);
    }

    public function notFound(string $message): JsonResponse
    {
        $response = [
            'message' => $message
        ];

        return response()->json($response, Response::HTTP_NOT_FOUND);
    }

    public function resultWithMsg(string $msg, array $data): array {
        $response = [
            "message" => $msg,
            "data" => $data
        ];
        
        return $response;
    }

    private function success(string $message, int $statusCode, array $data = null): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if ($data !== null) $response['data'] = $data;

        return response()->json($response, $statusCode);
    }

}
