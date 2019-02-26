<?php declare(strict_types = 1);

namespace Thunbolt\User\Statically;

use Thunbolt\User\Interfaces\IUserEntity;
use Thunbolt\User\UserException;

class StaticUserList {

	/** @var array */
	private $users;

	public function __construct(array $users) {
		$this->users = $users;
	}

	public function getById($id): ?IUserEntity {
		if (!isset($this->users[$id])) {
			return null;
		}

		return new StaticUserEntity($this->extract($id));
	}

	public function login($id, $password): ?IUserEntity {
		if (!isset($this->users[$id])) {
			return null;
		}

		$data = $this->extract($id);
		if ($data['password'] !== $password) {
			return null;
		}

		return new StaticUserEntity($data);
	}

	private function extract($id): array {
		$defaults = [
			'id' => $id,
			'name' => $id,
			'admin' => false,
		];
		if (is_array($this->users[$id])) {
			if (!isset($this->users[$id]['password'])) {
				throw new UserException('Password is required in static user.');
			}

			return $this->users[$id] + $defaults;
		}

		$defaults['password'] = $this->users[$id];

		return $defaults;
	}

}
