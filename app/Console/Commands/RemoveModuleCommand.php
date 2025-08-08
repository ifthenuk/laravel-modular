<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:delete {name : The name of the module to delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus folder module dan subfoldernya';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $modulePath = base_path('app/Modules/' . $name);

        if (!File::exists($modulePath)) {
            $this->error("Module '{$name}' does not exist.");
            return Command::FAILURE;
        }

        if ($this->confirm("Are you sure you want to delete the module '{$name}'? This action cannot be undone.")) {
            File::deleteDirectory($modulePath);
            $this->info("Module '{$name}' has been deleted successfully.");
            return Command::SUCCESS;
        }

        $this->warn("Action cancelled.");
        return Command::SUCCESS;
    }
}
