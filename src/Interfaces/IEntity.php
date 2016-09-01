<?php

namespace Thunbolt\User\Interfaces;

interface IEntity {

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
