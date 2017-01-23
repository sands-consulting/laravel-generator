<?php

namespace Sands\LaravelGenerator\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class LangMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:langs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create translation files';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Langs';


    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        foreach ($this->getLangStubs() as $name => $stub) {
            
            $path = $this->getPath($name);

            if ($this->alreadyExists($name)) {
                $this->error($this->type.' already exists! stop lang file creation.');

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

    public function getLangStubs()
    {
        $stubs = [];

        $views = [
            'en' => 'lang.en.stub',
            'ms' => 'lang.ms.stub',
        ];

        foreach ($views as $name => $stub) {
            if ($this->files->exists($this->publishedPath . '/' . $stub)) {
                $stubs[$name] = $this->publishedPath . '/' . $stub;
            } else {
                $stubs[$name] = __DIR__.'/stubs/' . $stub;
            }
        }

        return $stubs;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $basename = class_basename($this->getNameInput());
        $name = $name . '/' .str_replace('_', '-', Str::Snake($basename));
        
        return $this->laravel['path.lang'] . '/' .  $name . '.php';
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
    protected function alreadyExists($name)
    {
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
