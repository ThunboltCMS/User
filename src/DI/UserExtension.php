<?php

declare(strict_types=1);

namespace Thunbolt\User\DI;

use Nette\DI\CompilerExtension;
use Thunbolt\User\Authenticator;
use Thunbolt\User\Authorizator;
use Thunbolt\User\User;
use Thunbolt\User\UserStorage;

class UserExtension extends CompilerExtension {

	/** @var array */
	public $defaults = [
		'entity' => 'Model\User',
		'authenticator' => Authenticator::class,
		'authorizator' => [
			'enable' => TRUE,
			'class' => Authorizator::class
		]
	];

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$builder->addDefinition($this->prefix('authenticator'))
			->setClass($config['authenticator'], [$config['entity']]);

		$builder->addDefinition($this->prefix('authorizator'))
			->setClass($config['authorizator']['class'], [$config['authorizator']['enable']]);
	}

	public function beforeCompile(): void {
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
