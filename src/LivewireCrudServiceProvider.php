<?php

namespace Poojajadav\LivewireCrud;

use Illuminate\Support\ServiceProvider;
use Poojajadav\LivewireCrud\Commands\MakeLivewireCRUDCommand;
use Poojajadav\LivewireCrud\Commands\StubsCommand;
use Poojajadav\LivewireCrud\View\Components\Search;
use Poojajadav\LivewireCrud\View\Components\Sort;

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
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public function provides()
    {
        return ['livewire-crud'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Registering package components
        $this->loadViewComponentsAs('livewirecrud', [
            Search::class,
            Sort::class
        ]);

        // Registering package commands.
        $this->commands([
            MakeLivewireCRUDCommand::class,
            StubsCommand::class
        ]);
    }
}
