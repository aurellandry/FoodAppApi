<?php

declare(strict_types=1);

namespace Domain\User\Service;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\Entity\User as UserDomain;

interface UserPersistenceQuery
{
    public function findByIdentifier(UserIdentifier $id): ?UserDomain;

    public function findByEmail(Email $email): ?UserDomain;
}
