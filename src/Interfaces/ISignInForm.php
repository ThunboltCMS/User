<?php

namespace Thunbolt\User\Interfaces;

use WebChemistry\Forms\Form;

interface ISignInForm {

	/**
	 * @return Form
	 */
	public function createSignIn();

}
