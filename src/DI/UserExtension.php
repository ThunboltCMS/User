<?php

declare(strict_types=1);

namespace Thunbolt\User\DI;

use Nette\DI\CompilerExtension;
use Nette\Security\IAuthenticator;
use Thunbolt\User\Authenticator;
use Thunbolt\User\Interfaces\IUserDAO;
use Thunbolt\User\Statically\StaticAuthenticator;
use Thunbolt\User\Statically\StaticUserDAO;
use Thunbolt\User\User;
use Thunbolt\User\Statically\StaticUserList;
use Thunbolt\User\UserStorage;

class UserExtension extends CompilerExtension {

	/** @var array */
	public $defaults = [
		'authenticator' => Authenticator::class,
		'users' => [],
	];

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		if ($config['users']) {
			$builder->addDefinition($this->prefix('userList'))
				->setClass(StaticUserList::class, [$config['users']]);

			$builder->addDefinition($this->prefix('userDAO'))
				->setClass(IUserDAO::class)
				->setFactory(StaticUserDAO::class);

			$config['authenticator'] = StaticAuthenticator::class;
		}

		$builder->addDefinition($this->prefix('authenticator'))
			->setClass(IAuthenticator::class)
			->setFactory($config['authenticator']);
	}

	public function beforeCompile(): void {
		$builder = $this->getContainerBuilder();

		$builder->getDefinition('security.userStorage')
			->setFactory(UserStorage::class);

		$builder->getDefinition('user')
			->setClass(User::class)
			->setFactory(User::class);
	}

}
