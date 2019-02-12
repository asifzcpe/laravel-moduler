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
        if($this->getModuleType()==='WEB')
        {
            if($this->authenticationOPtions()==='Yes')
            {
                if(Route::has('login'))
                {
                    $this->generateModule($moduleName,true);
                }
                else
                {
                    $this->error("authentication is not enabled in the app.");
                    if($this->confirm("Are you sure to enable authentication"))
                    {
                        $this->info("enabling auth.....");
                        Artisan::call('make:auth');
                        $this->generateModule($moduleName,true);
                    }
                }
            }
            else
            {
                $this->generateModule($moduleName,false);
            }
        }
        else if($this->getModuleType()=='API')
        {
            $this->info('api');
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
    
}