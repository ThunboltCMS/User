<?php

declare(strict_types=1);

namespace Thunbolt\User\Interfaces;

interface IUserRepository {

	public function getUserById(int $id): ?IUserModel;

	/**
	 * @param mixed $value
	 * @return IUserModel
	 */
	public function login($value): ?IUserModel;

}
