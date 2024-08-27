<?php

namespace App\Console\Commands;

use App\Builders\CommandStubBuilder;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;


#[AsCommand(name: 'make:service')]
class ServiceMakeCommand extends GeneratorCommand
{
	/**
	 * O nome e a assinatura do comando do console.
	 *
	 * @var string
	 */
	protected $name = 'make:service';

	/**
	 * A descrição do comando do console.
	 *
	 * @var string
	 */
	protected $description = 'Create a new Service class';


	/**
	 * @param  string  $stub
	 * @return string
	 */
	public function resolveStubPath(string $stub) : string
	{
		return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
						? $customPath
						: __DIR__.$stub;
	}


	/**
	 * Verifica se a opção é válida.
	 *
	 * @param string $context
	 * @param ?string $option
	 * @return bool
	 */
	public function isValidOption(string $context, ?string $option = null) : bool
	{
		$method = 'get' . ucfirst($context) . 'Options';

		if (! method_exists($this, $method))
		{
			return false;
		}

		$option ??= $this->option($context);
		return $option && in_array($option, $this->$method());
	}


	/**
	 * @return string
	 */
	protected function getStub() : string
	{
		if (! $this->isValidOption('type'))
		{
			$this->fail('Invalid type. Use "creator", "editor" or "deleter"');
		}

		$type = $this->option('type');
		$base = '/stubs/services';
		$name = ! empty($type) ? $type : 'plain';

		return $this->resolveStubPath("$base/$name.stub");
	}


	/**
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace) : string
	{
		return "$rootNamespace\Services";
	}


	/**
	 * @param  string  $name
	 * @return string
	 */
	protected function buildClass($name) : string
	{
		$class = parent::buildClass($name);
		$replaceOptions = [ 'model', 'upload', 'relation' ];

		foreach ($replaceOptions as $option)
		{
			if ($this->option($option))
			{
				$optionClass = ucfirst($option);
				$builderClass = "\App\Builders\Replace{$optionClass}CommandStubBuilder";
				$onBeforeReplace = function (string $op) use ($option) : ?string
				{
					if ($option === 'model')
					{
						return $this->qualifyModel($op);
					}

					return null;
				};

				/** @var CommandStubBuilder */
				$builder = new $builderClass($this, $this->files);
				$class = $builder->beforeReplace($onBeforeReplace)
					->buildReplacements($class)
					->getResult();
			}
		}

		return str_replace($this->getReplacementPoints(), '', $class);
	}


	/**
	 * @return string
	 */
	protected function getNameInput() : string
	{
		$name = parent::getNameInput();
		return "$name\\{$this->makeServiceName($name)}";
	}


	/**
	 * Cria o nome da classe do serviço de acordo com o tipo, se houver.
	 *
	 * @param string $name
	 * @return string
	 */
	protected function makeServiceName(string $name) : string
	{
		$suffix = 'Service';
		$type = $this->option('type');

		if ($type)
		{
			$name = ucfirst($type) . $suffix;
		}
		else if (substr($name, -7) !== $suffix)
		{
			$name .= $suffix;
		}

		return $name;
	}


	/**
	 * @return array
	 */
	protected function getOptions() : array
	{
		$sep = ' | ';
		$typeOptions = implode($sep, $this->getTypeOptions());
		$uploadOptions = implode($sep, $this->getUploadOptions());
		$relationOptions = implode($sep, $this->getRelationOptions());

		return [
			[ 'force',		null, InputOption::VALUE_NONE,		"Create the class even if the controller already exists" ],
			[ 'model',		null, InputOption::VALUE_REQUIRED,	"Generate a resource controller for the given model" ],
			[ 'type',		null, InputOption::VALUE_REQUIRED,	"Generate a service by type (Accepted values: $typeOptions)" ],
			[ 'upload',		null, InputOption::VALUE_REQUIRED,	"Inject upload functions by type (Accepted values: $uploadOptions)" ],
			[ 'relation',	null, InputOption::VALUE_REQUIRED,	"Inject model relation functions by type (Accepted values: $relationOptions)" ],
		];
	}


	/**
	 * Recebe os tipos de serviços disponíveis.
	 *
	 * @return array
	 */
	protected function getTypeOptions() : array
	{
		return [ 'creator', 'editor', 'deleter' ];
	}


	/**
	 * Recebe os tipos de upload disponíveis.
	 *
	 * @return array
	 */
	protected function getUploadOptions() : array
	{
		return [ 'single', 'multiple' ];
	}


	/**
	 * Recebe os relacionamentos disponíveis.
	 *
	 * @return array
	 */
	protected function getRelationOptions() : array
	{
		return [ 'associate', 'attach', 'sync', 'assign-single', 'assign-multiple' ];
	}


	/**
	 * Recebe os pontos de substituição do documento.
	 *
	 * @return array
	 */
	protected function getReplacementPoints() : array
	{
		return [
			'{{ #interfaces }}',
			'{{ #imports }}' . PHP_EOL,
			'{{ #traits }}' . PHP_EOL,
			'{{ #properties }}' . PHP_EOL,
			'{{ #constructor }}' . PHP_EOL,
			'{{ #publicMethods }}' . PHP_EOL,
			'{{ #protectedMethods }}' . PHP_EOL,
			'{{ #privateMethods }}' . PHP_EOL,
		];
	}
}
