<?php

namespace App\Service;

use App\Models\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TestService extends CoreService
{
    protected function getModelClass(): string
    {
        return Test::class;
    }

    /**
     * @param array $data
     * @return array|Collection
     */
    public function search(array $data): array|Collection
    {
        $query = $this->query();
        if (!array_key_exists('all', $data) || (array_key_exists('all',$data) && !$data['all'])) {
            $query->whereDoesntHave('questions.answers.users', function ($sub) use ($data) {
                $sub->where('user_id', $data['user_id']);
            });
        }
        return $query->get();
    }

    /**
     * @param int $id
     * @param bool $stat
     * @return Model|array|Collection|Builder|null
     */
    public function findWith(int $id, bool $stat = false): Model|array|Collection|Builder|null
    {
        $with = $stat?['questions','questions.answers']:['questions','questions.answers'];
        $test = $this->query()->with($with)->find($id);
        if ($stat) {
            $test->questions->map(function ($item) {
                $item->titles = $item->answers->map( function ($subItem) {
                    return $subItem->title;
                });
                $item->statistics_data = $item->answers->map( function ($sub) {
                    return $sub->users()->count();
                });
                $item->user_answers = $item->answers->map( function ($sub) {
                    return $sub->users()->where('user_id', request()->user()->getKey())->exists();
                });
                return $item;
            });
        }
        return $test;
    }
}
