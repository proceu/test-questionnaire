<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\SaveAnswersRequest;
use App\Http\Requests\Test\SearchTestRequest;
use App\Http\Requests\Test\StoreTestRequest;
use App\Http\Requests\Test\UpdateTestRequest;
use App\Models\Test;
use App\Service\TestService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    private TestService $service;

    public function __construct(TestService $service)
    {
        $this->service = $service;
    }

    /**
     * @param SearchTestRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(SearchTestRequest $request): JsonResponse
    {
        $this->authorize('viewAny',Test::class);
        $data = $request->validated();
        $data['user_id'] = $request->user()->getKey();
        try {
            $tests = $this->service->search($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse($tests,200);
    }

    /**
     * @param StoreTestRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreTestRequest $request): JsonResponse
    {
        $this->authorize('create',Test::class);

        $data = $request->validated();

        try {
            $test = $this->service->store($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'test'  =>  $test,
        ],200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $test = $this->service->findWith($id);

            $this->authorize('view',$test);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'test'  =>  $test,
        ],200);
    }

    /**
     * @param int $id
     * @param UpdateTestRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateTestRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->authorize('update',$this->service->find($id));

            $test = $this->service->update($id,$data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],is_int($exception->getCode())?$exception->getCode():500);
        }

        return new JsonResponse([
            'test'  =>  $test,
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

    /**
     * @param SaveAnswersRequest $request
     * @return JsonResponse
     */
    public function saveAnswers(SaveAnswersRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $request->user();

        $user->answers()->attach($data['answers']);

        return new JsonResponse([
            'message'   =>  'Success',
        ],200);
    }

    public function testStatistics(int $id)
    {
        try {
            $test = $this->service->findWith($id,true);

            $this->authorize('view',$test);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],500);
        }

        return new JsonResponse([
            'test'  =>  $test,
        ],200);
    }
}
