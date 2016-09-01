<?php

namespace Thunbolt\User\Interfaces;

interface IRepository {

	/**
	 * @param int $id
	 * @return IEntity
	 */
	public function getUserById($id);

	/**
	 * @param mixed $value
	 * @return IEntity
	 */
	public function login($value);

}
