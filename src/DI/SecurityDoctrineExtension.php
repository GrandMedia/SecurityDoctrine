<?php declare(strict_types = 1);

namespace GrandMedia\SecurityDoctrine\DI;

use GrandMedia\Security\DI\SecurityExtension;
use GrandMedia\SecurityDoctrine\Authentication\AutomaticLogoutListener;
use Kdyby\Doctrine\DI\OrmExtension;
use Kdyby\Events\DI\EventsExtension;
use Nette\Utils\AssertionException;

final class SecurityDoctrineExtension extends \Nette\DI\CompilerExtension implements \Kdyby\Doctrine\DI\IEntityProvider
{

	public function loadConfiguration(): void
	{
		$containerBuilder = $this->getContainerBuilder();

		$containerBuilder->addDefinition($this->prefix('automaticLogoutListener'))
			->setClass(AutomaticLogoutListener::class)
			->addTag(EventsExtension::TAG_SUBSCRIBER);
	}

	public function beforeCompile(): void
	{
		foreach ([SecurityExtension::class, OrmExtension::class, EventsExtension::class] as $extension) {
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
