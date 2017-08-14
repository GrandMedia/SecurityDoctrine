<?php declare(strict_types = 1);

namespace GrandMedia\SecurityDoctrine\DI;

use Contributte\EventDispatcher\DI\EventDispatcherExtension;
use Contributte\Events\Bridges\Application\DI\EventApplicationBridgeExtension;
use GrandMedia\Security\DI\SecurityExtension;
use GrandMedia\SecurityDoctrine\Authentication\AutomaticLogoutListener;
use Kdyby\Doctrine\DI\OrmExtension;
use Nette\Utils\AssertionException;

final class SecurityDoctrineExtension extends \Nette\DI\CompilerExtension implements \Kdyby\Doctrine\DI\IEntityProvider
{

	public function loadConfiguration(): void
	{
		$containerBuilder = $this->getContainerBuilder();

		$containerBuilder->addDefinition($this->prefix('automaticLogoutListener'))
			->setClass(AutomaticLogoutListener::class);
	}

	public function beforeCompile(): void
	{
		foreach ([
					 SecurityExtension::class,
					 OrmExtension::class,
					 EventDispatcherExtension::class,
					 EventApplicationBridgeExtension::class,
				 ] as $extension) {
			if (\count($this->compiler->getExtensions($extension)) === 0) {
				throw new AssertionException(\sprintf('Please register the required %s to Compiler.', $extension));
			}
		}
	}

	/**
	 * @return string[]
	 */
	public function getEntityMappings(): array
	{
		return [
			'GrandMedia\SecurityDoctrine\Authentication' => __DIR__ . '/../Authentication',
		];
	}

}
