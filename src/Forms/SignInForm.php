<?php declare(strict_types = 1);

namespace Thunbolt\User\Forms;

use Nette\Application\UI\Form;
use Nette\SmartObject;
use Thunbolt\User\BadPasswordException;
use Thunbolt\User\Interfaces\ISignInForm;
use Thunbolt\User\User;
use Thunbolt\User\UserNotFoundException;

class SignInForm implements ISignInForm {
	
	use SmartObject;

	/** @var User */
	private $user;

	public function __construct(User $user) {
		$this->user = $user;
	}

	public function createSignIn(): Form {
		$form = new Form();

		$form->addText('name', 'Email')
			->setRequired()
			->addRule($form::EMAIL);

		$form->addPassword('password', 'Heslo')
			->setRequired();

		$form->addCheckbox('remember', 'Zapamatovat');

		$form->addSubmit('send', 'Přihlásit se');
		$form->onSuccess[] = [$this, 'successSignIn'];

		return $form;
	}

	public function successSignIn(Form $form, array $values): void {
		$this->user->setExpiration('14 days');

		try {
			$this->user->login($values['name'], $values['password']);
		} catch (BadPasswordException $e) {
			$form->addError('Špatně zadané heslo.');
		} catch (UserNotFoundException $e) {
			$form->addError('Tento uživatel neexistuje.');
		}
	}

}
