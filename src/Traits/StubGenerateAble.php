<?php

namespace Asif\LaravelModuler\Traits;

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
				Str::kebab(Str::plural($moduleFolder))
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

	/**
	 *
	 */
	public function generateExtraController($controllerName, $modulePath)
	{
		$controllerStub = $this->getStub('Controllers', 'ExtraController');
		$extraControllerName = Str::singular(ucfirst($controllerName));
		$controllerTemplate = str_replace(
			[
				'{ModulePath}',
				'{ExtraControllerName}',
			],
			[
				str_replace('/', '\\', $modulePath),
				$extraControllerName,
			],
			$controllerStub
		);

		file_put_contents($modulePath . '/Controllers/' . $extraControllerName . '.php', $controllerTemplate);
    }

    public function generateExtraModel($modelName, $modulePath)
	{
        $moduleNameSingular = Str::singular(ucfirst($modelName));
		$modelTemplate = str_replace(
			[
				'{ModulePath}',
				'{ModuleNameSingular}',
				'{TableName}'
			],
			[
				str_replace('/', '\\', $modulePath),
				$moduleNameSingular,
				Str::snake(Str::plural($modelName))
			],
			$this->getStub('Models', 'Model')
		);

		file_put_contents($modulePath . '/Models/' . $moduleNameSingular . '.php', $modelTemplate);
	}

	public function insertResourceRouteInModuleRoutes($file,$newRoute)
	{
		$this->removeEmptyLines($file) ;
		$fc = fopen($file, "r");
		while (!feof($fc)) {
		    $buffer = fgets($fc, 4096);
		    if($buffer!=""){
		    	$lines[] = $buffer;
		    }
		}

		fclose($fc);

		//open same file and use "w" to clear file
		$f = fopen($file, "w") or die("couldn't open $file");

		$lineCount = count($lines);
		//loop through array writing the lines until the secondlast

		for ($i = 0; $i < $lineCount-1; $i++) {
				fwrite($f, $lines[$i]);
		}

		fwrite($f, "\t".$newRoute.PHP_EOL);

		//write the last line
		fwrite($f, $lines[$lineCount-1]);
		fclose($f);
	}

	public function removeEmptyLines($fullPath)
	{
		$tempFile_ar = array();

        $fileContent = @file($fullPath);
        if (!$fileContent) return false;


        $countLines = 0;
        foreach ($fileContent as $key => $value)
        {
            if (trim($value) != '') {
                $tempFile_ar[] = $value;
                $countLines++;
            }
        }


        $new = '';
        $i = 0;
        foreach ($tempFile_ar as $k=>$line)
        {
            $i++;

            if ($i != $countLines) {
                $line = str_replace("\r", "", $line);
                $line = str_replace("\n", "", $line);
                if (!empty($line)) $new .= $line . "\n";
            }
            else {
                $line = str_replace("\r", "", $line);
                $line = str_replace("\n", "", $line);
                if (!empty($line)) $new .= $line;
            }
        }
        $fp = fopen ($fullPath, 'w');
        fputs($fp, $new);
        fclose($fp);

        return true;
	}

}
