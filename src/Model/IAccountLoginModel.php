<?php declare(strict_types = 1);

namespace Thunbolt\User\Model;

use Thunbolt\User\Interfaces\IAccount;

interface IAccountLoginModel {

	/**
	 * @param mixed $id
	 */
	public function findAccountByLoginColumn($id): ?IAccount;

	/**
	 * @param mixed $id
	 */
	public function findById($id): ?IAccount;

	public function persist(IAccount $account);

}
