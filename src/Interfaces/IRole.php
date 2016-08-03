<?php

namespace Thunbolt\User\Interfaces;

interface IRole {

	/**
	 * @return bool
	 */
	public function isAdmin();

	/**
	 * @return bool
	 */
	public function isSuperAdmin();

	/**
	 * @return string
	 */
	public function getName();

}
