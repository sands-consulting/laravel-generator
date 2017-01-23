<?php

namespace Sands\LaravelGenerator\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ProviderMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service provider class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Provider';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('model')) {
            if ($this->files->exists($this->publishedPath . '/provider.model.stub')) {
                return $this->publishedPath . '/provider.model.stub';
            } else {
                return __DIR__.'/stubs/provider.model.stub';
            }
        }

        if ($this->files->exists($this->publishedPath . '/provider.stub')) {
            return $this->publishedPath . '/provider.stub';
        } else {
            return __DIR__.'/stubs/provider.stub';
        }
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Providers\\Modules';
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function parseName($name)
    {
        $rootNamespace = $this->laravel->getNamespace();

        if (! Str::contains(Str::lower($name), 'provider')) {
            $name = ucfirst(Str::Plural($name)) . 'Provider';
        }

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.class_basename($name));
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace.$model;
        }

        return $model;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The provider has bind model.'],
        ];
    }
}
