<?php

declare(strict_types=1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\Interfaces\IUserDAO;
use Thunbolt\User\Interfaces\IUserEntity;
use Thunbolt\User\Interfaces\IUserRepository;

class StaticUserDAO implements IUserDAO {

	/** @var StaticUserRepository */
	private $repository;

	public function __construct(StaticUserList $userList) {
		$this->repository = new StaticUserRepository($userList);
	}

	public function merge(IUserEntity $model): void {
		// void
	}

	public function getRepository(): IUserRepository {
		return $this->repository;
	}

}
