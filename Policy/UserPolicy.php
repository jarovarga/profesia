<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use App\Model\Enum\UserRole;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class UserPolicy implements BeforePolicyInterface
{
    /**
     * Check if the given identity can access the specified resource for the provided action.
     *
     * @param IdentityInterface|null $identity The identity to check.
     * @param mixed $resource The resource to check access for.
     * @param string $action The action to check access for.
     *
     * @return ResultInterface|bool|null Returns a ResultInterface object if access is granted, true if the identity has admin role, and null if access is denied.
     */
    public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
    {
        if ($this->hasAdminRole($identity)) {
            return true;
        }

        return null;
    }

    /**
     * Checks if the given user can profile the provided identity.
     *
     * @param IdentityInterface $identity The identity to be profiled
     * @param User $user The user who wants to profile the identity
     *
     * @return bool Whether the user can profile the identity or not
     */
    public function canProfile(IdentityInterface $identity, User $user): bool
    {
        return $this->sameUser($identity, $user);
    }

    /**
     * Checks if the current user has the ability to impersonate other users.
     *
     * @return bool Returns true if the current user can impersonate other users, otherwise returns false.
     */
    public function canImpersonate(): bool
    {
        return false;
    }

    /**
     * Checks if the current user has the ability to add content.
     *
     * @return bool Returns true if the current user can add content, otherwise returns false.
     */
    public function canAdd(): bool
    {
        return false;
    }

    /**
     * Checks if the current user has the ability to edit.
     *
     * @return bool Returns true if the current user can edit, otherwise returns false.
     */
    public function canEdit(): bool
    {
        return false;
    }

    /**
     * Checks if the given identity has the admin role.
     *
     * @param IdentityInterface|null $identity The identity to check.
     *
     * @return bool Returns true if the identity has the admin role, otherwise returns false.
     */
    private function hasAdminRole(?IdentityInterface $identity): bool
    {
        return $identity->offsetGet('role') === UserRole::Admin->value;
    }

    /**
     * Checks if the provided identity is the same as the provided user.
     *
     * @param IdentityInterface $identity The identity to check.
     * @param User $user The user to compare against.
     *
     * @return bool Returns true if the provided identity is the same as the provided user, otherwise returns false.
     */
    private function sameUser(IdentityInterface $identity, User $user): bool
    {
        return $identity->offsetGet('uuid') === $user->uuid;
    }
}
