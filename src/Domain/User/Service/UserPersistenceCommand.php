<?php

declare(strict_types=1);

namespace Domain\User\Service;

use Domain\User\Entity\User;

interface UserPersistenceCommand
{
    public function save(User $user): void;
}
