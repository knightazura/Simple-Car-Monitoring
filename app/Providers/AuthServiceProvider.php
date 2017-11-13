<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\CarUsage;
use App\Policies\CarUsagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        CarUsage::class => CarUsagePolicy::class,
        Car::class => CarPolicy::class,
        Employee::class => EmployeePolicy::class,
        Driver::class => DriverPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('car-usage', 'CarUsagePolicy');
    }
}
