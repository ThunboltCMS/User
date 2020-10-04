<?php declare(strict_types = 1);

namespace Thunbolt\User;

use Nette\Http\Session;
use Nette\Http;
use Nette\Security\IIdentity;
use Thunbolt\User\Identity\IIdentityFactory;
use Thunbolt\User\Model\IAccountLoginModel;

class UserStorage extends Http\UserStorage {

	/** @var Identity */
	private $identity;

	/** @var IAccountLoginModel */
	private $model;

	/** @var IIdentityFactory */
	private $identityFactory;

	public function __construct(Session $sessionHandler, IAccountLoginModel $model, IIdentityFactory $identityFactory) {
		parent::__construct($sessionHandler);

		$this->model = $model;
		$this->identityFactory = $identityFactory;
	}

	public function setIdentity(IIdentity $identity = null) {
		if ($identity instanceof Identity\IIdentity || $identity === null) {
			$this->identity = $identity;
		}

		return parent::setIdentity($identity);
	}

	public function isAuthenticated(): bool {
		return parent::isAuthenticated() && $this->getIdentity() !== null;
	}

	public function getIdentity(): ?IIdentity {
		if ($this->identity === false) {
			$identity = parent::getIdentity();

			if ($identity) {
				$account = $this->model->findById($identity->getId());
				if (!$account) { // clear identity, account not found
					$this->setAuthenticated(false);
					$this->setIdentity(null);
				} else {
					$this->identity = $this->identityFactory->create($identity->getId(), $account);
				}
			} else {
				$this->identity = null;
			}
		}

		return $this->identity;
	}

}
