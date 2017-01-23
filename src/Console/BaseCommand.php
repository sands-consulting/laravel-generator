<?php

namespace Sands\LaravelGenerator\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class BaseCommand extends GeneratorCommand
{
    protected $publishedPath;

    protected $var;

    public function __construct()
    {
        parent::__construct(app('files'));
        $this->setPublishedPath();
    }

    protected function getStub() {}

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = $this->parseName($this->getNameInput());

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error("\n" . $this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info("\n" . $this->type .' created successfully.');
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $stub = $this->replaceVar($stub, $this->getNameInput());

        return $stub;
    }


    protected function replaceVar($stub, $name)
    {
        $replace = [];

        $replace['NamespacedVarName'] = Str::Singular($name);
        $replace['NamespacedVarNames'] = Str::Plural($name);
        $replace['VarName'] = Str::Singular(class_basename($name));
        $replace['VarNames'] = Str::Plural(class_basename($name));
        $replace['varName'] = lcfirst(Str::Singular(class_basename($name)));
        $replace['var_name'] = Str::snake(Str::Singular(class_basename($name)));
        $replace['var-name'] = str_replace('_', '-', $replace['var_name']);
        $replace['var-names'] = Str::plural($replace['var-name']);
        $replace['var name'] = str_replace('-', ' ', $replace['var-name']);
        $replace['Var Name'] = Str::title($replace['var name']);
        $replace['Var Names'] = Str::plural($replace['Var Name']);

        $stub = str_replace(
            array_keys($replace), array_values($replace), $stub
        );

        return $stub;
    }

    public function setPublishedPath()
    {
        $this->publishedPath = config_path('aminadha/laravel-generator/stubs');
    }
}
