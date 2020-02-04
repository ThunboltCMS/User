<?php declare(strict_types = 1);

namespace Thunbolt\User\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Security\IAuthenticator;
use Thunbolt\User\Identity\IdentityFactory;
use Thunbolt\User\Identity\IIdentityFactory;
use Thunbolt\User\User;
use Thunbolt\User\UserStorage;

class UserExtension extends CompilerExtension {

	public function getConfigSchema(): Schema {
		return Expect::structure([
			'userClass' => Expect::string(User::class),
			'registration' => Expect::structure([
				'signInForm' => Expect::bool(false),
			]),
		]);
	}

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('identityFactory'))
			->setType(IIdentityFactory::class)
			->setFactory(IdentityFactory::class);

		if ($config->registration->signInForm) {
			$builder->addDefinition($this->prefix('signInForm'))
				->setType(ISignInForm::class)
				->setFactory(SignInForm::class);
		}
	}

	public function beforeCompile(): void {
		$builder = $this->getContainerBuilder();
		$config = (array) $this->getConfig();

		$builder->getDefinition('security.userStorage')
			->setFactory(UserStorage::class);

		if ($config['userClass']) {
			$builder->getDefinition('user')
				->setType($config['userClass'])
				->setFactory($config['userClass']);
		}
	}

}
