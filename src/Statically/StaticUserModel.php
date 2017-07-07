<?php

declare(strict_types=1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\Interfaces\IUserModel;
use Thunbolt\User\Interfaces\IUserRole;

class StaticUserModel implements IUserModel {

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

	public function getRole(): ?IUserRole {
		return NULL;
	}

	public function getName(): string {
		return $this->data['name'];
	}

	public function getAvatar(): ?string {
		return $this->data['avatar'];
	}

	public function isAdmin(): bool {
		return $this->data['admin'];
	}

	public function getRegistrationDate(): ?\DateTime {
		return $this->data['registration'];
	}

}
