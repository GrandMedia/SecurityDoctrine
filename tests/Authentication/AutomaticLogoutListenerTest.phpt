<?php declare(strict_types = 1);

namespace GrandMediaTests\SecurityDoctrine\Authentication;

use GrandMedia\Security\Authentication\AuthenticationManager;
use GrandMedia\SecurityDoctrine\Authentication\AutomaticLogoutListener;
use GrandMediaTests\SecurityDoctrine\Authentication\Mocks\Identity;
use GrandMediaTests\SecurityDoctrine\Authentication\Mocks\UserStorage;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class AutomaticLogoutListenerTest extends TestCase
{
	public function testCheck()
	{
		$userStorage = new UserStorage();
		$identity = new Identity('foo', 'foo');
		$userStorage->setAuthenticated(true);
		$userStorage->setIdentity($identity);
		$listener = new AutomaticLogoutListener(new AuthenticationManager($userStorage));

		$identity->deactivate();
		$listener->check();

		Assert::false($userStorage->isAuthenticated());
	}
}

(new AutomaticLogoutListenerTest())->run();
