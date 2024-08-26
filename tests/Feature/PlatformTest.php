<?php

namespace Tests\Feature;

use App\StorePublicFiles;
use Tests\TestCase;
use App\Models\Platform;
use Tests\FakeFileSystem;
use Illuminate\Support\Str;
use Tests\CreatesAdminUser;
use App\Models\FileExtension;
use App\Services\Platform\CreatorService;
use App\Services\Platform\DeleterService;
use App\Services\Platform\EditorService;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlatformTest extends TestCase
{
	use RefreshDatabase;
	use FakeFileSystem;
	use CreatesAdminUser;
	use StorePublicFiles;


	/**
	 * @var string
	 */
	protected $defaultDisk = 'public';


	/**
	 * Testa se a plataforma pode ser criada sem ícone.
	 *
	 * @return void
	 */
    public function test_can_be_created_without_icon() : void
	{
		$user = $this->user;
		$attributes = Platform::factory()->raw();
		$fileExtensions = FileExtension::factory(2)->create()->toArray();

		$uri = route('admin.platforms.store');
		$data = array_merge($attributes, [
			'file_extensions'	=> array_map(fn (array $e) : int => $e['id'], $fileExtensions),
		]);

		$response = $this->actingAs($user)->post($uri, $data);
		$response->assertRedirect();
	}


	/**
	 * Testa se a plataforma pode ser criada com ícone.
	 *
	 * @return void
	 */
    public function test_can_be_created_with_icon() : void
	{
		$this->setupFileSystem();

		$user = $this->user;
		$attributes = Platform::factory()->raw();
		$fileExtensions = FileExtension::factory(3)->create()->toArray();

		$uri = route('admin.platforms.store');
		$data = array_merge($attributes, [
			'file_extensions'	=> array_map(fn (array $e) : int => $e['id'], $fileExtensions),
			'icon'				=> $this->generateIcon(),
		]);

		$response = $this->actingAs($user)->post($uri, $data);
		$platform = Platform::latest()->first();

		$response->assertRedirect();
		$this->fs->assertExists($platform->getFullFileName());
	}


	/**
	 * Testa se pode ser criado sem vincular-se a nenhuma extensão de arquivo.
	 *
	 * @return void
	 */
	public function test_can_be_created_without_file_extensions() : void
	{
		$user = $this->user;

		$uri = route('admin.platforms.store');
		$data = Platform::factory()->raw();

		$response = $this->actingAs($user)->post($uri, $data);
		$response->assertRedirect();
	}


	/**
	 * Testa se o nome curto da plataforma deve ser única.
	 *
	 * @return void
	 */
	public function test_short_name_must_be_unique() : void
	{
		$user = $this->user;
		$platform = Platform::factory()->create();

		$uri = route('admin.platforms.store');
		$data = Platform::factory()->raw([ 'short_name' => $platform->short_name ]);

		$response = $this->actingAs($user)->post($uri, $data);
		$response->assertInvalid();
	}


	/**
	 * Testa se a plataforma pode ser modificada.
	 *
	 * @return void
	 */
	public function test_can_be_updated() : void
	{
		$user = $this->user;
		$platform = Platform::factory()->create();
		$newName = fake()->title();
		$newShortName = Str::random(8);

		$uri = route('admin.platforms.update', $platform);
		$data = [
			'name' 			=> $newName,
			'short_name'	=> $newShortName,
		];

		$response = $this->actingAs($user)->put($uri, $data);
		$response->assertRedirect();
	}


	/**
	 * Testa se o ícone pode ser alterado durante a atualização.
	 *
	 * @return void
	 */
	public function test_icon_can_change_on_update() : void
	{
		$this->setupFileSystem();

		$user = $this->user;
		$attributes = Platform::factory()->raw();
		$icon = $this->generateIcon();

		/** @var CreatorService */
		$creator = app()->make(CreatorService::class);
		$platform = $creator->fill($attributes)
			->setUploadedFile($icon)
			->save();

		$uri = route('admin.platforms.update', $platform);
		$data = [
			'icon'	=> $this->generateIcon(),
		];

		$response = $this->actingAs($user)->put($uri, $data);
		$response->assertRedirect();
		$this->fs->assertExists($platform->getFullFileName());
	}


	/**
	 * Testa se o nome do ícone pode ser alterado quando o nome
	 * curto da plataforma é alterado.
	 *
	 * @return void
	 */
	public function test_icon_name_can_change_on_short_name_update() : void
	{
		$this->setupFileSystem();

		$user = $this->user;
		$attributes = Platform::factory()->raw();
		$icon = $this->generateIcon();

		/** @var CreatorService */
		$creator = app()->make(CreatorService::class);
		$platform = $creator->fill($attributes)
			->setUploadedFile($icon)
			->save();

		$oldPath = $platform->getFullFileName();

		$uri = route('admin.platforms.update', $platform);
		$data = [
			'name'			=> $platform->name,
			'short_name'	=> Str::random(8),
		];

		$response = $this->actingAs($user)->put($uri, $data);
		$platform = Platform::find($platform->id);
		$newPath = $platform->getFullFileName();

		$response->assertRedirect();
		$this->fs->assertMissing($oldPath);
		$this->fs->assertExists($newPath);
	}


	/**
	 * Testa se ícon pode ser removido na modificação.
	 *
	 * @return void
	 */
	public function test_can_remove_icon_on_update() : void
	{
		$this->setupFileSystem();

		$user = $this->user;
		$attributes = Platform::factory()->raw();
		$icon = $this->generateIcon();

		/** @var CreatorService */
		$creator = app()->make(CreatorService::class);
		$platform = $creator->fill($attributes)
			->setUploadedFile($icon)
			->save();

		$iconPath = $platform->getFullFileName();

		/** @var EditorService */
		$editor = app()->make(EditorService::class, compact('platform'));
		$editor->mustDelete()->save();

		$this->fs->assertMissing($iconPath);
	}


	/**
	 * Testa se a plataforma pode ser removida.
	 *
	 * @return void
	 */
	public function test_can_be_deleted() : void
	{
		$this->setupFileSystem();

		$user = $this->user;
		$attributes = Platform::factory()->raw();
		$icon = $this->generateIcon();

		/** @var CreatorService */
		$creator = app()->make(CreatorService::class);
		$platform = $creator->fill($attributes)
			->setUploadedFile($icon)
			->save();

		$iconPath = $platform->getFullFileName();

		$uri = route('admin.platforms.destroy', $platform);
		$response = $this->actingAs($user)->delete($uri);

		$response->assertRedirect();
		$this->assertModelMissing($platform);
		$this->fs->assertMissing($iconPath);
	}


	/**
	 * Testa se as plataformas podem ser removidas, desvinculando,
	 * também, de suas extensões de arquivo.
	 *
	 * @return void
	 */
	public function test_can_be_deleted_and_detached() : void
	{
		$attributes = Platform::factory()->raw();
		$platform = Platform::factory()->withFileExtensions()->create();

		$deleter = app()->make(DeleterService::class, compact('platform'));
		$deleter->delete();

		$this->assertModelMissing($platform);
		$this->assertDatabaseCount('file_extension_platform', 0);
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
	 * Cria um nome aleatório para um ícone.
	 *
	 * @param integer $length
	 * @return string
	 */
	private function generateIconFileName(int $length = 16) : string
	{
		return Str::random($length) . '.png';
	}


	/**
	 * Cria um ícone de teste.
	 *
	 * @return UploadedFile
	 */
	private function generateIcon() : UploadedFile
	{
		return UploadedFile::fake()->image($this->generateIconFileName(), 32, 32);
	}
}
