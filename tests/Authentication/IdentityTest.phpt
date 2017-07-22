<?php declare(strict_types = 1);

namespace GrandMediaTests\SecurityDoctrine\Authentication;

use GrandMediaTests\SecurityDoctrine\Authentication\Mocks\Identity;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

final class IdentityTest extends TestCase
{
	public function testVerify()
	{
		$identity = new Identity('foo', 'foo');

		Assert::true($identity->verify('foo'));
	}

	public function testChangePassword()
	{
		$identity = new Identity('foo', 'foo');
		$identity->changePassword('bar');

		Assert::true($identity->verify('bar'));
	}
}

(new IdentityTest())->run();
