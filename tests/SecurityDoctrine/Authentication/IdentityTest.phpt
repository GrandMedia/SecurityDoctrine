<?php declare(strict_types = 1);

namespace GrandMediaTests\SecurityDoctrine\Authentication;

use GrandMediaTests\SecurityDoctrine\Authentication\Mocks\Identity;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class IdentityTest extends \Tester\TestCase
{

	private const PASSWORD = 'foo';
	private const ROLE = 'role';

	public function testVerify(): void
	{
		$identity = $this->createIdentity();

		Assert::true($identity->verify(self::PASSWORD));
		Assert::false($identity->isPasswordChanged());
	}

	public function testChangePassword(): void
	{
		$identity = $this->createIdentity();

		$identity->changePassword('bar');
		Assert::true($identity->verify('bar'));
		Assert::true($identity->isPasswordChanged());
	}

	public function testActivate(): void
	{
		$identity = $this->createIdentity();

		Assert::true($identity->isActive());

		$identity->deactivate();
		Assert::false($identity->isActive());

		$identity->activate();
		Assert::true($identity->isActive());
	}

	public function testGetRoles(): void
	{
		$identity = $this->createIdentity();

		Assert::equal([self::ROLE], $identity->getRoles());

		Assert::equal([], (new Identity('1', self::PASSWORD, ''))->getRoles());
	}

	private function createIdentity(): Identity
	{
		return new Identity('1', self::PASSWORD, self::ROLE);
	}

}

(new IdentityTest())->run();
