<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class DbSeedModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:db-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan perintah seed pada folder Modules/*/Database/Seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modulePath = base_path('app/Modules');
        $seeded = 0;
        
        if (File::isDirectory($modulePath)) {
            $modules = File::directories($modulePath);

            foreach ($modules as $moduleDir) {
                $seederPath = $moduleDir . '/Database/Seeds';
                if (File::isDirectory($seederPath)) {
                    $seederFiles = File::files($seederPath);
                    foreach ($seederFiles as $seeder) {
                        $class = pathinfo($seeder, PATHINFO_FILENAME);
                        require_once $seeder->getPathname();
                        $this->call('db:seed', ['--class' => $class]);
                        $this->info("Seeded: {$class}");
                        $seeded++;
                    }
                }
            }
        }

        $this->info("Total Seeders Run: {$seeded}");
    }
}
