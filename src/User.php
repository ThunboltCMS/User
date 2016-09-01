<?php

namespace Thunbolt\User;

use Kdyby\Doctrine\EntityManager;
use Nette\Security;
use Nette\Security\IAuthenticator;
use Nette\Security\IAuthorizator;
use Nette\Security\IUserStorage;
use Thunbolt\User\Interfaces\IEntity;

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
	 * @return \Model\User|IEntity
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
	public function isAdmin() {
		return $this->isLoggedIn() && $this->getEntity()->isAdmin();
	}

	/**
	 * @return string
	 */
	public function getAvatar() {
		return $this->getEntity()->getAvatar();
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->getEntity()->getName();
	}

	/**
	 * @return bool
	 */
	public function isMonitoring() {
		return $this->getEntity()->isMonitoring();
	}

	/**
	 * @return string
	 */
	public function getRoleName() {
		if (!$this->getEntity()->getRole()) {
			return NULL;
		}

		return $this->getEntity()->getRole()->getName();
	}

	/**
	 * @return \DateTime|null|void
	 */
	public function getRegistrationDate() {
		return $this->getEntity()->getRegistrationDate();
	}

	/************************* User methods **************************/

	public function merge() {
		$this->em->merge($this->getEntity());
		$this->em->flush();
	}

	/**
	 * @param string $resource
	 * @param string $privilege
	 * @return bool
	 */
	public function isAllowed($resource = IAuthorizator::ALL, $privilege = IAuthorizator::ALL) {
		if (!$this->isLoggedIn()) {
			return FALSE;
		}
		if (strpos($resource, ':')) {
			list($resource, $privilege) = explode(':', $resource);
		}

		return $this->getAuthorizator()->isAllowed($this->getEntity()->getRole(), $resource, $privilege);
	}

}
