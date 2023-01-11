<?php

namespace App\Service;

use App\Models\Question;

class QuestionService extends CoreService
{
    protected function getModelClass(): string
    {
        return Question::class;
    }

    public function search(array $data)
    {
        $query = $this->query();
        return $query->get();
    }
}
