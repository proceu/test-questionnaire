<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Answer\SearchAnswerRequest;
use App\Http\Requests\Answer\StoreAnswerRequest;
use App\Http\Requests\Answer\UpdateAnswerRequest;
use App\Models\Answer;
use App\Service\AnswerService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class AnswerController extends Controller
{
    private AnswerService $service;

    public function __construct(AnswerService $service)
    {
        $this->service = $service;
    }

    /**
     * @param SearchAnswerRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(SearchAnswerRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Answer::class);

        try {
            $answers = $this->service->search($request->validated());
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'answers'  =>  $answers,
        ],200);
    }

    /**
     * @param StoreAnswerRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreAnswerRequest $request): JsonResponse
    {
        $this->authorize('create',Answer::class);

        $data = $request->validated();

        try {
            $answer = $this->service->store($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'answer'  =>  $answer,
        ],200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $answer = $this->service->find($id);

            $this->authorize('view',$answer);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'answer'  =>  $answer,
        ],200);
    }

    /**
     * @param int $id
     * @param UpdateAnswerRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateAnswerRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->authorize('update',$this->service->find($id));

            $answer = $this->service->update($id,$data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'answer'  =>  $answer,
        ],200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->authorize('delete',$this->service->find($id));

            $this->service->destroy($id);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'message'  =>  'Deleted!',
        ],200);
    }
}
