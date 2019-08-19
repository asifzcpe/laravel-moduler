<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $basePath=base_path("Api/v1");
        if(file_exists($basePath))
        {
            $moduleFolders=scandir($basePath);
            $modules=array_diff($moduleFolders,['.','..']);
            
            foreach($modules as $module)
            {
                $this->loadModulesRoutes($module);
                $this->loadModulesMigrations($module);
            }
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

    private function loadModulesRoutes($module)
    {
        $this->routesApiPath=base_path('Api/v1/'.$module.'/Routes/'.'api.php');
        
        if(file_exists($this->routesApiPath))
        {
            include $this->routesApiPath;
        }
        
    }

    private function loadModulesMigrations($module)
    {
        $this->migrationsPath=base_path('Api/v1/'.$module.'/'.'Database/Migrations');
        if(file_exists($this->migrationsPath))
        {
            $this->loadMigrationsFrom($this->migrationsPath);
        }
    }
}
