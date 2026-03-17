<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use InvalidArgumentException;

class LivewireCopyCommand extends Command
{
    protected $signature = 'livewire:copy
                            {from : Source component name, e.g. admin.users.list-users}
                            {to : Target component name, e.g. admin.users.manage-users}
                            {--force : Overwrite existing files}';

    protected $description = '[CUSTOM] Copy a Livewire component class and Blade view';

    public function handle(): int
    {
        try {
            $from = $this->normalizeComponentName($this->argument('from'));
            $to = $this->normalizeComponentName($this->argument('to'));
            $force = (bool) $this->option('force');

            if ($from === $to) {
                throw new InvalidArgumentException('Source and destination components must be different.');
            }

            $sourceClassPath = $this->componentClassPath($from);
            $targetClassPath = $this->componentClassPath($to);

            $sourceViewPath = $this->componentViewPath($from);
            $targetViewPath = $this->componentViewPath($to);

            if (! File::exists($sourceClassPath)) {
                throw new InvalidArgumentException("Source component class not found: {$sourceClassPath}");
            }

            if (! File::exists($sourceViewPath)) {
                throw new InvalidArgumentException("Source component view not found: {$sourceViewPath}");
            }

            if (! $force && File::exists($targetClassPath)) {
                throw new InvalidArgumentException("Target component class already exists: {$targetClassPath}");
            }

            if (! $force && File::exists($targetViewPath)) {
                throw new InvalidArgumentException("Target component view already exists: {$targetViewPath}");
            }

            File::ensureDirectoryExists(dirname($targetClassPath));
            File::ensureDirectoryExists(dirname($targetViewPath));

            $this->copyClassFile($from, $to, $sourceClassPath, $targetClassPath);
            File::copy($sourceViewPath, $targetViewPath);

            $this->newLine();
            $this->info('Livewire component copied successfully.');
            $this->line("Class: {$sourceClassPath} -> {$targetClassPath}");
            $this->line("View:  {$sourceViewPath} -> {$targetViewPath}");

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }

    protected function copyClassFile(string $from, string $to, string $sourceClassPath, string $targetClassPath): void
    {
        $content = File::get($sourceClassPath);

        $fromClass = $this->classNameFromComponent($from);
        $toClass = $this->classNameFromComponent($to);

        $toNamespace = $this->namespaceFromComponent($to);

        $fromView = $this->viewNameFromComponent($from);
        $toView = $this->viewNameFromComponent($to);

        $content = preg_replace(
            '/^namespace\s+[^;]+;/m',
            'namespace ' . $toNamespace . ';',
            $content
        );

        $content = preg_replace(
            '/class\s+' . preg_quote($fromClass, '/') . '\b/',
            'class ' . $toClass,
            $content,
            1
        );

        $content = str_replace(
            [
                "'{$fromView}'",
                "\"{$fromView}\"",
                "'{$fromView}.index'",
                "\"{$fromView}.index\"",
            ],
            [
                "'{$toView}'",
                "\"{$toView}\"",
                "'{$toView}.index'",
                "\"{$toView}.index\"",
            ],
            $content
        );

        File::put($targetClassPath, $content);
    }

    protected function normalizeComponentName(string $name): string
    {
        return trim(str_replace(['/', '\\'], '.', $name), '.');
    }

    protected function componentClassPath(string $component): string
    {
        $relative = collect(explode('.', $component))
            ->map(fn ($part) => Str::studly($part))
            ->implode('/');

        return app_path("Livewire/{$relative}.php");
    }

    protected function componentViewPath(string $component): string
    {
        $relative = collect(explode('.', $component))
            ->map(fn ($part) => Str::kebab($part))
            ->implode('/');

        return resource_path("views/livewire/{$relative}.blade.php");
    }

    protected function classNameFromComponent(string $component): string
    {
        return Str::studly(last(explode('.', $component)));
    }

    protected function namespaceFromComponent(string $component): string
    {
        $parts = explode('.', $component);
        array_pop($parts);

        $base = 'App\\Livewire';

        if (empty($parts)) {
            return $base;
        }

        return $base . '\\' . collect($parts)
            ->map(fn ($part) => Str::studly($part))
            ->implode('\\');
    }

    protected function viewNameFromComponent(string $component): string
    {
        return 'livewire.' . collect(explode('.', $component))
            ->map(fn ($part) => Str::kebab($part))
            ->implode('.');
    }
}
