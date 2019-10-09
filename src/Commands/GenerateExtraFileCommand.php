<?php
namespace Asif\LaravelModuler\Commands;
use Illuminate\Console\Command;
use Asif\LaravelModuler\Traits\FolderGenerateAble;
use Asif\LaravelModuler\Traits\StubGenerateAble;
use File;

class GenerateExtraFileCommand extends Command
{
    
    private $fileTypes=[
    	'controller',
    	'model',
    	'migration',
    	'request',
    ];
    protected $signature='lmoduler:extra {fileType}';

    protected $description="This command is used to generate extra controller,migration,model or request file in a module";

    public function handle()
    {
        $fileTypeChoice=$this->choice('Select Type',$this->fileTypes);
        $this->info($fileTypeChoice);
    }
    
}