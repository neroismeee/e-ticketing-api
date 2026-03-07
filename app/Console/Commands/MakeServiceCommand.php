<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Service files';

    public function __construct(private Filesystem $files)
    {
        return parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $path = app_path("Services\`$name`.php");
        $directory = app_path('Services');

        if (!$this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        if ($this->files->exists($path)) {
            $this->error("Service {$name} already exist");
            return;
        }

        $this->files->put($path, $this->buildClass($name));

        $this->info("Service {$name} created successfully");
        $this->line("-> app\Services\{$name}.php");
    }

    private function buildClass(string $name) : string 
    {
        return <<<PHP
        <?php
        
        namespace App\Services;

        class {$name}
        {
            public function __construct()
            {
                //
            }
        }
        PHP;
    }
}
