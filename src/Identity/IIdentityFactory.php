<?php declare(strict_types = 1);

namespace Thunbolt\User\Identity;

use Thunbolt\User\Interfaces\IAccount;

interface IIdentityFactory {

	/**
	 * @param mixed $id
	 * @param IAccount $entity
	 * @return IIdentity
	 */
	public function create($id, $entity);

}
