<?php
namespace Asif\LaravelModuler\Providers;
use Illuminate\Support\ServiceProvider;
use Asif\LaravelModuler\Commands\MakeModuleCommand;
use File;
class LaravelModulerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->laravelModulerCommands();
    }

    public function register()
    {
        $this->generateModulerServiceProviderIfNotExists();
    }

    private function laravelModulerCommands()
    {
        if($this->app->runningInConsole())
        {
            $this->commands([
                MakeModuleCommand::class,
            ]);
        }
    }

    private function generateModulerServiceProviderIfNotExists()
    {
        $path=app_path('Providers/ModuleServiceProvider.php');
        if(!file_exists($path))
        {
            file_put_contents($path,file_get_contents(base_path('vendor/asif/laravel-moduler/src/Stubs/ModuleServiceProvider.stub')));  
        }
    }
}