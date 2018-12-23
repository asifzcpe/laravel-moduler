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
        $this->makeModulesFolderIfNotExists();
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

    /**
     * This method is used to make a modules folder where all business logics and
     * other things reside.
     */
    private function makeModulesFolderIfNotExists()
    {
        $path=app_path('Modules');
        if(!file_exists($path))
        {
            File::makeDirectory($path,$mode=0777,true,true);    
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