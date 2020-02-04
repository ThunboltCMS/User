<?php declare(strict_types = 1);

namespace Thunbolt\User;

use Nette\Security;
use Thunbolt\User\Exceptions\UserIsNotLoggedInException;
use Thunbolt\User\Interfaces\IAccount;
use Thunbolt\User\Identity\IIdentity;

/**
 * @method IIdentity getIdentity()
 */
class User extends Security\User {

	/**
	 * @return IAccount
	 */
	public function getEntity() {
		if (!$this->isLoggedIn() || !$this->getIdentity()) {
			throw new UserIsNotLoggedInException();
		}

		return $this->getIdentity()->getEntity();
	}

	/**
	 * @return IAccount|null
	 */
	public function getNullableEntity() {
		if (!$this->isLoggedIn()) {
			return null;
		}

		$identity = $this->getIdentity();
		if (!$identity) {
			return null;
		}
		return $identity->getEntity();
	}

}
