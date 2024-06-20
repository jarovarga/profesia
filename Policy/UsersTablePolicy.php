<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Enum\UserRole;
use Authorization\IdentityInterface;

class UsersTablePolicy
{
    /**
     * Checks whether the given identity can perform indexing action.
     *
     * @param IdentityInterface $identity The identity to check.
     *
     * @return bool Returns true if the identity has the role of an admin, false otherwise.
     */
    public function canIndex(IdentityInterface $identity): bool
    {
        return $identity->offsetGet('role') === UserRole::Admin->value;
    }
}
