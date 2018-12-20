<?php
namespace Asif\LaravelModuler\Traits;
use File;
use Illuminate\Support\Str;
trait StubGenerateAble
{
	
	public function getStub($type,$stubName)
	{
		return file_get_contents(base_path('vendor/asif/laravel-moduler/src/Stubs/'.$type.'/'.$stubName.'.stub'));
	}

	public function generateController($moduleFolder)
	{
		$controllerTemplate=str_replace([
			'{ModulerFolder}',
			'{ControllerName}',
			'{ModelName}'
		],
		[
			$moduleFolder,
			Str::singular(ucfirst($moduleFolder.'Controller')),
			Str::singular(ucfirst($moduleFolder)),
		],$this->getStub('Controllers','Controller'));

		file_put_contents(app_path('Modules/'.$moduleFolder.'/Controllers/'.$moduleFolder.'Controller.php'),$controllerTemplate);
	}

	public function generateRequest($moduleFolder)
	{
		$formRequestTemplate=str_replace([
			'{ModulerFolder}',
		],
		[
			$moduleFolder,
			Str::singular(ucfirst($moduleFolder))
		],$this->getStub('Requests','FormRequest'));

		file_put_contents(app_path('Modules/'.$moduleFolder.'/Requests/'.$moduleFolder.'Request.php'),$formRequestTemplate);
	}

	public function generateModel($moduleFolder)
	{
		$modelTemplate=str_replace([
			'{ModulerFolder}',
			'{modulesModelName}',
			'{tableName}'
		],
		[
			$moduleFolder,
			Str::singular(ucfirst($moduleFolder)),
			strtolower(Str::plural($moduleFolder))
		],$this->getStub('Models','Model'));

		file_put_contents(app_path('Modules/'.$moduleFolder.'/Models/'.Str::singular($moduleFolder).'.php'),$modelTemplate);
	}

	public function generateRoute($moduleFolder)
	{
		$routeTemplate=str_replace([
			'{ModulerFolder}',
			'{resourceUrl}',
			'{ControllerName}',
			'{auth}'
		],
		[
			$moduleFolder,
			Str::plural(strtolower($moduleFolder)),
			Str::singular(ucfirst($moduleFolder)),
			'[]'
		],$this->getStub('Routes','Route'));

		file_put_contents(app_path('Modules/'.$moduleFolder.'/Routes/'.'web.php'),$routeTemplate);
	}

}