<?php

namespace Thunbolt\User;

use Nette\Security\IAuthorizator;
use Thunbolt\User\Interfaces\IEntity;

interface IUser {

	/**
	 * @return int
	 */
	public function getId();

	/**
	 * Why was user logged out?
	 * @return int
	 */
	public function getLogoutReason();

	/**
	 * @return IIdentity
	 */
	public function getIdentity();

	/**
	 * @return IEntity|\Model\User
	 */
	public function getEntity();

	/**
	 * @return bool
	 */
	public function isAdmin();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getAvatar();

	/**
	 * @return bool
	 */
	public function isMonitoring();

	/**
	 * @return null|string
	 */
	public function getRoleName();

	/**
	 * @return \DateTime|null
	 */
	public function getRegistrationDate();

	public function merge();

	/**
	 * @param mixed $resource
	 * @param mixed $privilege
	 * @return mixed
	 */
	public function isAllowed($resource = IAuthorizator::ALL, $privilege = IAuthorizator::ALL);

	/**
	 * Conducts the authentication process. Parameters are optional.
	 * @param mixed $id optional parameter (e.g. username or IIdentity)
	 * @param mixed $password optional parameter (e.g. password)
	 * @return void
	 * @throws BadPasswordException if authentication was not successful
	 * @throws UserNotFoundException if authentication was not successful
	 */
	public function login($id = NULL, $password = NULL);

	/**
	 * Logs out the user from the current session.
	 * @param bool $clearIdentity clear the identity from persistent storage?
	 * @return void
	 */
	public function logout($clearIdentity = FALSE);

	/**
	 * Is this user authenticated?
	 * @return bool
	 */
	public function isLoggedIn();

}
