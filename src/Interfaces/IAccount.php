<?php declare(strict_types = 1);

namespace Thunbolt\User\Interfaces;

interface IAccount {

	/**
	 * @return mixed
	 */
	public function getId();

	/**
	 * @param string $password
	 */
	public function setPassword(string $password);

	/**
	 * @return string
	 */
	public function getPassword(): string;

}
