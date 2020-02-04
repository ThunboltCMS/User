<?php declare(strict_types = 1);

namespace Thunbolt\User\Identity;

use Thunbolt\User\Interfaces\IAccount;

interface IIdentity extends \Nette\Security\IIdentity {

	/**
	 * @return IAccount
	 */
	public function getEntity();

}
