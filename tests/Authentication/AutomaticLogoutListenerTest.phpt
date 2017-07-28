<?php declare(strict_types = 1);

namespace GrandMediaTests\SecurityDoctrine\Authentication;

use GrandMedia\Security\Authentication\AuthenticationManager;
use GrandMedia\SecurityDoctrine\Authentication\AutomaticLogoutListener;
use GrandMediaTests\SecurityDoctrine\Authentication\Mocks\Identity;
use GrandMediaTests\SecurityDoctrine\Authentication\Mocks\UserStorage;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class AutomaticLogoutListenerTest extends \Tester\TestCase
{

	public function testCheck(): void
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
