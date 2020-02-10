<?php declare(strict_types = 1);

namespace Thunbolt\User\Authenticator;

use LogicException;
use Nette\Security\IAuthenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\SmartObject;
use Thunbolt\User\Exceptions\BadPasswordException;
use Thunbolt\User\Exceptions\UserNotFoundException;
use Thunbolt\User\Identity;
use Thunbolt\User\Interfaces\IAccount;
use Thunbolt\User\Model\IAccountLoginModel;

final class ModelAuthenticator implements IAuthenticator {

	use SmartObject;

	/** @var string */
	private $column;

	/** @var string */
	private $entity;

	/** @var IAccountLoginModel */
	private $model;

	/** @var Identity\IIdentityFactory */
	private $identityFactory;

	public function __construct(IAccountLoginModel $model, Identity\IIdentityFactory $identityFactory) {
		$this->model = $model;
		$this->identityFactory = $identityFactory;
	}

	/**
	 * @throws BadPasswordException
	 * @throws UserNotFoundException
	 */
	public function authenticate(array $credentials): IIdentity {
		[$identifier, $password] = $credentials;

		$account = $this->model->findAccountByLoginColumn($identifier);
		if ($account !== null && !$account instanceof IAccount) {
			throw new LogicException(sprintf('Result must be instance of %s or null', IAccount::class));
		}

		$hash = new Passwords();
		if (!$account) {
			throw new UserNotFoundException();
		} else if (!$hash->verify($password, $account->getPassword())) {
			throw new BadPasswordException();
		} else if ($hash->needsRehash($account->getPassword())) {
			$account->setPassword($password);

			$this->model->persist($account);
		}

		return $this->identityFactory->create($account->getId(), $account);
	}

}
