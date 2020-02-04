<?php declare(strict_types = 1);

namespace Thunbolt\User\Identity;

use LogicException;
use Nette\SmartObject;
use Thunbolt\User\Interfaces\IAccount;
use Thunbolt\User\Interfaces\IAccountRoles;

final class Identity implements IIdentity {

	use SmartObject;

	/** @var mixed */
	private $id;

	/** @var IAccount */
	private $entity;

	public function __construct($id, IAccount $entity) {
		$this->id = $id;
		$this->entity = $entity;
	}

	public function getId() {
		return $this->id;
	}

	public function getRoles(): array {
		if ($this->entity instanceof IAccountRoles) {
			return $this->entity->getRoles();
		}

		return [];
	}

	public function getEntity(): IAccount {
		return $this->entity;
	}

	// magic

	public function __sleep(): array {
		return ['id'];
	}

	public function __set(string $key, $value): void {
		throw new LogicException('Cannot set values in Identity');
	}

	public function &__get(string $key) {
		return $this->entity->$key;
	}

	public function __isset(string $key): bool {
		return isset($this->entity->$key);
	}

	public function __call(string $name, array $args) {
		return $this->entity->$name(...$args);
	}

}
