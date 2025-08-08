<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MakeModulSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-seeder {module} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make seeder file for a specific module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $modulePath = base_path("app/Modules/{$module}/Database/Seeds");
        $filePath = $modulePath . '/'.Str::studly($name) . '.php';

        if (file_exists($filePath)) {
            $this->error("The seed file already exists: {$filePath}");
            return;
        }

        $stub = file_get_contents(base_path('app/Console/Commands/stubs/module/seeder.stub'));
        $content = str_replace('{{ class }}', Str::studly($name), $stub);
        file_put_contents($filePath, $content);

        $this->info("Creating seeder file: {$filePath}");
    }
}
