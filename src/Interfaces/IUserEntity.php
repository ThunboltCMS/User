<?php declare(strict_types = 1);

namespace Thunbolt\User\Interfaces;

interface IUserEntity {

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void;

	/**
	 * @return string
	 */
	public function getPassword(): string;

	/**
	 * @return mixed
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getName(): string;

}
