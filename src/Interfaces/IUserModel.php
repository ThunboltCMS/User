<?php

namespace Thunbolt\User\Interfaces;

interface IUserModel {

	/**
	 * @param string $password
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
	public function getName();

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
