<?php

declare(strict_types=1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\Interfaces\IUserEntity;
use Thunbolt\User\Interfaces\IUserRepository;

class StaticUserRepository implements IUserRepository {

	/** @var StaticUserList */
	private $userList;

	public function __construct(StaticUserList $userList) {
		$this->userList = $userList;
	}

	public function getUserById($id): ?IUserEntity {
		return $this->userList->getById($id);
	}

	public function login($value): ?IUserEntity {
		return $this->userList->getById($value);
	}

}
