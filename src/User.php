<?php declare(strict_types = 1);

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

	public function __construct(IUserStorage $storage, IUserDAO $userDAO, ?IAuthenticator $authenticator = null,
								?IAuthorizator $authorizator = null) {
		parent::__construct($storage, $authenticator, $authorizator);

		$this->userDAO = $userDAO;
	}

	/************************* Own properties and methods **************************/

	/**
	 * @return IUserEntity
	 * @throws UserException
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

	public function isAllowedResource($resource = IAuthorizator::ALL): bool {
		foreach ($this->getRoles() as $role) {
			if ($this->getAuthorizator()->isAllowedResource($role, $resource)) {
				return true;
			}
		}

		return false;
	}

	public function isAllowedSource($resource = IAuthorizator::ALL, $privilege = IAuthorizator::ALL, $source): bool {
		foreach ($this->getRoles() as $role) {
			if ($this->getAuthorizator()
				->isAllowedSource($role, $resource, $privilege, $this->isLoggedIn() ? $this->getEntity() : null, $source)) {
				return true;
			}
		}

		return false;
	}

	/************************* User methods **************************/

	public function merge(): void {
		$this->userDAO->merge($this->getEntity());
	}

}
