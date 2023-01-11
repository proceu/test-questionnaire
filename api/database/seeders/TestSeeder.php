<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tests = Test::factory()
            ->count(1)
            ->has(
                Question::factory()
                    ->count(10)
                    ->has(
                        Answer::factory()
                            ->count(3)

                    )->has(
                        Answer::factory()
                            ->count(1)
                            ->set('aright',true)
                    )
            )
            ->create();
    }
}
