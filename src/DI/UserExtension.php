<?php

declare(strict_types=1);

namespace Thunbolt\User\DI;

use Nette\DI\CompilerExtension;
use Thunbolt\User\Authenticator;
use Thunbolt\User\User;
use Thunbolt\User\UserStorage;

class UserExtension extends CompilerExtension {

	/** @var array */
	public $defaults = [
		'authenticator' => Authenticator::class
	];

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$builder->addDefinition($this->prefix('authenticator'))
			->setClass($config['authenticator']);
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
