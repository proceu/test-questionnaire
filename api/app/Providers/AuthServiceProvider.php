<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\TestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Answer::class =>  AnswerPolicy::class,
        Question::class => QuestionPolicy::class,
        Test::class     => TestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
