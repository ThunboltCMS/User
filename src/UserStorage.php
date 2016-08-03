<?php

namespace Thunbolt\User;

use Kdyby\Doctrine\EntityManager;
use Nette\Http\Session;
use Nette\Http;
use Thunbolt\User\Interfaces\IRepository;

class UserStorage extends Http\UserStorage {

	/** @var EntityManager */
	private $em;

	/** @var string */
	private $repository = 'Entity\User';

	/** @var Identity */
	private $identity;

	/**
	 * @param Session $sessionHandler
	 * @param EntityManager $em
	 */
	public function __construct(Session $sessionHandler, EntityManager $em) {
		parent::__construct($sessionHandler);

		$this->em = $em;
	}

	/**
	 * Is this user authenticated and exists in db?
	 *
	 * @return bool
	 */
	public function isAuthenticated() {
		$authenticated = parent::isAuthenticated();
		if ($authenticated && $this->getIdentity() instanceof Identity && !$this->getIdentity()->getEntity()) { // User not exists in DB
			$this->setAuthenticated(FALSE);
			$this->setIdentity(NULL);

			return FALSE;
		}

		return $authenticated;
	}

	/**
	 * Returns current user identity, if any.
	 *
	 * @return \Nette\Security\IIdentity|Identity
	 */
	public function getIdentity() {
		if ($this->identity) {
			return $this->identity;
		}
		$identity = parent::getIdentity();

		if ($identity instanceof Identity) {
			$repository = $this->em->getRepository($this->repository);
			if ($repository instanceof IRepository) {
				$entity = $repository->getUserById($identity->getId());
			} else {
				$entity = $repository->find($identity->getId());
			}

			$this->identity = new Identity($identity->getId(), $entity);
		}

		return $this->identity;
	}

	/**
	 * @param string $repository
	 * @return self
	 */
	public function setRepository($repository) {
		$this->repository = $repository;

		return $this;
	}

}
