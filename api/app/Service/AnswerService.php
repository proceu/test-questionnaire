<?php

namespace App\Service;

use App\Models\Answer;

class AnswerService extends CoreService
{
    protected function getModelClass(): string
    {
        return Answer::class;
    }

    public function search(array $data)
    {
        $query = $this->query();
        return $query->get();
    }
}
