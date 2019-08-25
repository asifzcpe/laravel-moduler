<?php
namespace Asif\LaravelModuler\Commands;
use Illuminate\Console\Command;
use Asif\LaravelModuler\Traits\FolderGenerateAble;
use Asif\LaravelModuler\Traits\StubGenerateAble;
use File;
use Route;
use Artisan;
class MakeModuleCommand extends Command
{
    use FolderGenerateAble;
    
    protected $signature='make:module {moduleName}';

    protected $description="This command is used to generate module";

    public function handle()
    {
        $moduleName=$this->argument('moduleName');
        $moduleType=$this->getModuleType();
        if($moduleType==='WEB')
        {
            $this->makeDomainFolderIfNotExists('Modules');

            if($this->authenticationOPtions()==='Yes')
            {
                if(Route::has('login'))
                {
                    $this->generateModule($moduleName,true,"Modules");
                }
                else
                {
                    $this->error("authentication is not enabled in the app.");
                    if($this->confirm("Are you sure to enable authentication"))
                    {
                        $this->info("enabling auth.....");
                        Artisan::call('make:auth');
                        $this->generateModule($moduleName,true,"Modules");
                    }
                }
            }
            else
            {
                $this->generateModule($moduleName,false,"Modules");
            }

            $this->generateModulerServiceProviderIfNotExists();
        }
        else if($moduleType==='API')
        {
            $this->makeDomainFolderIfNotExists('Api/v1');
            $this->generateModule($moduleName,false,"Api/v1");
            $this->generateApiServiceProviderIfNotExists();
        }
    }

    /**
     * This method is used to get the module type
     * we may need 2 types of module such as web and api
     * @return string $moduleType
     */
    private function getModuleType()
    {
        $moduleType=$this->choice('Select Your Module Type',['WEB','API']);
        return $moduleType;
    }

    public function authenticationOPtions()
    {
        $authenticationType=$this->choice("Do you want to enable authentication for this module",["Yes","No"]);
        return $authenticationType;
    }

    /**
     * This method is used to make a modules folder where all business logics and
     * other things reside.
     */
    private function makeDomainFolderIfNotExists($domainType)
    {
        
        if(!file_exists($domainType))
        {
            File::makeDirectory($domainType,$mode=0777,true,true);    
        }
    }

    /**
     * This method is used to generate module service provider
     */
    private function generateModulerServiceProviderIfNotExists()
    {
        $path=app_path('Providers/ModuleServiceProvider.php');
        if(!file_exists($path))
        {
            file_put_contents($path,file_get_contents(base_path('vendor/asif/laravel-moduler/src/Stubs/ModuleServiceProvider.stub')));  
        }
    }

    /**
     * This method is used to generate api service provider
     */
    private function generateApiServiceProviderIfNotExists()
    {
        $path=app_path('Providers/ApiServiceProvider.php');
        if(!file_exists($path))
        {
            file_put_contents($path,file_get_contents(base_path('vendor/asif/laravel-moduler/src/Stubs/ApiServiceProvider.stub')));  
        }
    }
    
}