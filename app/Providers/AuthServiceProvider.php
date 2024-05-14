<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Location;
use App\Models\Status;
use App\Models\User;
use App\Policies\LocationPolicy;
use App\Policies\StatusPolicy;
use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Location::class => LocationPolicy::class,
        Status::class => StatusPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

    }
}
