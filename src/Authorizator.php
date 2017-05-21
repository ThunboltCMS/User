<?php

declare(strict_types=1);

namespace Thunbolt\User;

use Nette\Security\IAuthorizator;

class Authorizator implements IAuthorizator {

	/** @var array */
	private $privileges = [];

	/** @var bool */
	private $enabled = TRUE;

	public function __construct(bool $enabled = TRUE) {
		$this->enabled = $enabled;
	}

	public function setEnabled(bool $enabled = TRUE): self {
		$this->enabled = $enabled;

		return $this;
	}

	public function setPrivileges(array $privileges): self {
		$this->privileges = $privileges;

		return $this;
	}

	public function isAllowedExtend($resource): bool {
		if (!$this->enabled) {
			return TRUE;
		}
		$status = NULL;

		// And
		foreach(explode('&', $resource) as $and) {
			if ($status === FALSE) {
				return FALSE;
			}

			$status = FALSE;

			// Or
			foreach (explode('|', $and) as $or) {
				$explode = explode(':', $or);

				$res = $explode[0];

				if (isset($explode[1])) {
					$privilege = $explode[1];
				} else {
					$privilege = NULL;
				}

				if ($this->isAllowed(NULL, $res, $privilege) === TRUE) {
					$status = TRUE;
					break;
				}
			}
		}

		return $status;
	}

	/**
	 * Performs a role-based authorization.
	 *
	 * @param mixed $role
	 * @param string $resource
	 * @param string $privilege
	 * @return bool
	 */
	public function isAllowed($role, $resource, $privilege): bool {
		if (!$this->enabled) {
			return TRUE;
		}
		if (!$privilege) {
			return (bool) preg_grep('#^' . preg_quote($resource) . ':#', $this->privileges);
		}

		return in_array($resource . ':' . $privilege, $this->privileges);
	}

}
