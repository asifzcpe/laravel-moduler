<?php
namespace Asif\LaravelModuler\Traits;
use File;

trait FolderGenerateAble
{
    private $moduleName;
    private $moduleFolders=[
        'Controllers',
        'Models',
        'Database'=>['Migrations','Factories','Seeds'],
        'Requests',
        'Views',
        'Routes'
    ];
    public function generateModule($moduleName)
    {
        $this->moduleName=app_path('Modules/'.ucfirst($moduleName));
        if(!file_exists($this->moduleName))
        {
            File::makeDirectory($this->moduleName,$mode=0777,true,true);
            $this->generateModuleFolders($this->moduleName);
        }
    }

    private function generateModuleFolders($moduleName)
    {
        foreach($this->moduleFolders as $moduleFolder)
        {
            $folder=$moduleName.'/'.$moduleFolder;
            if(!file_exists($folder))
            {
                File::makeDirectory($folder,$mode=0777,true,true);
            }
        }
    }
}