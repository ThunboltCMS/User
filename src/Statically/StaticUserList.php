<?php

declare(strict_types=1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\Interfaces\IUserModel;

class StaticUserList {

	/** @var array */
	private $users;

	public function __construct(array $users) {
		$this->users = $users;
	}

	public function getById($id): ?IUserModel {
		if (!isset($this->users[$id])) {
			return NULL;
		}

		return new StaticUserModel($this->extract($id));
	}

	public function login($id, $password): ?IUserModel {
		if (!isset($this->users[$id])) {
			return NULL;
		}

		$data = $this->extract($id);
		if ($data['password'] !== $password) {
			return NULL;
		}

		return new StaticUserModel($data);
	}

	private function extract($id): array {
		$defaults = [
			'id' => $id,
			'name' => $id,
			'registration' => NULL,
			'avatar' => NULL,
			'admin' => FALSE,
		];
		if (is_array($this->users[$id])) {
			return $this->users[$id] + $defaults;
		}

		$defaults['password'] = $this->users[$id];

		return $defaults;
	}


}
