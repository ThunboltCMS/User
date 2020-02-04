<?php declare(strict_types = 1);

namespace Thunbolt\User\Interfaces;

interface IAccountRoles extends IAccount {

	public function getRoles(): array;

}
