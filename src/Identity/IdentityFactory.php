<?php declare(strict_types = 1);

namespace Thunbolt\User\Identity;

final class IdentityFactory implements IIdentityFactory {

	public function create($id, $entity) {
		return new Identity($id, $entity);
	}

}
