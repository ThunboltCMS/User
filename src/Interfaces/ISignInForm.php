<?php declare(strict_types = 1);

namespace Thunbolt\User\Interfaces;

use Nette\Application\UI\Form;

interface ISignInForm {

	/**
	 * @return Form
	 */
	public function createSignIn(): Form;

}
