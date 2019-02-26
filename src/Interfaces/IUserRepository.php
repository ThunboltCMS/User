<?php declare(strict_types = 1);

namespace Thunbolt\User\Interfaces;

interface IUserRepository {

	/**
	 * @param mixed $id
	 * @return null|IUserEntity
	 */
	public function getUserById($id): ?IUserEntity;

	/**
	 * @param mixed $value
	 * @return null|IUserEntity
	 */
	public function login($value): ?IUserEntity;

}
