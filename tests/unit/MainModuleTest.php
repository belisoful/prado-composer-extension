<?php

use PHPUnit\Framework\TestCase;
use Prado\Exceptions\TException;
use Prado\Prado;
use Prado\TApplication;
use Prado\Util\TPluginModule;
use Prado\Web\Services\TPageService;
use PradoComposerExtension\MainModule;

/**
 * Unit tests for {@see MainModule}.
 *
 * @author Brad Anderson <belisoful@icloud.com>
 */
class MainModuleTest extends TestCase
{
	/** @var MainModule the module under test */
	protected $module;

	/** @var TApplication the global test application */
	protected $app;

	/** @var mixed the application service before the test */
	protected $priorService;

	protected function setUp(): void
	{
		$this->app = Prado::getApplication();
		$this->priorService = $this->app->getService();
		$this->module = new MainModule();
	}

	protected function tearDown(): void
	{
		$this->app->detachEventHandler('onBeginRequest', [$this->module, 'attachPageServiceBehavior']);
		$this->app->setService($this->priorService);
		$this->module = null;
	}

	/**
	 * @return string the absolute path of the extension "src" directory.
	 */
	protected function getSrcPath()
	{
		return realpath(__DIR__ . '/../../src');
	}

	public function testConstruct()
	{
		$this->assertInstanceOf(TPluginModule::class, $this->module);
		$this->assertNull($this->module->getPropertyA());
	}

	public function testComposerBootstrap()
	{
		$composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
		$this->assertEquals('prado4-extension', $composer['type']);
		$this->assertEquals(MainModule::class, $composer['extra']['bootstrap']);
		$this->assertTrue(class_exists($composer['extra']['bootstrap']));
		$this->assertTrue(is_subclass_of($composer['extra']['bootstrap'], TPluginModule::class));
		$this->assertEquals(['PradoComposerExtension\\' => 'src'], $composer['autoload']['psr-4']);
		$this->assertArrayHasKey('pradosoft/prado', $composer['require']);
		$this->assertStringContainsString('4.3.3', $composer['require']['pradosoft/prado']);
	}

	public function testPluginPaths()
	{
		$this->assertEquals($this->getSrcPath(), $this->module->getPluginPath());
		$this->assertEquals($this->getSrcPath() . DIRECTORY_SEPARATOR . 'Pages', $this->module->getPluginPagesPath());
		$this->assertEquals(TPluginModule::PAGES_DIRECTORY, $this->module->getRelativePagesPath());
		$this->assertEquals($this->getSrcPath() . DIRECTORY_SEPARATOR . 'errorMessages.txt', $this->module->getErrorFile());
		$this->assertFileExists($this->module->getErrorFile());
	}

	public function testInit()
	{
		$this->assertFalse($this->app->hasEventHandler('onBeginRequest'));

		$this->module->init(null);

		$this->assertTrue($this->app->hasEventHandler('onBeginRequest'));
		$this->assertTrue($this->app->getEventHandlers('onBeginRequest')->contains([$this->module, 'attachPageServiceBehavior']));

		// Initializing the module has registered the extension error messages.
		$e = new TException('my_error_condition');
		$this->assertEquals('Prado Composer Extension threw an exception', $e->getMessage());

		// Unknown error codes are returned as their code.
		$e = new TException('unknown_error_code_for_test');
		$this->assertEquals('unknown_error_code_for_test', $e->getMessage());
	}

	public function testInitWithoutPages()
	{
		$this->module->setPluginPath(__DIR__);
		$this->assertFalse($this->module->getPluginPagesPath());
		$this->assertNull($this->module->getErrorFile());

		$this->module->init(null);

		// TPluginModule::init() compares the pages path against null, so the
		// onBeginRequest handler is attached even when getPluginPagesPath() is false.
		$this->assertTrue($this->app->hasEventHandler('onBeginRequest'));
	}

	public function testErrorMessagesComments()
	{
		$this->module->init(null);
		new TException('my_error_condition');

		$property = new ReflectionProperty(TException::class, '_messageCache');
		$property->setAccessible(true);
		$cache = $property->getValue();

		$this->assertArrayHasKey($this->module->getErrorFile(), $cache);
		$this->assertEquals(['my_error_condition' => 'Prado Composer Extension threw an exception'], $cache[$this->module->getErrorFile()]);
	}

	public function testAttachPageServiceBehavior()
	{
		$this->module->init(null);

		$service = new TPageService();
		$this->app->setService($service);
		$this->assertFalse($service->hasEventHandler('onAdditionalPagePaths'));

		$this->module->attachPageServiceBehavior($this->app, null);
		$this->assertTrue($service->hasEventHandler('onAdditionalPagePaths'));
		$this->assertTrue($service->getEventHandlers('onAdditionalPagePaths')->contains([$this->module, 'additionalPagePaths']));

		// The extension page is found by the additional page path.
		$path = $service->onAdditionalPagePaths('Example');
		$this->assertEquals([$this->getSrcPath() . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . 'Example'], $path);
		$this->assertFileExists($path[0] . TPageService::PAGE_FILE_EXT);
	}

	public function testAttachPageServiceBehaviorWithoutPageService()
	{
		$this->app->setService(null);
		$this->module->attachPageServiceBehavior($this->app, null);
		$this->assertNull($this->app->getService());
	}

	public function testAdditionalPagePaths()
	{
		$service = new TPageService();
		$pages = $this->getSrcPath() . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR;
		$this->assertEquals($pages . 'Example', $this->module->additionalPagePaths($service, 'Example'));
		$this->assertEquals($pages . 'Sub' . DIRECTORY_SEPARATOR . 'Page', $this->module->additionalPagePaths($service, 'Sub.Page'));
	}

	public function testPropertyA()
	{
		$this->assertNull($this->module->getPropertyA());

		$this->module->setPropertyA('value1');
		$this->assertEquals('value1', $this->module->getPropertyA());

		$this->module->setPropertyA(5);
		$this->assertSame('5', $this->module->getPropertyA());

		$this->module->setPropertyA(true);
		$this->assertSame('true', $this->module->getPropertyA());

		$this->module->setPropertyA(null);
		$this->assertSame('', $this->module->getPropertyA());

		// The property is accessible through the TComponent property system.
		$this->module->PropertyA = 'value2';
		$this->assertEquals('value2', $this->module->PropertyA);
		$this->assertTrue($this->module->canGetProperty('PropertyA'));
		$this->assertTrue($this->module->canSetProperty('PropertyA'));
	}
}
