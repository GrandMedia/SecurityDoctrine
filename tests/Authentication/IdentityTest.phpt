<?php declare(strict_types = 1);

namespace GrandMediaTests\SecurityDoctrine\Authentication;

use GrandMediaTests\SecurityDoctrine\Authentication\Mocks\Identity;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class IdentityTest extends \Tester\TestCase
{

	public function testVerify(): void
	{
		$identity = new Identity('foo', 'foo');

		Assert::true($identity->verify('foo'));
	}

	public function testChangePassword(): void
	{
		$identity = new Identity('foo', 'foo');
		$identity->changePassword('bar');

		Assert::true($identity->verify('bar'));
	}

}

(new IdentityTest())->run();
