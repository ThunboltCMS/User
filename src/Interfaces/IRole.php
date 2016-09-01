<?php

namespace Thunbolt\User\Interfaces;

interface IRole {

	/**
	 * @return bool
	 */
	public function isAdmin();

	/**
	 * @return string
	 */
	public function getName();

}
