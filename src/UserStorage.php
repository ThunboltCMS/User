<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Nette\Http\Session;
use Nette\Http;
use Nette\Security\IIdentity;
use Thunbolt\User\Interfaces\IUserDAO;

class UserStorage extends Http\UserStorage {

	/** @var Identity */
	private $identity;

	/** @var IUserDAO */
	private $userDAO;

	/**
	 * @param Session $sessionHandler
	 * @param IUserDAO $userDAO
	 */
	public function __construct(Session $sessionHandler, IUserDAO $userDAO) {
		parent::__construct($sessionHandler);

		$this->userDAO = $userDAO;
	}

	public function setIdentity(IIdentity $identity = NULL) {
		if ($identity instanceof Identity) {
			$this->identity = $identity;
		}

		return parent::setIdentity($identity);
	}

	/**
	 * Returns current user identity, if any.
	 *
	 * @return \Nette\Security\IIdentity|Identity
	 */
	public function getIdentity(): ?IIdentity {
		if (!$this->identity) {
			$identity = parent::getIdentity();

			if ($identity instanceof Identity) {
				$identity->setUserDAO($this->userDAO);
				$this->identity = $identity;
			}
		}

		return $this->identity;
	}

}
