<?php
namespace Asif\LaravelModuler\Traits;
use File;

trait StubGenerateAble
{
	private $stubPath;
	public function setPath($stubPath)
	{
		$this->stubPath=$stubPath;
	}

	public function getStub($type)
	{
		return file_get_contents(app_path('Modules/Core/Stubs/'.$type.'.stub'));
	}

}