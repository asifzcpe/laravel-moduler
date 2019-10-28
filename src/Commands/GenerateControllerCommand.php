<?php

namespace Asif\LaravelModuler\Commands;

use Illuminate\Console\Command;
use Asif\LaravelModuler\Traits\FolderGenerateAble;
use Asif\LaravelModuler\Traits\StubGenerateAble;
use File;
use Artisan;

class GenerateControllerCommand extends Command
{
    use StubGenerateAble;
    protected $signature="lmoduler:controller {ModuleName} {ControllerName}";
    protected $description="This command is used to generate extra controller into an existing module";
    private $controllerName;
    private $moduleName;
    private $controllerPath;
    public function handle()
    {
        $this->moduleName=$this->argument('ModuleName');
        $this->controllerName=$this->argument('ControllerName');
        $this->controllerPath='Api/v1/'.$this->moduleName;
        $this->generateExtraController($this->controllerName, $this->controllerPath);
    }
}