<?php

namespace Asif\LaravelModuler\Traits;

use File;
use Illuminate\Support\Str;

trait StubGenerateAble
{

	public function getStub($type, $stubName)
	{
		return file_get_contents(base_path('vendor/asif/laravel-moduler/src/Stubs/' . $type . '/' . $stubName . '.stub'));
	}

	public function generateController($moduleFolder, $modulePath, $srcFolder)
	{
		if ($srcFolder == "Modules") {
			$controllerStub = $this->getStub('Controllers', 'Controller');
		} else {
			$controllerStub = $this->getStub('Controllers', 'ApiController');
		}
		$moduleNameSingular = Str::singular(ucfirst($moduleFolder));
		$controllerTemplate = str_replace(
			[
				'{ModuleName}',
				'{ModulePath}',
				'{ModuleNameSingular}',
				'{ModuleVariableSingular}',
				'{ModuleVariablePlural}',
				'{ModuleRoute}'
			],
			[
				$moduleFolder,
				str_replace('/', '\\', $modulePath),
				$moduleNameSingular,
				Str::singular(strtolower($moduleFolder)),
				Str::plural(strtolower($moduleFolder)),
				Str::kebab(Str::plural($moduleName))
			],
			$controllerStub
		);

		file_put_contents($modulePath . '/Controllers/' . $moduleNameSingular . 'Controller.php', $controllerTemplate);
	}



	public function generateRequest($moduleName, $modulePath)
	{
		$moduleNameSingular = Str::singular(ucfirst($moduleName));
		$formRequestTemplate = str_replace(
			[
				'{ModuleNameSingular}',
				'{ModulePath}'
			],
			[
				$moduleNameSingular,
				str_replace('/', '\\', $modulePath),
			],
			$this->getStub('Requests', 'FormRequest')
		);

		file_put_contents($modulePath . '/Requests/' . $moduleNameSingular . 'Request.php', $formRequestTemplate);
	}

	public function generateModel($moduleName, $modulePath)
	{
		$moduleNameSingular = Str::singular(ucfirst($moduleName));
		$modelTemplate = str_replace(
			[
				'{ModulePath}',
				'{ModuleNameSingular}',
				'{TableName}'
			],
			[
				str_replace('/', '\\', $modulePath),
				$moduleNameSingular,
				Str::snake(Str::plural($moduleName))
			],
			$this->getStub('Models', 'Model')
		);

		file_put_contents($modulePath . '/Models/' . $moduleNameSingular . '.php', $modelTemplate);
	}

	public function generateWebRoute($moduleName, $authOption = false, $modulePath)
	{
		$routeTemplate = str_replace(
			[
				'{ModuleName}',
				'{Url}',
				'{ModuleNameSingular}',
				'{auth}'
			],
			[
				$moduleName,
				Str::kebab(Str::plural($moduleName)),
				Str::singular(ucfirst($moduleName)),
				$authOption ? "['web','auth']" : "[]"
			],
			$this->getStub('Routes', 'WebRoute')
		);

		file_put_contents($modulePath . '/Routes/' . 'web.php', $routeTemplate);
	}

	public function generateApiRoute($moduleName, $authOption = false, $srcFolder)
	{
		$routeTemplate = str_replace(
			[
				'{ModuleName}',
				'{Url}',
				'{ModuleNameSingular}',
				'{auth}',
				'{srcFolder}',
				'{namespace}'
			],
			[
				$moduleName,
				Str::kebab(Str::plural($moduleName)),
				Str::singular(ucfirst($moduleName)),
				$authOption ? "['web','auth']" : "[]",
				strtolower($srcFolder),
				str_replace('/', '\\', $srcFolder),
			],
			$this->getStub('Routes', 'ApiRoute')
		);

		file_put_contents($srcFolder . '/' . $moduleName . '/Routes/' . 'api.php', $routeTemplate);
	}

	public function generateMigrationFiles($moduleName, $modulePath)
	{
		$dummyClass = Str::studly('CreateTable' . Str::plural(($moduleName)));
		$tableName = Str::snake(Str::plural($moduleName));
		$migrationFileName = date('Y_m_d_His') . '_create_table_' . $tableName;
		$migrationTemplate = str_replace(
			[
				'DummyClass',
				'DummyTable'
			],
			[
				$dummyClass,
				$tableName
			],
			$this->getStub('Database/Migrations', 'Migration')
		);


		file_put_contents($modulePath . '/Database/Migrations/' . $migrationFileName . '.php', $migrationTemplate);
	}

	public function generateViewFiles($moduleName, $modulePath)
	{
		$viewFiles = ['index', 'create', 'show', 'edit'];
		foreach ($viewFiles as $vf) {
			file_put_contents($modulePath . '/Views/' . $vf . '.blade.php', '');
		}
	}
}
