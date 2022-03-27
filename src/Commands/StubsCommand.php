<?php

namespace Poojajadav\LivewireCrud\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class StubsCommand extends Command
{
    protected $signature = 'livewire-crud:stubs';

    protected $description = 'Publish Livewire stubs';

    protected $parser;

    public function handle()
    {
        if (!is_dir($stubsPath = base_path('stubs'))) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        File::copyDirectory(__DIR__.'/../../stubs', $stubsPath);

        $this->info('Stubs published successfully.');
    }
}
