<?php declare(strict_types = 1);

namespace GrandMediaTests\SecurityDoctrine\Authentication\Mocks;

use Doctrine\ORM\EntityNotFoundException;

final class Identity extends \GrandMedia\SecurityDoctrine\Authentication\Identity
{

	/** @var string */
	private $name;

	/** @var bool */
	private $entityFound;

	public function __construct(
		string $name,
		string $password,
		string $role = '',
		bool $entityFound = true
	)
	{
		$this->name = $name;

		parent::__construct($password, $role);

		$this->entityFound = $entityFound;
	}

	public function getId(): string
	{
		return $this->name;
	}

	public function getName(): string
	{
		$this->loadProxy();

		return $this->name;
	}

	public function verify(string $password): bool
	{
		$this->loadProxy();

		return parent::verify($password);
	}

	public function isActive(): bool
	{
		$this->loadProxy();

		return parent::isActive();
	}

	public function getRoles(): array
	{
		$this->loadProxy();

		return parent::getRoles();
	}

	private function loadProxy(): void
	{
		if (!$this->entityFound) {
			throw new EntityNotFoundException();
		}
	}

}
