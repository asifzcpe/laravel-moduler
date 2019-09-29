<?php

namespace Asif\LaravelModuler\Traits;

use File;

trait FolderGenerateAble
{
    use StubGenerateAble;
    private $moduleFolders = [
        'Controllers',
        'Models',
        'Database',
        'Requests',
        'Routes'
    ];
    private $databaseSubFolders = ['Migrations', 'Factories', 'Seeds'];

    public function generateModule($moduleName, $authOption = false, $srcFolderName = "Modules")
    {
        $modulePath = $srcFolderName . '/' . ucfirst($moduleName);

        if (!file_exists($modulePath)) {
            File::makeDirectory($modulePath, $mode = 0777, true, true);
            if ($srcFolderName === 'Modules') {
                array_push($this->moduleFolders, "Views");
            }
            $this->generateModuleFolders($modulePath, $this->moduleFolders);
            $this->generateModuleSubFolders($modulePath, 'Database', $this->databaseSubFolders);
            $this->generateController($moduleName, $modulePath, $srcFolderName);
            $this->generateRequest($moduleName, $modulePath);
            $this->generateModel($moduleName, $modulePath);
            $this->generateMigrationFiles($moduleName, $modulePath);
            if ($srcFolderName === "Modules") {
                $this->generateViewFiles($moduleName, $modulePath);
                $this->generateWebRoute($moduleName, $authOption, $modulePath);
            } else {
                $this->generateApiRoute($moduleName, $authOption, $srcFolderName);
            }
        } else {
            $this->error($moduleName . " module has already been created. Please, try other");
        }
    }

    private function generateModuleFolders($moduleName, $folders)
    {
        foreach ($folders as $moduleFolder) {
            $folder = $moduleName . '/' . $moduleFolder;
            if (!file_exists($folder)) {
                File::makeDirectory($folder, $mode = 0777, true, true);
            }
        }
    }

    private function generateModuleSubFolders($moduleName, $folderName, $subFolders)
    {
        foreach ($subFolders as $subFolder) {
            $folder = $moduleName . '/' . $folderName . '/' . $subFolder;
            if (!file_exists($folder)) {
                File::makeDirectory($folder, $mode = 0777, true, true);
            }
        }
    }
}
