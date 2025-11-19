<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeHelperCommand extends Command
{
    protected $signature = 'make:helper {name}';
    protected $description = 'Create a new helper file and register it';

    public function handle()
    {
        $name = $this->argument('name');
        $directory = app_path('Helpers');
        $filePath = "{$directory}/{$name}.php";

        // Ensure Helpers folder exists
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Helper template
        $content = <<<PHP
<?php

if (!function_exists('{$name}')) {
    function {$name}() {
        // TODO: Add your logic
    }
}

PHP;

        // Create file
        file_put_contents($filePath, $content);

        // Add helper to composer.json if not already added
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $fileEntry = "app/Helpers/{$name}.php";

        if (!isset($composer['autoload']['files']) || !in_array($fileEntry, $composer['autoload']['files'])) {
            $composer['autoload']['files'][] = $fileEntry;
            file_put_contents(base_path('composer.json'), json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        $this->info("Helper created: {$filePath}");
        $this->info("Added to composer.json autoload");

        $this->info("Running composer dump-autoload...");
        exec('composer dump-autoload');

        $this->info("Helper ready!");
    }
}
