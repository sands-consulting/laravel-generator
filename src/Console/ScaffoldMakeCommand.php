<?php

namespace Sands\LaravelGenerator\Console;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class ScaffoldMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'generate:scaffold {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all files';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Scaffold';
    
    /**
     * Sub commands to run.
     *
     * @var  array
     */
    protected $commands = [
        'controller',
        'model',
        'policy',
        'provider',
        'request',
        'views',
        'lang',
    ];

    public function handle()
    {
        $name = $this->getNameInput();
        $model = $this->ask('Enter your ModelName');
        $bindModel = $this->confirm('Use model binding?', true);

        $bar = $this->output->createProgressBar(count($this->commands));

        foreach ($this->commands as $command) {
            $args = [];
            switch($command) {
                case 'controller':
                case 'provider':
                case "policy":
                    $args['name'] = $name;
                    $bindModel ? $args['-m'] = $model : false;
                    break;
                case "request":
                case "model":
                    $args['name'] = $model;
                    break;
                case "lang":
                case "views":
                    $args['name'] = $name;
                    break;
            }

            $this->call("generate:{$command}", $args);
            $bar->advance();
        }

        $bar->finish();
    }

    public function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],

            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],
        ];
    }
}
