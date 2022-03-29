<?php

namespace Poojajadav\LivewireCrud\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class MakeLivewireCRUDCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:crud {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Livewire CRUD scaffold for model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = ucfirst($this->argument('model'));
        $pluralModel = str_plural($model);
        $pluralDirectory = strtolower($pluralModel);
        $stubFolder = __DIR__ . '/../../stubs/';

        if (!File::exists($path = base_path('stubs/controller.livewire.stub'))) {
            if (!is_dir($stubsPath = base_path('stubs'))) {
                (new Filesystem)->makeDirectory($stubsPath);
            }

            file_put_contents(
                $path,
                file_get_contents($stubFolder . 'controller.livewire.stub')
            );
        }

        $replace = [
            '{{ variable }}'        => '$' . strtolower($model),
            '{{ model }}'           => $model,
            '{{ pluralModel }}'     => $pluralModel,
            '{{ pluralDirectory }}' => $pluralDirectory,
            'DIRECTORY'             => $pluralDirectory,
        ];

        // model, migration, seeder, factory
        $this->call('make:model', [
            'name'        => $model,
            '--migration' => true,
            '--seed'      => true,
            '--factory'   => true,
        ]);

        // controller
        $this->call('make:controller', [
            'name'    => "{$model}Controller",
            '--model' => $model,
            '--type'  => 'livewire',
        ]);

        $controllerPath = app_path("Http/Controllers/{$model}Controller.php");

        file_put_contents(
            $controllerPath,
            str_replace(array_keys($replace), array_values($replace), file_get_contents($controllerPath)),
        );

        // policy
        $this->call('make:policy', [
            'name'    => "{$model}Policy",
            '--model' => $model,
        ]);

        // creating view files
        File::makeDirectory(resource_path("views/$pluralDirectory"), 0777, true, true);

        $views = [
            'create', 'edit', 'index', 'show', 'filters',
        ];

        foreach ($views as $view) {
            File::put(
                resource_path("views/$pluralDirectory/$view.blade.php"),
                str_replace(array_keys($replace), array_values($replace), file_get_contents($stubFolder . "livewire/views/$view.stub"))
            );
        }
        $this->info('Views created successfully.');

        // livewire components
        $componentPath = app_path("Http/Livewire/$pluralModel");
        $componentViewPath = resource_path("views/livewire/$pluralDirectory");

        File::makeDirectory($componentPath, 0777, true, true);
        File::makeDirectory($componentViewPath, 0777, true, true);

        File::put($componentPath . '/Index.php', str_replace(
            array_keys($replace), array_values($replace), file_get_contents($stubFolder . 'livewire/components/Index.stub')
        ));
        File::put($componentPath . '/Manage.php', str_replace(
            array_keys($replace), array_values($replace), file_get_contents($stubFolder . 'livewire/components/Manage.stub')
        ));

        File::put($componentViewPath . '/index.blade.php', str_replace(
            array_keys($replace), array_values($replace), file_get_contents($stubFolder . 'livewire/component-views/index.stub')
        ));
        File::put($componentViewPath . '/manage.blade.php', str_replace(
            array_keys($replace), array_values($replace), file_get_contents($stubFolder . 'livewire/component-views/manage.stub')
        ));

        if (!File::exists($path = app_path('Http/Livewire/WithSorting.php'))) {
            File::copy($stubFolder . 'livewire/traits/WithSorting.stub', $path);
        }

        if (!File::exists($path = app_path('Http/Livewire/ModelManager.php'))) {
            File::copy($stubFolder . 'livewire/traits/ModelManager.stub', $path);
        }

        $this->info('Livewire components / views created successfully.');

        // register route in routes/api.php
        $route = sprintf("Route::resource('%s', App\Http\Controllers\%sController::class);", $pluralDirectory, $model);

        file_put_contents(
            base_path('routes/web.php'),
            $route,
            FILE_APPEND
        );

        $this->info('Route registered successfully.');
    }
}
