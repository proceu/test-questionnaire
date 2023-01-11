<?php

namespace App\Service;

use App\Models\User;

class StatisticService
{
    public function search(array $data)
    {
        $passed = User::whereHas('answers');
        $notPassed = User::whereDoesntHave('answers');
        return [
            'passed' => $passed->count(),
            'not_passed' => $notPassed->count(),
        ];
    }
}
