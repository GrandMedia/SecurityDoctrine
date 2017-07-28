<?php declare(strict_types = 1);

namespace GrandMedia\SecurityDoctrine\Authentication;

use Doctrine\ORM\EntityNotFoundException;
use GrandMedia\Security\Authentication\AuthenticationManager;

final class AutomaticLogoutListener implements \Kdyby\Events\Subscriber
{

	/** @var \GrandMedia\Security\Authentication\AuthenticationManager */
	private $authenticationManager;

	public function __construct(AuthenticationManager $authenticationManager)
	{
		$this->authenticationManager = $authenticationManager;
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

	/**
	 * @return string[]
	 */
	public function getSubscribedEvents(): array
	{
		return [
			'Nette\Application\Application::onStartup' => 'check',
		];
	}

}
