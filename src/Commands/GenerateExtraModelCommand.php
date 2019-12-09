<?php

namespace Asif\LaravelModuler\Commands;

use Illuminate\Console\Command;
use Asif\LaravelModuler\Traits\FolderGenerateAble;
use Asif\LaravelModuler\Traits\StubGenerateAble;

class GenerateExtraModelCommand extends Command
{
    use StubGenerateAble;
    protected $signature="lmoduler:model {ModuleName} {ModelName}";
    protected $description="This command is used to generate extra model into an existing module";
    private $modelName;
    private $moduleName;
    private $modelPath;
    public function handle()
    {
        $this->moduleName=$this->argument('ModuleName');
        $this->modelName=$this->argument('ModelName');
        $this->modelPath='Api/v1/'.$this->moduleName;
        $this->generateExtraModel($this->modelName, $this->modelPath);
    }
}
