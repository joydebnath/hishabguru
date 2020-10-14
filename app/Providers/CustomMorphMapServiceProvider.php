<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class CustomMorphMapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'bills' => 'App\Models\Bill',
            'other-expenses' => 'App\Models\OtherExpense',
            'invoices' => 'App\Models\Invoice',
            'tenants' => 'App\Models\Tenant',
            'images' => 'App\Models\Image',
            'users' => 'App\Models\User',
        ]);
    }
}
