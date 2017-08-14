<?php declare(strict_types = 1);

namespace GrandMedia\SecurityDoctrine\Authentication;

use Contributte\Events\Bridges\Application\Event\StartupEvent;
use Doctrine\ORM\EntityNotFoundException;
use GrandMedia\Security\Authentication\AuthenticationManager;

final class AutomaticLogoutListener implements \Contributte\EventDispatcher\EventSubscriber
{

	/** @var \GrandMedia\Security\Authentication\AuthenticationManager */
	private $authenticationManager;

	public function __construct(AuthenticationManager $authenticationManager)
	{
		$this->authenticationManager = $authenticationManager;
	}

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			StartupEvent::NAME => 'check',
		];
	}

	public function check(): void
	{
		try {
			/** @var \GrandMedia\SecurityDoctrine\Authentication\Identity $identity */
			$identity = $this->authenticationManager->getIdentity();
			if ($identity instanceof Identity && !$identity->isActive()) {
				$this->authenticationManager->logout();
			}
		} catch (EntityNotFoundException $ex) {
			$this->authenticationManager->logout(true);
		}
	}

}
