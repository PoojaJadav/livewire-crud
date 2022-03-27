<?php

namespace Poojajadav\LivewireCrud;

use Illuminate\Support\ServiceProvider;

class LivewireCrudServiceProvider extends ServiceProvider
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
        //
    }

    public function provides()
    {
        return ['livewire-crud'];
    }
}
