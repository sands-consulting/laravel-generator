<?php

namespace Sands\LaravelGenerator\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ViewMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create view files (CRUD)';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Views';


    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        foreach ($this->getViewStubs() as $name => $stub) {
            
            $path = $this->getPath($name);

            if ($this->alreadyExists($this->getNameInput())) {
                $this->error($this->type.' already exists! Ignore view creation.');

                return false;
            }

            $this->makeDirectory($path);

            $this->files->put($path, $this->buildClass($stub));
        }
        
        $this->info("\n" . $this->type.' created successfully.');
    }
    
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($name);
        $stub = $this->replaceVar($stub, $this->getNameInput());

        return $stub;
    }

    public function getViewStubs()
    {
        $stubs = [];

        $views = [
            'index' => 'views.index.stub',
            'create' => 'views.create.stub',
            'edit' => 'views.edit.stub',
            'show' => 'views.show.stub',
        ];

        foreach ($views as $name => $view) {
            if ($this->files->exists($this->publishedPath . '/' . $view)) {
                $stubs[$name] = $this->publishedPath . '/' . $view;
            } else {
                $stubs[$name] = __DIR__.'/stubs/' . $view;
            }
        }

        return $stubs;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {}

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $inputs = collect(explode('\\',$this->getNameInput()));
        
        $inputs = $inputs->map(function ($value, $key) {
            return str_replace('_', '-', Str::snake($value));
        });

        $folder = 'views/' . implode('/', $inputs->toArray());

        return $this->laravel['path.resources'] . '/' . str_replace('\\', '/', $folder) . '/' . $name . '.blade.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        $name = $this->parseName($rawName);

        return $this->files->exists($this->getPath($name));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['resource', 'r', InputOption::VALUE_NONE, 'Create resources.'],
        ];
    }
}
