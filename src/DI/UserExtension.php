<?php

namespace Thunbolt\User\DI;

use Nette\DI\CompilerExtension;
use Thunbolt\User\User;
use Thunbolt\User\UserStorage;

class UserExtension extends CompilerExtension {

	/** @var array */
	public $defaults = [
		'entity' => 'Model\User'
	];

	public function beforeCompile() {
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$builder->getDefinition('security.userStorage')
			->setFactory(UserStorage::class)
			->addSetup('setRepository', [$config['entity']]);

		$builder->getDefinition('user')
			->setClass(User::class)
			->setFactory(User::class)
			->addSetup('setAuthenticator', [$this->prefix('@authenticator')]);
	}

}
