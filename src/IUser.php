<?php

namespace Thunbolt\User;

use Nette\Security\IAuthorizator;
use Thunbolt\User\Interfaces\IEntity;
use Nette\Security\IIdentity;

interface IUser {

	/**
	 * @return int
	 */
	public function getId();

	/**
	 * Why was user logged out?
	 * @return int
	 */
	public function getLogoutReason(): ?int;

	/**
	 * @return IIdentity
	 */
	public function getIdentity(): ?IIdentity;

	/**
	 * @return IEntity|\Model\User
	 */
	public function getEntity();

	/**
	 * @return bool
	 */
	public function isAdmin(): bool;

	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @return string|null
	 */
	public function getAvatar(): ?string;

	/**
	 * @return null|string
	 */
	public function getRoleName(): ?string;

	/**
	 * @return \DateTime|null
	 */
	public function getRegistrationDate(): ?\DateTime;

	public function merge(): void;

	/**
	 * @param mixed $resource
	 * @param mixed $privilege
	 * @return bool
	 */
	public function isAllowed($resource = IAuthorizator::ALL, $privilege = IAuthorizator::ALL): bool;

	/**
	 * Conducts the authentication process. Parameters are optional.
	 * @param mixed $id optional parameter (e.g. username or IIdentity)
	 * @param mixed $password optional parameter (e.g. password)
	 * @return void
	 * @throws BadPasswordException if authentication was not successful
	 * @throws UserNotFoundException if authentication was not successful
	 */
	public function login($id = NULL, $password = NULL): void;

	/**
	 * Logs out the user from the current session.
	 * @param bool $clearIdentity clear the identity from persistent storage?
	 * @return void
	 */
	public function logout(bool $clearIdentity = FALSE): void;

	/**
	 * Is this user authenticated?
	 * @return bool
	 */
	public function isLoggedIn(): bool;

}
