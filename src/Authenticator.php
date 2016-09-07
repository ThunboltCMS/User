<?php

namespace Thunbolt\User;

use Kdyby\Doctrine\EntityManager;
use Nette\Security\IAuthenticator;
use Nette\Security;
use Thunbolt\User\Interfaces\IRepository;

class Authenticator implements IAuthenticator {

	/** @var EntityManager */
	private $em;

	/** @var string */
	private $repository;

	/**
	 * @param string $repository
	 * @param EntityManager $em
	 */
	public function __construct($repository, EntityManager $em) {
		$this->em = $em;
		$this->repository = $repository;
	}

	/**
	 * @param array $credentials
	 * @throws BadPasswordException
	 * @throws UserException
	 * @throws UserNotFoundException
	 * @return Security\IIdentity|Identity
	 */
	public function authenticate(array $credentials) {
		list($email, $password) = $credentials;

		$repository = $this->em->getRepository($this->repository);
		if (!$repository instanceof IRepository) {
			throw new UserException('Repository must be instance of ' . IRepository::class);
		}

		$row = $repository->login($email);
		if (!$row) {
			throw new UserNotFoundException();
		} elseif (!Security\Passwords::verify($password, $row->getPassword())) {
			throw new BadPasswordException();
		} elseif (Security\Passwords::needsRehash($row->getPassword())) {
			$row->setPassword($password);
			$this->em->merge($row);
			$this->em->flush();
		}

		return new Identity($row->getId(), $row);
	}

}
