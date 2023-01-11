<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

abstract class CoreService
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;


    /**
     * @return Builder|Model
     */
    protected function query(): Model|Builder
    {
        return $this->model->newModelQuery();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->query()->find($id);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->query()->get();
    }

    /**
     * @param array $data
     * @return Model|Builder
     */
    public function store(array $data): Model|Builder
    {
        return $this->query()->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Builder|Collection|Model
     */
    public function update(int $id, array $data): Model|Collection|Builder
    {
        $query = $this->query();

        if (!$item = $query->find($id)) {
            throw new RuntimeException('Item not found!',404);
        }
        $item->update($data);

        return $item;
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $query = $this->query();

        if (!$item = $query->find($id)) {
            throw new RuntimeException('Item not found!',404);
        }
        $item->delete();
    }
}
