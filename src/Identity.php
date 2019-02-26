<?php declare(strict_types = 1);

namespace Thunbolt\User;

use Nette;
use Thunbolt\User\Interfaces\IRoleEntity;
use Thunbolt\User\Interfaces\IUserDAO;
use Thunbolt\User\Interfaces\IUserEntity;

class Identity implements Nette\Security\IIdentity {

	/** @var int */
	private $id;

	/** @var IUserEntity */
	private $entity;

	/** @var IUserDAO */
	private $userDAO;

	public function __construct($id, ?IUserEntity $entity = null) {
		$this->setId($id);
		$this->entity = $entity;
	}

	/**
	 * @param IUserDAO $userDAO
	 */
	public function setUserDAO(IUserDAO $userDAO) {
		$this->userDAO = $userDAO;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;

		return $this;
	}

	public function hasEntity(): bool {
		return $this->getEntity() !== null;
	}

	public function getEntity(): ?IUserEntity {
		if (!$this->entity) {
			$this->entity = $this->userDAO->getRepository()->getUserById($this->getId());
		}

		return $this->entity;
	}

	public function getRoles(): array {
		if (!$this->getEntity() instanceof IRoleEntity) {
			throw new UserException('User entity must be instance of ' . IRoleEntity::class);
		}

		return $this->getEntity()->getRoles();
	}

	/************************* Magic **************************/

	public function __set(string $key, $value): void {
		$this->getEntity()->$key = $value;
	}

	public function &__get(string $key) {
		$get = $this->getEntity()->$key;

		return $get;
	}

	public function __isset(string $key): bool {
		return isset($this->getEntity()->$key);
	}

	public function __unset(string $name): void {
		unset($this->getEntity()->$name);
	}

	public function __call(string $name, array $args) {
		if ($this->getEntity()) {
			return call_user_func_array([$this->entity, $name], $args);
		}

		return null;
	}

	public function __sleep(): array {
		return ['id'];
	}

}
