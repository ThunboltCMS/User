<?php

namespace Thunbolt\User\Interfaces;

interface IUser {

	/**
	 * @param string $password
	 * @return mixed
	 */
	public function setPassword($password);

	/**
	 * @return string
	 */
	public function getPassword();

	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @return IRole|null
	 */
	public function getRole();

	/**
	 * @return string
	 */
	public function getUserName();

	/**
	 * @return bool
	 */
	public function isMonitoring();

	/**
	 * @return string
	 */
	public function getAvatar();

	/**
	 * @return bool
	 */
	public function isAdmin();

	/**
	 * @return \DateTime|null
	 */
	public function getRegistrationDate();

}
