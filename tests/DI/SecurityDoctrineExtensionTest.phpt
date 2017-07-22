<?php declare(strict_types = 1);

namespace GrandMediaTests\SecurityDoctrine\DI;

use GrandMedia\SecurityDoctrine\Authentication\AutomaticLogoutListener;
use Nette\Configurator;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class SecurityDoctrineExtensionTest extends TestCase
{
	public function testFunctionality()
	{
		$container = $this->createContainer(null);

		$automaticLogoutListener = $container->getByType(AutomaticLogoutListener::class);
		Assert::true($automaticLogoutListener instanceof AutomaticLogoutListener);
	}

	private function createContainer(?string $configFile): Container
	{
		$config = new Configurator();

		$config->setTempDirectory(TEMP_DIR);
		$config->addConfig(__DIR__ . '/config/reset.neon');
		if ($configFile !== null) {
			$config->addConfig(__DIR__ . "/config/$configFile.neon");
		}

		return $config->createContainer();
	}
}

(new SecurityDoctrineExtensionTest())->run();
