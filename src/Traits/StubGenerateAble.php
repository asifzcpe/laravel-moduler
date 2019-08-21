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

	public function generateController($moduleFolder,$srcFolder)
	{

		$controllerTemplate=str_replace([
			'{ModulerFolder}',
			'{SrcFolder}',
			'{ControllerName}',
			'{ModelName}'
		],
		[
			$moduleFolder,
			str_replace('/', '\\', $srcFolder),
			Str::singular(ucfirst($moduleFolder.'Controller')),
			Str::singular(ucfirst($moduleFolder)),
		],$this->getStub('Controllers','Controller'));

		file_put_contents($srcFolder.'/Controllers/'.$moduleFolder.'Controller.php',$controllerTemplate);
	}

	public function generateRequest($moduleFolder,$srcFolder)
	{
		$formRequestTemplate=str_replace([
			'{ModulerFolder}',
			'{SrcFolder}'
		],
		[
			$moduleFolder,
			str_replace('/', '\\', $srcFolder),
		],$this->getStub('Requests','FormRequest'));

		file_put_contents($srcFolder.'/Requests/'.$moduleFolder.'Request.php',$formRequestTemplate);
	}

	public function generateModel($moduleFolder,$srcFolder)
	{
		$modelTemplate=str_replace([
			'{ModulerFolder}',
			'{SrcFolder}',
			'{modulesModelName}',
			'{tableName}'
		],
		[
			$moduleFolder,
			str_replace('/', '\\', $srcFolder),
			Str::singular(ucfirst($moduleFolder)),
			strtolower(Str::plural($moduleFolder))
		],$this->getStub('Models','Model'));

		file_put_contents($srcFolder.'/Models/'.Str::singular($moduleFolder).'.php',$modelTemplate);
	}

	public function generateWebRoute($moduleFolder,$authOption=false,$srcFolder)
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
			ucfirst($moduleFolder),
			$authOption?"['web','auth']":"[]"
		],$this->getStub('Routes','WebRoute'));

		file_put_contents($srcFolder.'/Routes/'.'web.php',$routeTemplate);
	}

	public function generateApiRoute($moduleFolder,$authOption=false,$srcFolder)
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
			ucfirst($moduleFolder),
			$authOption?"['web','auth']":"[]"
		],$this->getStub('Routes','ApiRoute'));

		file_put_contents($srcFolder.'/Routes/'.'api.php',$routeTemplate);
	}

	public function generateMigrationFiles($moduleFolder,$srcFolder)
	{
		$dummyClass=Str::studly('CreateTable'.Str::plural(($moduleFolder)));
		$tableName=strtolower(Str::plural($moduleFolder));
		$migrationFileName=date('Y_m_d_His').'_create_table_'.$tableName;
		$migrationTemplate=str_replace([
			'DummyClass',
			'DummyTable'
		],
		[
			$dummyClass,
			$tableName
		],$this->getStub(null,'Migration'));
		

		file_put_contents($srcFolder.'/Database/Migrations/'.$migrationFileName.'.php',$migrationTemplate);
	}

	public function generateViewFiles($moduleFolder,$srcFolder)
	{
		$viewFiles=['index','create','show','edit'];
		foreach($viewFiles as $vf)
		{
			file_put_contents($srcFolder.'/Views/'.$vf.'.blade.php','');
		}
	}
}