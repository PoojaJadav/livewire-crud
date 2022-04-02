<?php

namespace Poojajadav\LivewireCrud;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Poojajadav\LivewireCrud\Commands\MakeLivewireCRUDCommand;
use Poojajadav\LivewireCrud\Commands\StubsCommand;

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
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'livewire-crud');
        $this->configureComponents();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Registering package commands.
        $this->commands([
            MakeLivewireCRUDCommand::class,
            StubsCommand::class
        ]);
    }

    protected function configureComponents()
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            $this->registerComponent('icons.search');
            $this->registerComponent('icons.sort');
        });
    }

    protected function registerComponent(string $component)
    {
        Blade::component('livewire-crud::components.' . $component, 'wire-'.$component);
    }
}
