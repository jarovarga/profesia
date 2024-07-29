<?php

declare(strict_types=1);

namespace App\src\Model\Entity;

use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * @property string $uuid
 * @property string $entity
 * @property string $meta
 * @property string $value
 * @property DateTime $created
 * @property DateTime $modified
 * @property bool $is_public
 */
class Metadata extends Entity
{
    /**
     * $_accessible is an array that defines the accessibility of properties in a class/entity.
     *
     * The keys in the $_accessible array represent the properties in the class/entity, and the values
     * represent whether the corresponding property can be accessed or modified from outside the class/entity.
     *
     * This array should be defined inside the class/entity and can be used to implement getter and setter methods,
     * access control and data validation logic for the properties.
     *
     * The following properties are defined in the $_accessible array:
     *
     * - 'entity': If set to true, the 'entity' property can be accessed from outside the class/entity.
     * - 'meta': If set to true, the 'meta' property can be accessed from outside the class/entity.
     * - 'value': If set to true, the 'value' property can be accessed from outside the class/entity.
     * - 'created': If set to false, the 'created' property cannot be accessed or modified from outside the class/entity.
     * - 'modified': If set to true, the 'modified' property can be accessed from outside the class/entity.
     * - 'is_public': If set to true, the 'is_public' property can be accessed from outside the class/entity.
     *
     * Example usage:
     *
     * ```
     * class MyClass {
     *     private $entity;
     *     private $meta;
     *     private $value;
     *     private $created;
     *     private $modified;
     *     private $is_public;
     *
     *     protected $_accessible = [
     *         'entity' => true,
     *         'meta' => true,
     *         'value' => true,
     *         'created' => false,
     *         'modified' => true,
     *         'is_public' => true,
     *     ];
     *
     *     // Implement getter and setter methods based on the $_accessible array
     *     // ...
     * }
     * ```
     */
    protected array $_accessible = [
        'entity' => true,
        'meta' => true,
        'value' => true,
        'created' => false,
        'modified' => true,
        'is_public' => true,
    ];
}
