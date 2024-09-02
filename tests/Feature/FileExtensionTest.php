<?php

namespace Tests\Feature;

use App\Models\FileExtension;
use App\Services\FileExtension\CreatorService;
use App\Services\FileExtension\DeleterService;
use App\Services\FileExtension\EditorService;
use App\StorePublicFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\CreatesAdminUser;
use Tests\FakeFileSystem;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;


class FileExtensionTest extends TestCase
{
	use RefreshDatabase;
	use FakeFileSystem;
	use CreatesAdminUser;
	use StorePublicFiles;


    /**
     * Testa se o caminho do ícone da extensão está correto.
     */
    public function test_icon_path_is_correct() : void
    {
		$attributes = FileExtension::factory()->raw();
		$expected = Storage::url("extension-icon/{$attributes['extension']}.png");
		$fileExtension = FileExtension::create([
			'name'		=> $attributes['name'],
			'extension'	=> $attributes['extension'],
			'icon_path'	=> "{$attributes['extension']}.png",
		]);

		assertSame($expected, $fileExtension->icon);
    }


	/**
	 * Testa se está usando a imagem padrão.
	 *
	 * @return void
	 */
	public function test_using_default_icon() : void
	{
		$fileExtension = FileExtension::factory()->create();
		$expected = Storage::url($fileExtension->getDefaultFileName());

		assertSame($expected, $fileExtension->icon);
	}


	/**
	 * Testa se a extensão de arquivo pode ser criada sem ícone.
	 *
	 * @return void
	 */
	public function test_can_be_created_without_icon() : void
	{
		$user = $this->user;
		$data = FileExtension::factory()->raw();
		$response = $this->actingAs($user)->post(route('admin.file-extensions.store'), $data);

		$this->assertAuthenticated();
		$response->assertRedirectToRoute('admin.file-extensions.index');
	}


	/**
	 * Testa se a extensão de arquivo pode ser criada fazendo upload
	 * do ícone.
	 *
	 * @return void
	 */
	public function test_can_be_created_with_icon() : void
	{
		$this->setupFileSystem();

		$user = $this->user;
		$fs = $this->fs;
		$attributes = FileExtension::factory()->raw();

		$data = array_merge($attributes, [
			'icon'	=> $this->generateFakeIcon(),
		]);

		$this->actingAs($user)->post(route('admin.file-extensions.store'), $data);
		$this->assertAuthenticated();
		$fs->assertExists("extension-icon/{$attributes['extension']}.gif");
	}


	/**
	 * Testa se a extensão de arquivo pode ser alterada.
	 *
	 * @return void
	 */
	public function test_can_be_updated() : void
	{
		$user = $this->user;
		$fileExtension = FileExtension::factory()->create();

		$uri = route('admin.file-extensions.update', $fileExtension);
		$data = FileExtension::factory()->raw();
		$response = $this->actingAs($user)->put($uri, $data);

		$this->assertAuthenticated();
		$response->assertRedirectToRoute('admin.file-extensions.index');
	}


	/**
	 * Testa se as extensões não devem ser duplicadas.
	 *
	 * @return void
	 */
	public function test_cannot_duplicate_extension() : void
	{
		$user = $this->user;
		$extA = FileExtension::factory()->create();
		$extB = FileExtension::factory()->create();

		$uri = route('admin.file-extensions.update', $extA);
		$data = [
			'name'		=> $extA->name,
			'extension'	=> $extB->extension,
		];

		$response = $this->actingAs($user)->put($uri, $data);

		$this->assertAuthenticated();
		$response->assertInvalid();
	}


	/**
	 * Testa se o ícone pode ser adicionado ao ser modificado.
	 *
	 * @return void
	 */
	public function test_add_icon_on_update() : void
	{
		$this->setupFileSystem();

		$fileExtension = FileExtension::factory()->create();
		$upload = $this->generateFakeIcon();

		$this->editorService($fileExtension)
			->setUploadedFile($upload)
			->save();

		$this->fs->assertExists($fileExtension->getFullFileName());
	}


	/**
	 * Testa se o ícone deve ser alterado dutante a modificação.
	 * Isto quer dizer que, ao trocar de extensão, o ícone antigo
	 * deve ser deletado para que seja criado um novo ícone.
	 *
	 * @return void
	 */
	public function test_change_icon_on_update() : void
	{
		$this->setupFileSystem();

		$fs = $this->fs;

		$attributes = FileExtension::factory()->raw();
		$oldIcon = $this->generateFakeIcon();
		$newIcon = $this->generateFakeIcon();

		$creator = $this->creatorService();
		$fileExtension = $creator->fill($attributes)->setUploadedFile($oldIcon)->save();
		$oldPath = $fileExtension->getFullFileName();

		$attributes['extension'] = Str::limit(fake()->fileExtension(), 3, '');

		$editor = $this->editorService($fileExtension);
		$editor->fill($attributes)->setUploadedFile($newIcon)->save();
		$newPath = $fileExtension->getFullFileName();

		$fs->assertMissing($oldPath);
		$fs->assertExists($newPath);
	}


	/**
	 * Testa se o arquivo deve ser renomeado quando a extensão é modificada.
	 *
	 * @return void
	 */
	public function test_file_extension_must_rename_file_on_update() : void
	{
		$this->setupFileSystem();

		$fs = $this->fs;

		$attributes = FileExtension::factory()->raw();
		$icon = $this->generateFakeIcon();
		$creator = $this->creatorService();
		$fileExtension = $creator->fill($attributes)->setUploadedFile($icon)->save();
		$oldPath = $fileExtension->getFullFileName();

		$extension = Str::limit(fake()->fileExtension(), 3, '');

		$editor = $this->editorService($fileExtension);
		$editor->fill(compact('extension'))->save();

		$newPath = $fileExtension->getFullFileName();
		$fs->assertMissing($oldPath);
		$fs->assertExists($newPath);
	}


	/**
	 * Testa se o ícone deve ser removido quando a extensão
	 * de arquivo sofrer uma alteração onde não foi definido
	 * nenhum ícone novo.
	 *
	 * @return void
	 */
	public function test_remove_icon_on_update() : void
	{
		$this->setupFileSystem();

		$fs = $this->fs;

		$attributes = FileExtension::factory()->raw();
		$upload = $this->generateFakeIcon();

		$creator = $this->creatorService();
		$fileExtension = $creator->fill($attributes)->setUploadedFile($upload)->save();
		$file = $fileExtension->getFullFileName();

		$attributes['extension'] = Str::limit(fake()->fileExtension(), 3, '');

		$editor = $this->editorService($fileExtension);
		$editor->fill($attributes)->mustDelete()->save();

		$fs->assertMissing($file);
	}


	/**
	 * Testa se a extensão de arquivo pode ser excluída.
	 *
	 * @return void
	 */
	public function test_can_be_deleted() : void
	{
		$user = $this->user;
		$fileExtension = FileExtension::factory()->create();

		$uri = route('admin.file-extensions.destroy', $fileExtension);

		$response = $this->actingAs($user)->delete($uri);
		$response->assertRedirect();
	}


	/**
	 * Testa se o ícone deve ser removido quando a extensão de
	 * arquivo é deletada.
	 *
	 * @return void
	 */
	public function test_remove_icon_on_delete() : void
	{
		$this->setupFileSystem();

		$fs = $this->fs;

		$attributes = FileExtension::factory()->raw();
		$upload = $this->generateFakeIcon();

		$creator = $this->creatorService();
		$fileExtension = $creator->fill($attributes)->setUploadedFile($upload)->save();
		$file = $fileExtension->getFullFileName();

		$deleter = app(DeleterService::class, compact('fileExtension'));
		$deleted = $deleter->delete();

		assertTrue($deleted);
		$fs->assertMissing($file);
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
	 * Recebe um nome aleatório de ícone.
	 *
	 * @return string
	 */
	private function randomIconName() : string
	{
		return fake()->streetName() . '.png';
	}


	/**
	 * Cria um ícone aleatório.
	 *
	 * @param string|null $filename
	 * @return UploadedFile
	 */
	private function generateFakeIcon(?string $filename = null) : UploadedFile
	{
		$filename ??= $this->randomIconName();
		return UploadedFile::fake()->image($filename, 16, 16);
	}


	/**
	 * Gera um serviço de criação de extensão de arquivo.
	 *
	 * @return CreatorService
	 */
	private function creatorService() : CreatorService
	{
		return app(CreatorService::class);
	}


	/**
	 * Gera um serviço de edição de extensão de arquivo.
	 *
	 * @param FileExtension $fileExtension
	 * @return EditorService
	 */
	private function editorService(FileExtension $fileExtension) : EditorService
	{
		return app(EditorService::class, compact('fileExtension'));
	}
}
