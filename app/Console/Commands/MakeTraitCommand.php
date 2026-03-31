<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

#[Signature("make:trait {name}")]
#[Description('Create new Trait files')]

class MakeTraitCommand extends Command
{
    public function __construct(private Filesystem $files) 
    {
        return parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle() 
    {
        $name = $this->argument('name');
        $path = app_path("Traits/{$name}.php");
        $directory = dirname("$path");

        if (!$this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        if ($this->files->exists($path)) {
            $this->error("Trait {$name} already exists");
            return;
        }

        $this->files->put($path, $this->buildClass($name));

        $this->info("Trait {$name} created successfully.");
        $this->line("-> app/Traits/{$name}.php");
    }

    private function buildClass(string $name): string
    {
        $className = basename(str_replace('/', DIRECTORY_SEPARATOR, $name));
        $namespace = 'App\\Traits' . (str_contains($name, '/') 
            ? '\\' . str_replace('/', '\\', dirname($name))
            : '');

        return <<<PHP
        <?php

        namespace {$namespace};

        trait {$className}
        {
            public function __construct()
            {
                //
            }
        }
        PHP;
    }
}
