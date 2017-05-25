<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Kdyby\Doctrine\EntityManager;
use Nette\Security;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;
use Nette\Security\IUserStorage;
use Thunbolt\User\Interfaces\IEntity;
use Thunbolt\User\Interfaces\IUserModel;

/**
 * @property string $avatar
 * @property string $name
 * @property string $primary
 * @property string $roleName
 */
class User extends Security\User implements IUser {

	/** @var EntityManager */
	private $em;

	public function __construct(IUserStorage $storage, EntityManager $em, IAuthenticator $authenticator = NULL,
								IAuthorizator $authorizator = NULL) {
		parent::__construct($storage, $authenticator, $authorizator);

		$this->em = $em;
	}

	/************************* Own properties and methods **************************/

	/**
	 * @throws UserException
	 * @return IUserModel
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
	public function getAvatar(): string {
		return $this->getEntity()->getAvatar();
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->getEntity()->getName();
	}

	/**
	 * @return string
	 */
	public function getRoleName(): ?string {
		if (!$this->getEntity()->getRole()) {
			return NULL;
		}

		return $this->getEntity()->getRole()->getName();
	}

	public function getRegistrationDate(): ?\DateTime {
		return $this->getEntity()->getRegistrationDate();
	}

	/************************* User methods **************************/

	public function merge(): void {
		$this->em->merge($this->getEntity());
		$this->em->flush();
	}

	/**
	 * @param string $resource
	 * @param string $privilege
	 * @return bool
	 */
	public function isAllowed($resource = IAuthorizator::ALL, $privilege = IAuthorizator::ALL): bool {
		if (!$this->isLoggedIn()) {
			return FALSE;
		}
		if (strpos($resource, ':')) {
			list($resource, $privilege) = explode(':', $resource);
		}

		return $this->getAuthorizator()->isAllowed($this->getEntity()->getRole(), $resource, $privilege);
	}

}
