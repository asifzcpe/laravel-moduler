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
}