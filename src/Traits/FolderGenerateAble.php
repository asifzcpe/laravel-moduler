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
        'Routes'
    ];
    private $databaseSubFolders=['Migrations','Factories','Seeds'];

    public function generateModule($moduleName,$authOption=false,$srcFolderName="Modules")
    {
        $this->moduleName=$srcFolderName.'/'.ucfirst($moduleName);

        if(!file_exists($this->moduleName))
        {
            File::makeDirectory($this->moduleName,$mode=0777,true,true);
            if($srcFolderName==='Modules')
            {
                array_push($this->moduleFolders,"Views");
            }
            $this->generateModuleFolders($this->moduleName,$this->moduleFolders);
            $this->generateModuleSubFolders($this->moduleName,'Database',$this->databaseSubFolders);
            $this->generateController($moduleName,$this->moduleName);
            $this->generateRequest($moduleName,$this->moduleName);
            $this->generateModel($moduleName,$this->moduleName);
            $this->generateMigrationFiles($moduleName,$this->moduleName);
            if($srcFolderName==="Modules")
            {
                $this->generateViewFiles($moduleName,$this->moduleName);
                $this->generateWebRoute($moduleName,$authOption,$this->moduleName);
            }
            else
            {
                $this->generateApiRoute($moduleName,$authOption,$this->moduleName);
            }
        }
        else
        {
            $this->error($moduleName." module has already been created. Please, try other");
        }
    }

    private function generateModuleFolders($moduleName,$folders)
    {
        foreach($folders as $moduleFolder)
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