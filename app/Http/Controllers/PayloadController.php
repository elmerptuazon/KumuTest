<?php

namespace App\Http\Controllers;

use App\Enums\PayloadTypes;
use App\Http\Requests\Payload\DecryptRequest;
use App\Http\Requests\Payload\EncryptRequest;
use App\Models\Payload;
use App\Services\Encryption\IEncryptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Services\Responses\IResponseService;
use App\Enums\SuccessMessages;

class PayloadController extends Controller
{
    public IEncryptionService $encryptionService;
    public IResponseService $reponseService;

    public function __construct(IEncryptionService $encryptionService,
                                IResponseService $reponseService)
    {
        $this->encryptionService = $encryptionService;
        $this->reponseService = $reponseService;
    }

    /**
     * Generates a key to encrypt requests on front-end
     * application.
     *
     * @return JsonResponse
     */
    public function generate(): JsonResponse
    {
        $passPhrase = Str::random(16);

        $newPayload = $this->encryptionService->payloads->create([
            'payloadType' => PayloadTypes::Request,
            'passPhrase' => $passPhrase
        ]);

        $response = ['id' => $newPayload->id, 'passPhrase' => $newPayload->passPhrase];
        
        return response()->json(
            $this->reponseService->resultWithMsg(
                SuccessMessages::success, $response
            ), 
            Response::HTTP_OK
        );

    }

    /**
     * Gets the corresponding key to decrypt responses
     * on front-end applications
     *
     * @param Payload $payload
     * @return JsonResponse
     */
    public function getResponseKey(Payload $payload): JsonResponse
    {
        $this->encryptionService->payloads->delete($payload);

        $response = ['id' => $payload->id, 'passPhrase' => $payload->passPhrase];

        return response()->json(
            $this->reponseService->resultWithMsg(
                SuccessMessages::success, $response
            ), 
            Response::HTTP_OK
        );
    }

    /**
     * Utility to encrypt json. Only available for local
     * environment.
     *
     * @param EncryptRequest $request
     * @return JsonResponse
     */
    public function encrypt(EncryptRequest $request): JsonResponse
    {
        $data = $request->validated();
        $responseData = $this->encryptionService->encrypt($data['payload'], $data['passPhrase']);

        return response()->json(
            $this->reponseService->resultWithMsg(
                SuccessMessages::success, $responseData
            ), 
            Response::HTTP_OK
        );

    }

    /**
     * Utility to decrypt json. Only available for local
     * environment.
     *
     * @param DecryptRequest $request
     * @return JsonResponse
     */
    public function decrypt(DecryptRequest $request): JsonResponse
    {
        $data = $request->validated();
        $responseData = $this->encryptionService->decrypt($data['payload'], $data['id']);

        return response()->json(
            $this->reponseService->resultWithMsg(
                SuccessMessages::success, $responseData
            ), 
            Response::HTTP_OK
        );
    }
}
