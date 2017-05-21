<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Nette;
use Thunbolt\User\Interfaces\IEntity;

class Identity extends Nette\Object implements Nette\Security\IIdentity {

	/** @var IEntity */
	private $entity;

	/** @var int */
	private $id;

	public function __construct(int $id, IEntity $entity = NULL) {
		$this->setId($id);
		$this->entity = $entity;
	}

	/**
	 * Sets the ID of user.
	 * @param int
	 * @return self
	 */
	public function setId(int $id) {
		$this->id = $id;

		return $this;
	}

	/**
	 * Returns the ID of user.
	 *
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * Returns a list of roles that the user is a member of.
	 *
	 * @return array
	 */
	public function getRoles(): array {
		return [$this->entity->getRole()];
	}

	/**
	 * @return IEntity|\Model\User
	 */
	public function getEntity() {
		return $this->entity;
	}

	/**
	 * Sets user data value.
	 *
	 * @param  string  property name
	 * @param  mixed   property value
	 * @return void
	 */
	public function __set(string $key, $value) {
		$this->entity->$key = $value;
	}

	/**
	 * Returns user data value.
	 *
	 * @param  string  property name
	 * @return mixed
	 */
	public function &__get(string $key) {
		$get = $this->entity->$key;

		return $get;
	}

	/**
	 * Is property defined?
	 *
	 * @param  string  property name
	 * @return bool
	 */
	public function __isset(string $key) {
		return isset($this->entity->$key);
	}

	/**
	 * Removes property.
	 *
	 * @param  string  property name
	 * @return void
	 * @throws Nette\MemberAccessException
	 */
	public function __unset(string $name) {
		unset($this->entity->$name);
	}

	/**
	 * Calls method from entity
	 *
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	public function __call(string $name, array $args) {
		if ($this->entity) {
			return call_user_func_array([$this->entity, $name], $args);
		}
	}

	/**
	 * @return array
	 */
	public function __sleep(): array {
		return ['id'];
	}

}
