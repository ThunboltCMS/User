<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Kdyby\Doctrine\EntityManager;
use Nette\Security\IAuthenticator;
use Nette\Security;
use Thunbolt\User\Interfaces\IUserRepository;
use Thunbolt\User\Interfaces\IUserModel;

class Authenticator implements IAuthenticator {

	/** @var EntityManager */
	private $em;

	/** @var string */
	private $repository;

	public function __construct(string $repository, EntityManager $em) {
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
	public function authenticate(array $credentials): Security\IIdentity {
		list($email, $password) = $credentials;

		$repository = $this->em->getRepository($this->repository);
		if (!$repository instanceof IUserRepository) {
			throw new UserException('Repository must implements ' . IUserRepository::class);
		}

		$row = $repository->login($email);
		if (!$row) {
			throw new UserNotFoundException();
		} else if (!$row instanceof IUserModel) {
			throw new UserException('User entity must implements ' . IUserModel::class);
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
