<?php

namespace LevelUp\Experience\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeMultiplierCommand extends GeneratorCommand
{
    protected $name = 'level-up:multiplier';

    protected $description = 'Create a new Multiplier class';

    protected $type = 'Multiplier';

    protected function replaceClass($stub, $name): string
    {
        $stub = parent::replaceClass($stub, $name);

        $multiplier = $this->option(key: 'multiplier') ?? Str::studly(value: class_basename(class: $this->argument(key: 'name')));

        return str()->replace(['[class]', '{{ multiplier }}'], $multiplier, $stub);
    }

    protected function getStub(): string
    {
        $relativePath = '/../../stubs/Multiplier.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
            ? $customPath
            : __DIR__.$relativePath;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Multipliers';
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the multiplier'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the multiplier already exists'],
            ['multiplier', null, InputOption::VALUE_OPTIONAL, 'The name of the multiplier'],
        ];
    }
}
