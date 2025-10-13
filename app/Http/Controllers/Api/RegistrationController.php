<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateRegistrationAction;
use App\DTOs\CreateRegistrationDTO;
use App\DTOs\UpdateRegistrationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request): JsonResponse
    {

        try {
            $dto = CreateRegistrationDTO::fromArray($request->validated());

            $action = new CreateRegistrationAction();
            $registration = $action->execute($dto);

            return response()->json([
                'success' => true,
                'data' => RegistrationResource::make($registration)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível concluir a inscrição. Tente novamente mais tarde.',
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Registration $registration): JsonResponse
{
    try {
        $dto = UpdateRegistrationDTO::fromArray($request->request->all());

        $registration->update($dto->toArray());

        return response()->json([
            'success' => true,
            'data' => RegistrationResource::make($registration)
        ], 200); // 200 = OK (melhor do que 201 que é Created)
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred',
            'exception' => $e->getMessage()
        ], 500);
    }
}

    public function show(Registration $registration): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => RegistrationResource::make($registration)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'exception' => $e->getMessage()
            ], 500);
        }
    }
}
