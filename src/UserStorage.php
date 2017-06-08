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

	/**
	 * Is this user authenticated and exists in db?
	 *
	 * @return bool
	 */
	public function isAuthenticated(): bool {
		$authenticated = parent::isAuthenticated();

		if ($authenticated && $this->getIdentity() instanceof Identity && !$this->getIdentity()->getEntity()) { // User not exists in DB
			$this->setAuthenticated(FALSE);
			$this->setIdentity(NULL);

			return FALSE;
		}

		return $authenticated;
	}

	public function setIdentity(IIdentity $identity = NULL) {
		if ($identity instanceof Identity && $identity->getEntity()) {
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
		if ($this->identity) {
			return $this->identity;
		}
		$identity = parent::getIdentity();

		if ($identity instanceof Identity) {
			$this->identity = new Identity($identity->getId(), $this->userDAO->getRepository()->getUserById($identity->getId()));
		}

		return $this->identity;
	}

}
