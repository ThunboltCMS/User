<?php

declare(strict_types=1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\BadPasswordException;
use Thunbolt\User\Identity;
use Thunbolt\User\Interfaces\IUserDAO;
use Nette\Security;
use Thunbolt\User\UserNotFoundException;

class StaticAuthenticator implements Security\IAuthenticator {

	/** @var IUserDAO */
	private $userDAO;

	public function __construct(IUserDAO $userDAO) {
		$this->userDAO = $userDAO;
	}

	/**
	 * @param array $credentials
	 * @throws BadPasswordException
	 * @throws UserNotFoundException
	 * @return Security\IIdentity|Identity
	 */
	public function authenticate(array $credentials): Security\IIdentity {
		list($email, $password) = $credentials;

		$repository = $this->userDAO->getRepository();

		$row = $repository->login($email);
		if (!$row) {
			throw new UserNotFoundException();

		} elseif ($password !== $row->getPassword()) {
			throw new BadPasswordException();

		}

		return new Identity($row->getId(), $row);
	}

}
