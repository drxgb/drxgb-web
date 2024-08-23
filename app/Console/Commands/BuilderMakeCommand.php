<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;


class BuilderMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:builder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new builder.';


	/**
	 * @return string
	 */
	protected function getStub()
	{
		$relativePath = '/stubs/builder.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
            ? $customPath
            : __DIR__.$relativePath;
	}


	/**
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\Builders";
    }
}
