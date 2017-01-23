<?php

namespace Sands\LaravelGenerator\Console;

use Illuminate\Support\Str;
use InvalidArgumentException;

class RequestMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->files->exists($this->publishedPath . '/request.stub')) {
            return $this->publishedPath . '/request.stub';
        } else {
            return __DIR__.'/stubs/request.stub';
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
        return $rootNamespace.'\Http\Requests';
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

        if (! Str::contains(Str::lower($name), 'request')) {
            $name .= 'Request';
        }

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name);
    }
}
