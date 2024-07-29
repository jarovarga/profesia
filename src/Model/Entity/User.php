<?php

declare(strict_types=1);

namespace App\Model\Entity;

use ArrayAccess;
use Authentication\IdentityInterface as AuthenticationIdentity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityInterface as AuthorizationIdentity;
use Authorization\Policy\ResultInterface;
use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * @property string $uuid
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $role
 * @property DateTime $created
 * @property DateTime $modified
 * @property bool $is_public
 *
 * @property mixed $authorization
 */
class User extends Entity implements AuthenticationIdentity, AuthorizationIdentity
{
    /**
     * @var array $_accessible An array that defines the accessibility of properties in the class.
     *
     * Each key represents a property name, and the corresponding value indicates whether the property can be accessed or not.
     *
     * @property bool $username Indicates whether the 'username' property can be accessed.
     * @property bool $email Indicates whether the 'email' property can be accessed.
     * @property bool $password Indicates whether the 'password' property can be accessed.
     * @property bool $role Indicates whether the 'role' property can be accessed.
     * @property bool $created Indicates whether the 'created' property can be accessed.
     * @property bool $modified Indicates whether the 'modified' property can be accessed.
     * @property bool $is_public Indicates whether the 'is_public' property can be accessed.
     */
    protected array $_accessible = [
        'username' => true,
        'email' => true,
        'password' => true,
        'role' => true,
        'created' => false,
        'modified' => true,
        'is_public' => true,
    ];

    /**
     * An array that contains the names of the properties that should be hidden or excluded when the object is serialized or converted to an array.
     *
     * @var array
     * @access private
     */
    protected array $_hidden = [
        'password',
        'authorization',
    ];

    /**
     * Checks if the current user is authorized to perform the specified action on the given resource.
     *
     * @param string $action The action to be performed.
     * @param mixed $resource The resource on which the action will be performed.
     *
     * @return bool True if the current user is authorized to perform the action, false otherwise.
     */
    public function can(string $action, mixed $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    /**
     * Checks if the current user is authorized to perform the specified action on the given resource,
     * and returns the result as a ResultInterface object.
     *
     * @param string $action The action to be performed.
     * @param mixed $resource The resource on which the action will be performed.
     *
     * @return ResultInterface The authorization result as a ResultInterface object.
     */
    public function canResult(string $action, mixed $resource): ResultInterface
    {
        return $this->authorization->canResult($this, $action, $resource);
    }

    /**
     * Applies the specified scope to the given resource for the current user.
     *
     * @param string $action The action to be performed.
     * @param mixed $resource The resource to be scoped.
     * @param mixed ...$optionalArgs Optional arguments to be passed to the underlying applyScope method.
     *
     * @return mixed The scoped resource for the current user.
     */
    public function applyScope(string $action, mixed $resource, ...$optionalArgs): mixed
    {
        return $this->authorization->applyScope($this, $action, $resource, ...$optionalArgs);
    }

    /**
     * Retrieves the original data of the object.
     *
     * @return ArrayAccess|array The original data of the object.
     */
    public function getOriginalData(): ArrayAccess|array
    {
        return $this;
    }

    /**
     * Retrieves the identifier of the object.
     *
     * @return array|int|string|null The identifier of the object.
     */
    public function getIdentifier(): array|int|string|null
    {
        return $this->id;
    }

    /**
     * Sets the authorization service for this object.
     *
     * @param AuthorizationServiceInterface $service The authorization service to be set.
     *
     * @return static The modified object instance.
     */
    public function setAuthorization(AuthorizationServiceInterface $service): static
    {
        $this->authorization = $service;

        return $this;
    }

    /**
     * Sets the password for the current user.
     *
     * @param string $password The new password to be set.
     *
     * @return string The hashed password.
     */
    protected function _setPassword(string $password): string
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }
}
