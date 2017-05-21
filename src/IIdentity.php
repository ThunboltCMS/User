<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Thunbolt\User\Interfaces\IEntity;

interface IIdentity extends \Nette\Security\IIdentity {

	/**
	 * @return IEntity|\Model\User
	 */
	public function getEntity();

}
