<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Nette\Security;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;
use Nette\Security\IUserStorage;
use Thunbolt\User\Interfaces\IUserDAO;
use Thunbolt\User\Interfaces\IUserEntity;

/**
 * @property-read string $name
 */
class User extends Security\User {

	/** @var IUserDAO */
	private $userDAO;

	public function __construct(IUserStorage $storage, IUserDAO $userDAO, IAuthenticator $authenticator = NULL,
								IAuthorizator $authorizator = NULL) {
		parent::__construct($storage, $authenticator, $authorizator);

		$this->userDAO = $userDAO;
	}

	/************************* Own properties and methods **************************/

	/**
	 * @throws UserException
	 * @return IUserEntity
	 */
	public function getEntity() {
		$identity = $this->getIdentity();
		if (!$identity) {
			throw new UserException('User is not logged. Check first if user is logged.');
		}

		return $identity->getEntity();
	}

	/**
	 * @return bool
	 */
	public function isAdmin(): bool {
		return $this->isLoggedIn() && $this->getEntity()->isAdmin();
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->getEntity()->getName();
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getExtra(string $name) {
		return $this->getIdentity()->getExtra($name);
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function setExtra(string $name, $value): void {
		$this->getIdentity()->setExtra($name, $value);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasExtra(string $name): bool {
		if (!$this->getIdentity()) {
			return false;
		}

		return $this->getIdentity()->hasExtra($name);
	}

	/************************* User methods **************************/

	public function merge(): void {
		$this->userDAO->merge($this->getEntity());
	}

}
