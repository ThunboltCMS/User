<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Thunbolt\User\Interfaces\IUserEntity;

interface IIdentity extends \Nette\Security\IIdentity {

	/**
	 * @return IUserEntity|null
	 */
	public function getEntity(): ?IUserEntity;

}
