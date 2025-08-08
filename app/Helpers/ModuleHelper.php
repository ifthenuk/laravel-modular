<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class ModuleHelper
{
    public static function getModules()
    {
        $modulesPath = app_path('Modules');
        $modules = [];

        foreach (File::directories($modulesPath) as $modulePath) {
            $moduleName = basename($modulePath);
            $metaFile = $modulePath . '/module.json';

            if (File::exists($metaFile)) {
                $meta = json_decode(File::get($metaFile), true);
                if ($meta && isset($meta['route'], $meta['label'])) {
                    $modules[] = $meta;
                }
            }
        }

        return $modules;
    }
}
