<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\GetStatisticRequest;
use App\Service\StatisticService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{

    private StatisticService $service;

    /**
     * @param StatisticService $service
     */
    public function __construct(StatisticService $service)
    {
        $this->service = $service;
    }

    /**
     * @param GetStatisticRequest $request
     * @return JsonResponse
     */
    public function index(GetStatisticRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $statistics = $this->service->search($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse($statistics,200);
    }
}
