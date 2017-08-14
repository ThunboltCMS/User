<?php

declare(strict_types=1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\Interfaces\IUserEntity;
use Thunbolt\User\Interfaces\IUserRole;

class StaticUserEntity implements IUserEntity {

	/** @var array */
	private $data;

	public function __construct(array $data) {
		$this->data = $data;
	}

	public function setPassword(string $password): void {
		// void
	}

	public function getPassword(): string {
		return $this->data['password'];
	}

	public function getId() {
		return $this->data['id'];
	}

	public function getName(): string {
		return $this->data['name'];
	}

	public function isAdmin(): bool {
		return $this->data['admin'];
	}

}
