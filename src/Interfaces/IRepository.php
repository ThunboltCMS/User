<?php

namespace Thunbolt\User\Interfaces;

interface IRepository {

	/**
	 * @param int $id
	 * @return IUser
	 */
	public function getUserById($id);

	/**
	 * @param mixed $value
	 * @return IUser
	 */
	public function login($value);

}
