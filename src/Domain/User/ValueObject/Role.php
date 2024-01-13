<?php

declare(strict_types=1);

namespace Domain\User\ValueObject;

enum Role: string
{
    case User = 'ROLE_USER';
    case RestaurantStaff = 'ROLE_RESTAURANT_STAFF';
    case RestaurantAdmin = 'ROLE_RESTAURANT_ADMIN';
    case Admin = 'ROLE_ADMIN';
}
