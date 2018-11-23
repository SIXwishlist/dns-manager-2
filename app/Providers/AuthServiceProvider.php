<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->is_admin) {
                return true;
            }

            return null;
        });

        Gate::define('update-domain', function ($user, $domain) {
            if ($user instanceof \App\Model\Domain) {
                return $user->id == $domain->id;
            }

            return $user->id == $domain->owner_id;
        });

        Gate::define('delete-domain', function ($user, $domain) {
            return $user->id == $domain->owner_id;
        });
    }
}
