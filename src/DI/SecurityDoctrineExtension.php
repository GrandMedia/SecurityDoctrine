<?php declare(strict_types = 1);

namespace GrandMedia\SecurityDoctrine\DI;

use GrandMedia\Security\DI\SecurityExtension;
use GrandMedia\SecurityDoctrine\Authentication\AutomaticLogoutListener;
use Kdyby\Doctrine\DI\IEntityProvider;
use Kdyby\Doctrine\DI\OrmExtension;
use Kdyby\Events\DI\EventsExtension;
use Nette\DI\CompilerExtension;
use Nette\Utils\AssertionException;

final class SecurityDoctrineExtension extends CompilerExtension implements IEntityProvider
{
	public function loadConfiguration()
	{
		$containerBuilder = $this->getContainerBuilder();

		$containerBuilder->addDefinition($this->prefix('automaticLogoutListener'))
			->setClass(AutomaticLogoutListener::class)
			->addTag(EventsExtension::TAG_SUBSCRIBER);
	}

	public function beforeCompile()
	{
		foreach ([SecurityExtension::class, OrmExtension::class, EventsExtension::class] as $extension) {
			if (empty($extensions = $this->compiler->getExtensions($extension))) {
				throw new AssertionException("Please register the required $extension to Compiler.");
			}
		}
	}

	public function getEntityMappings(): array
	{
		return [
			'GrandMedia\SecurityDoctrine\Authentication' => __DIR__ . '/../Authentication',
		];
	}
}
