<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make {name} {--crud} {--livewire}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module in the app/Modules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $basePath = app_path("Modules/{$name}");

        if (File::exists($basePath)) {
            $this->error("Module {$name} sudah ada.");
            return;
        }

        // Struktur folder
        $folders = ['Controllers', 'Models', 'Requests', 'Database', 'Views', 'Routes'];
        if ($this->option('livewire')) {
            $folders[] = 'Livewire';
            File::makeDirectory("{$basePath}/Views/livewire", 0755, true);
        }
        foreach ($folders as $folder) {
            if($folder == 'Database') {
                File::makeDirectory("{$basePath}/{$folder}/Migrations", 0755, true);
                File::makeDirectory("{$basePath}/{$folder}/Seeds", 0755, true);
                continue;
            }
            File::makeDirectory("{$basePath}/{$folder}", 0755, true);
        }

        $replacements = [
            '{{ moduleName }}' => $name,
            '{{ moduleLower }}' => strtolower($name),
            '{{ moduleLowerPlural' => strtolower($name) . 's',
        ];

        // File dasar
        //Generate controller
        if($this->option('crud')) {
            $this->generateFileFromStub(
                'app/Console/Commands/stubs/module/controller.crud.stub',
                "{$basePath}/Controllers/{$name}Controller.php",
                $replacements
            );
        } else {
            $this->generateFileFromStub(
                'app/Console/Commands/stubs/module/controller.stub',
                "{$basePath}/Controllers/{$name}Controller.php",
                $replacements
            );
        }
        //Generate Routes
        $this->generateFileFromStub(
            'app/Console/Commands/stubs/module/route.stub',
            "{$basePath}/Routes/web.php",
            $replacements
        );
        //Generate Models
        $this->generateFileFromStub(
            'app/Console/Commands/stubs/module/model.stub',
            "{$basePath}/Models/{$name}.php",
            $replacements
        );
        //Generate View files
        $this->generateFileFromStub(
            'app/Console/Commands/stubs/module/view.stub',
            "{$basePath}/Views/index.blade.php",
            $replacements
        );
        //Generate Menu
        $this->generateJsonMenu($name, $replacements);
    
        // CRUD
        if ($this->option('crud')) {
            //Generate Store Request
            $this->generateFileFromStub(
                'app/Console/Commands/stubs/module/store-request.stub',
                "{$basePath}/Requests/Store{$name}Request.php",
                $replacements
            );
            //Generate Update Request
            $this->generateFileFromStub(
                'app/Console/Commands/stubs/module/update-request.stub',
                "{$basePath}/Requests/Update{$name}Request.php",
                $replacements
            );
        }

        // Livewire
        if ($this->option('livewire')) {
            File::put("{$basePath}/Livewire/{$name}Table.php", $this->getLivewireClass($name));
            File::put("{$basePath}/Views/livewire/" . Str::kebab($name) . "-table.blade.php", $this->getLivewireView($name));
        }

        $this->info("Modul {$name} berhasil dibuat!");
    }

    protected function generateFileFromStub($stubPath, $destinationPath, array $replacements)
    {
        $stub = file_get_contents(base_path($stubPath));

        $content = str_replace(array_keys($replacements), array_values($replacements), $stub);

        file_put_contents($destinationPath, $content);
    }

    protected function generateJsonMenu(string $name, array $replaced)
    {
        $stub = file_get_contents(base_path('app/Console/Commands/stubs/module/module.json.stub'));
        $replaced = array_merge($replaced, [
            '{{ icon }}' => strtolower($name),
            '{{ label }}' => $name,
        ]);

        $content = str_replace(array_keys($replaced), array_values($replaced), $stub);

        file_put_contents(app_path("Modules/{$name}/module.json"), $content);

        $this->info("✅ Menu Generated in module.json");
    }

    protected function getLivewireClass(string $name): string
    {
        return <<<PHP
            <?php

            namespace App\Modules\\$name\Livewire;

            use Livewire\Component;

            class {$name}Table extends Component
            {
                public function render()
                {
                    return view(strtolower('$name') . '::livewire.' . strtolower('$name') . '-table');
                }
            }
            PHP;
    }

    protected function getLivewireView(string $name): string
    {
        return <<<BLADE
            <div>
                <h3>Livewire Komponen untuk Modul $name</h3>
            </div>
            BLADE;
    }

}
