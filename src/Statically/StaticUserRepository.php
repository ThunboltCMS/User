<?php

declare(strict_types=1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\Interfaces\IUserModel;
use Thunbolt\User\Interfaces\IUserRepository;

class StaticUserRepository implements IUserRepository {

	/** @var StaticUserList */
	private $userList;

	public function __construct(StaticUserList $userList) {
		$this->userList = $userList;
	}

	public function getUserById($id): ?IUserModel {
		return $this->userList->getById($id);
	}

	public function login($value): ?IUserModel {
		return $this->userList->getById($value);
	}

}
