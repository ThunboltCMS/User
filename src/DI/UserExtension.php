<?php declare(strict_types = 1);

namespace Thunbolt\User\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Security\IAuthenticator;
use Thunbolt\User\Authenticator;
use Thunbolt\User\Forms\SignInForm;
use Thunbolt\User\Interfaces\ISignInForm;
use Thunbolt\User\Interfaces\IUserDAO;
use Thunbolt\User\Statically\StaticAuthenticator;
use Thunbolt\User\Statically\StaticUserDAO;
use Thunbolt\User\User;
use Thunbolt\User\Statically\StaticUserList;
use Thunbolt\User\UserStorage;

class UserExtension extends CompilerExtension {

	public function getConfigSchema(): Schema {
		return Expect::structure([
			'authenticator' => Expect::string(),
			'users' => Expect::arrayOf(
				Expect::structure([
					'id' => Expect::string()->required(),
					'name' => Expect::string()->required(),
					'password' => Expect::string()->required(),
					'admin' => Expect::bool(false),
				])
			),
			'userClass' => Expect::string(User::class),
			'registration' => Expect::structure([
				'signInForm' => Expect::bool(false),
			]),
		]);
	}

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();
		$config = (array) $this->getConfig();

		if ($config['users']) {
			$builder->addDefinition($this->prefix('userList'))
				->setFactory(StaticUserList::class, [$config['users']]);

			$builder->addDefinition($this->prefix('userDAO'))
				->setType(IUserDAO::class)
				->setFactory(StaticUserDAO::class);

			if ($config['authenticator']) {
				$builder->addDefinition($this->prefix('staticAuthenticator'))
					->setType(IAuthenticator::class)
					->setFactory(StaticAuthenticator::class)
					->setAutowired(false);
			} else {
				$config['authenticator'] = StaticAuthenticator::class;
			}
		} else {
			if (!$config['authenticator']) {
				$config['authenticator'] = Authenticator::class;
			}
		}

		if ($config['registration']->signInForm) {
			$builder->addDefinition($this->prefix('signInForm'))
				->setType(ISignInForm::class)
				->setFactory(SignInForm::class);
		}	

		$builder->addDefinition($this->prefix('authenticator'))
			->setClass(IAuthenticator::class)
			->setFactory($config['authenticator']);
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
