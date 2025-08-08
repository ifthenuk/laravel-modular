<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MakeModulMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-migration {module : The name of the module} {name : The name of the migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat file migrasi pada spesifik module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $modulePath = base_path("app/Modules/{$module}/Database/Migrations");
        $filePath = $modulePath . '/' . date('Y_m_d_His') . '_' . Str::snake($name) . '.php';

        if (file_exists($filePath)) {
            $this->error("The migration file already exists: {$filePath}");
            return;
        }

        $this->call("make:migration", [
            'name' => $name,
            '--path' => "app/Modules/{$module}/Database/Migrations",
        ]);

        $this->info("Creating migration file: {$filePath}");
    }
}
