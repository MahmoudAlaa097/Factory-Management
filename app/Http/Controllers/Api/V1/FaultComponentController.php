<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Fault\AttachFaultComponentAction;
use App\Actions\V1\Fault\DetachFaultComponentAction;
use App\Http\Requests\Api\V1\StoreFaultComponentRequest;
use App\Http\Resources\V1\FaultResource;
use App\Http\Responses\ApiResponse;
use App\Models\Fault;
use App\Models\FaultComponent;
use Illuminate\Http\JsonResponse;

class FaultComponentController extends BaseController
{
    public function __construct(
        private AttachFaultComponentAction $attachAction,
        private DetachFaultComponentAction $detachAction,
    ) {}

    public function store(StoreFaultComponentRequest $request, Fault $fault): JsonResponse
    {
        $fault = $this->attachAction->execute($request, $fault);
        $fault->load('components');

        return ApiResponse::success(
            'Component attached successfully',
            new FaultResource($fault),
            null,
            201
        );
    }

    public function destroy(Fault $fault, FaultComponent $faultComponent): JsonResponse
    {
        $this->authorize('manageComponents', $fault);

        $fault = $this->detachAction->execute($fault, $faultComponent);

        return ApiResponse::success(
            'Component detached successfully',
            new FaultResource($fault)
        );
    }
}
