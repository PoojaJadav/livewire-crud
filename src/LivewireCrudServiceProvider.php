<?php

namespace Poojajadav\LivewireCrud;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
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
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'livewire-crud');

//        $this->registerBladeComponents();

//        $this->configureComponents();

        // Registering package components
        $this->loadViewComponentsAs('wire', [
            Search::class,
            Sort::class
        ]);

        // Registering package commands.
        $this->commands([
            MakeLivewireCRUDCommand::class,
            StubsCommand::class
        ]);
    }

    protected function registerBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $components = [
                'input'    => [
                    'class' => Search::class,
                    'alias' => 'search',
                ],
                'textarea' => [
                    'class' => Sort::class,
                    'alias' => 'sort',
                ]
            ];
            foreach ($components as $component) {
                $blade->component($component['class'], $component['alias']);
            }
        });
    }

    protected function configureComponents()
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            $this->registerComponent('search');
            $this->registerComponent('sort');
        });
    }

    protected function registerComponent(string $component)
    {
        Blade::component('livewire-crud::components.' . $component, 'wire-' . $component);
    }
}
