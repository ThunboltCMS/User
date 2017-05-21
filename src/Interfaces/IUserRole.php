<?php

declare(strict_types=1);

namespace Thunbolt\User\Interfaces;

interface IUserRole {

	/**
	 * @return bool
	 */
	public function isAdmin(): bool;

	/**
	 * @return string
	 */
	public function getName(): string;

}
