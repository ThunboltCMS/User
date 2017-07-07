<?php

declare(strict_types=1);

namespace Thunbolt\User\Interfaces;

interface IUserRepository {

	/**
	 * @param mixed $id
	 * @return null|IUserModel
	 */
	public function getUserById($id): ?IUserModel;

	/**
	 * @param mixed $value
	 * @return null|IUserModel
	 */
	public function login($value): ?IUserModel;

}
