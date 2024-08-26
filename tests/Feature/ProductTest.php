<?php

namespace Tests\Feature;

use App\Models\Platform;
use App\Models\Product;
use App\Models\Version;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Tests\CreatesAdminUser;
use Tests\FakeFileSystem;
use Tests\TestCase;


class ProductTest extends TestCase
{
	use RefreshDatabase;
	use CreatesAdminUser;
	use FakeFileSystem;


	/**
	 * Testa se o produto pode ser criado.
	 *
	 * @return void
	 */
    public function test_product_can_be_created() : void
	{
		$attributes = Product::factory()->raw();
		$versions = $this->makeVersionsRequest();

		$uri = route('admin.products.store');
		$data = array_merge($attributes, [
			'versions'	=> $versions,
		]);

		$response = $this->actingAs($this->user)->post($uri, $data);
		$response->assertValid();
		$response->assertRedirect();
	}


	/**
	 * @return void
	 */
	protected function setUp() : void
	{
		parent::setUp();
		$this->createAdminUser();
	}


	/**
	 * @return void
	 */
	protected function tearDown() : void
	{
		$this->deleteAdminUser();
		parent::tearDown();
	}


	/**
	 * Cria os dados de formulário simulado das
	 * versões.
	 *
	 * @return array
	 */
	private function makeVersionsRequest() : array
	{
		$versions = Version::factory()->count(3)->raw();
		$platforms = Platform::factory()
			->withFileExtensions()
			->count(3)
			->create()
			->toArray();

		foreach ($versions as $i => $version)
		{
			$count = random_int(1, count($platforms) - 1);
			$selectedPlatformIds = Arr::random($platforms, $count);

			$files = [
				'name'			=> fake()->streetName(),
				'platform_ids'	=> $selectedPlatformIds,
				'product_file'	=> $this->generateFile($platforms),
			];

			$versions[$i]['files'][] = $files;
		}

		return $versions;
	}


	/**
	 * Cria um arquivo de produto de acordo com as extensões
	 * suportadas de cada plataforma.
	 *
	 * @param array $platforms
	 * @return UploadedFile
	 */
	private function generateFile(array $platforms) : UploadedFile
	{
		$supportedFileExtensions = [];

		foreach ($platforms as $platform)
		{
			$supportedFileExtensions = array_replace(
				$supportedFileExtensions,
				array_map(
					fn (array $fileExtension) : string => $fileExtension['extension'],
					$platform['supported_file_extensions']
				),
			);
		}

		$name = fake()->streetName();
		$extension = Arr::random($supportedFileExtensions);
		$file = UploadedFile::fake()->create("{$name}.{$extension}");

		return $file;
	}
}
