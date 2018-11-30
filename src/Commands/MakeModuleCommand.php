<?php
namespace Asif\LaravelModuler\Commands;
use Illuminate\Console\Command;
use Asif\LaravelModuler\Traits\FolderGenerateAble;
use File;
class MakeModuleCommand extends Command
{
    use FolderGenerateAble;
    protected $signature='make:module {moduleName}';

    protected $description="This command is used to generate module";

    public function handle()
    {
        if($this->getModuleType()==='WEB')
        {
            $this->generateModule($this->argument('moduleName'));
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

    
}