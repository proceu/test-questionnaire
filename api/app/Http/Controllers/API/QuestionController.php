<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\SearchQuestionRequest;
use App\Http\Requests\Question\StoreQuestionRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;
use App\Models\Question;
use App\Service\QuestionService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    private QuestionService $service;

    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    /**
     * @param SearchQuestionRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(SearchQuestionRequest $request): JsonResponse
    {
        $this->authorize('viewAny',Question::class);

        try {
            $questions = $this->service->search($request->validated());
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'questions'  =>  $questions,
        ],200);
    }

    /**
     * @param StoreQuestionRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreQuestionRequest $request): JsonResponse
    {
        $this->authorize('create',Question::class);

        $data = $request->validated();

        try {
            $question = $this->service->store($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'question'  =>  $question,
        ],200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $question = $this->service->find($id);

            $this->authorize('view',$question);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'question'  =>  $question,
        ],200);
    }

    /**
     * @param int $id
     * @param UpdateQuestionRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateQuestionRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->authorize('update',$this->service->find($id));
            $question = $this->service->update($id,$data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'question'  =>  $question,
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
