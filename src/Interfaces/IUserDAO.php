<?php

declare(strict_types=1);

namespace Thunbolt\User\Interfaces;

interface IUserDAO {

	public function merge(IUserEntity $model): void;

	public function getRepository(): IUserRepository;

}
