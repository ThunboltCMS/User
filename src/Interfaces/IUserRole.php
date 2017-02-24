<?php

namespace Thunbolt\User\Interfaces;

interface IUserRole {

	/**
	 * @return bool
	 */
	public function isAdmin();

	/**
	 * @return string
	 */
	public function getName();

}
