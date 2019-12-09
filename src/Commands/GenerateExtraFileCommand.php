<?php
namespace Asif\LaravelModuler\Commands;

use Illuminate\Console\Command;
use Asif\LaravelModuler\Traits\FolderGenerateAble;
use Asif\LaravelModuler\Traits\StubGenerateAble;
use File;
use Artisan;

class GenerateExtraFileCommand extends Command
{
    use StubGenerateAble;
    private $fileTypes=[
        'Controllers',
        'Models',
        'Migrations',
        'Requests',
    ];
    private $modules=[];
    private $selectedModule;

    private $selectedFileType;
    private $fileName;
    protected $signature='lmoduler:extra {ModuleType}';

    protected $description="This command is used to generate extra controller,migration,model or request file in a module";

    public function handle()
    {
        $this->selectedFileType=$this->choice('Select Type', $this->fileTypes);
        $this->modules=scandir(base_path('Api/v1/'));
        $this->selectedModule=$this->choice('Select the module', array_values(array_diff($this->modules, ['.','..'])));
        $this->fileName=$this->ask("Please,enter file name ");
        switch ($this->selectedFileType) {
            case 'Controllers':
                // Artisan::call('make:controller', [
                //     'name'=>"\\Api\\v1\\".$this->selectedModule."\\Controllers\\".$this->fileName,
                //     '--resource'=>'--resource'
                // ]);

                $this->generateExtraController($this->fileName, $this->modules.$this->selectedModule."/Controllers/".$this->fileName);
                break;

            case 'Models':
                $this->info('controllers');
                break;

            case 'Migrations':
                $this->info('controllers');
                break;

            case 'Requests':
                $this->info('controllers');
                break;
        }
    }
}
