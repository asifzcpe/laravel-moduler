<?php

// namespace App\Providers;
namespace Asif\LaravelModuler\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $moduleFolders=scandir("app/Modules");
        $modules=array_diff($moduleFolders,['.','..']);
        foreach($modules as $module)
        {
            $this->loadModulesViews($module);
            $this->loadModulesRoutes($module);
            $this->loadModulesMigrations($module);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function loadModulesViews($module)
    {
        $this->viewsPath=__DIR__.'/'.$module.'/'.'Views';
        if(file_exists($this->viewsPath))
        {
            $this->loadViewsFrom($this->viewsPath,$module);
        }
    }

    private function loadModulesRoutes($module)
    {
        $this->routesWebPath=__DIR__.'/'.$module.'/routes/'.'web.php';
        $this->routesApiPath=__DIR__.'/'.$module.'/routes/'.'api.php';
        if(file_exists($this->routesWebPath))
        {
            include $this->routesWebPath;
        }
        if(file_exists($this->routesApiPath))
        {
            include $this->routesApiPath;
        }
    }

    private function loadModulesMigrations($module)
    {
        $this->migrationsPath=__DIR__.'/'.$module.'/'.'Migrations';
        if(file_exists($this->migrationsPath))
        {
            $this->loadMigrationsFrom($this->migrationsPath);
        }
    }


}