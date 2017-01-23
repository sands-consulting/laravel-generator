<?php

namespace Sands\LaravelGenerator;

use Sands\LaravelGenerator\Console\ControllerMakeCommand;
use Sands\LaravelGenerator\Console\LangMakeCommand;
use Sands\LaravelGenerator\Console\ModelMakeCommand;
use Sands\LaravelGenerator\Console\PolicyMakeCommand;
use Sands\LaravelGenerator\Console\ProviderMakeCommand;
use Sands\LaravelGenerator\Console\RequestMakeCommand;
use Sands\LaravelGenerator\Console\ScaffoldMakeCommand;
use Sands\LaravelGenerator\Console\ViewMakeCommand;
use Illuminate\Support\ServiceProvider;

class LaravelGeneratorServiceProvider extends ServiceProvider
{

    protected $commands = [
        'ControllerMake' => 'command.laravel-controller.make',
        'ModelMake' => 'command.laravel-model.make',
        'PolicyMake' => 'command.laravel-policy.make',
        'ProviderMake' => 'command.laravel-provider.make',
        'RequestMake' => 'command.laravel-request.make',
        'ViewMake' => 'command.view.make',
        'LangMake' => 'command.lang.make',
        'ScaffoldMake' => 'command.scaffold.make',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {   
        $this->registerCommands($this->commands);

        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'laravel-generator'
        );
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $method = "register{$command}Command";

            call_user_func_array([$this, $method], []);
        }

        $this->commands(array_values($commands));
    }

     /**
     * Register the command.
     *
     * @return void
     */
    protected function registerScaffoldMakeCommand()
    {
        $this->app->singleton('command.scaffold.make', function ($app) {
            return new ScaffoldMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerControllerMakeCommand()
    {
        $this->app->singleton('command.laravel-controller.make', function ($app) {
            return new ControllerMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerLangMakeCommand()
    {
        $this->app->singleton('command.lang.make', function ($app) {
            return new LangMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModelMakeCommand()
    {
        $this->app->singleton('command.laravel-model.make', function ($app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerPolicyMakeCommand()
    {
        $this->app->singleton('command.laravel-policy.make', function ($app) {
            return new PolicyMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerProviderMakeCommand()
    {
        $this->app->singleton('command.laravel-provider.make', function ($app) {
            return new ProviderMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRequestMakeCommand()
    {
        $this->app->singleton('command.laravel-request.make', function ($app) {
            return new RequestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerViewMakeCommand()
    {
        $this->app->singleton('command.view.make', function ($app) {
            return new ViewMakeCommand($app['files']);
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('aminadha/laravel-generator/config.php'),
            __DIR__.'/Console/stubs/' => config_path('aminadha/laravel-generator/stubs')
        ], 'laravel-generator');
    }
}
