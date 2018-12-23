<?php
namespace Asif\LaravelModuler\Traits;
use File;

trait FolderGenerateAble
{
    use StubGenerateAble;
    private $moduleName;
    private $moduleFolders=[
        'Controllers',
        'Models',
        'Database',
        'Requests',
        'Views',
        'Routes'
    ];
    private $databaseSubFolders=['Migrations','Factories','Seeds'];
    public function generateModule($moduleName)
    {
        $this->moduleName=app_path('Modules/'.ucfirst($moduleName));
        if(!file_exists($this->moduleName))
        {
            File::makeDirectory($this->moduleName,$mode=0777,true,true);
            $this->generateModuleFolders($this->moduleName);
            $this->generateModuleSubFolders($this->moduleName,'Database',$this->databaseSubFolders);
            $this->generateController($moduleName);
            $this->generateRequest($moduleName);
            $this->generateModel($moduleName);
            $this->generateRoute($moduleName);
            $this->generateMigrationFiles($moduleName);
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

    private function generateModuleSubFolders($moduleName,$folderName,$subFolders)
    {
        foreach($subFolders as $subFolder)
        {
                $folder=$moduleName.'/'.$folderName.'/'.$subFolder;
                if(!file_exists($folder))
                {
                    File::makeDirectory($folder,$mode=0777,true,true);
                }   
        }
    }
}