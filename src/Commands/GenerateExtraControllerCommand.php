<?php
namespace Asif\LaravelModuler\Commands;
use Illuminate\Console\Command;
use Asif\LaravelModuler\Traits\FolderGenerateAble;
use Asif\LaravelModuler\Traits\StubGenerateAble;
use File;

class GenerateExtraControllerCommand extends Command
{
    
    protected $signature='make:m-controller {moduleName}';

    protected $description="This command is used to generate module";

    public function handle()
    {
        $moduleName=$this->argument('moduleName');
    }
    
}