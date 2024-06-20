<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Metadata;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Closure;
use Psr\SimpleCache\CacheInterface;

/**
 * @method Metadata newEmptyEntity()
 * @method Metadata newEntity(array $data, array $options = [])
 * @method array<Metadata> newEntities(array $data, array $options = [])
 * @method Metadata get(mixed $primaryKey, array|string $finder = 'all', CacheInterface|string|null $cache = null, Closure|string|null $cacheKey = null, mixed ...$args)
 * @method Metadata findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method Metadata patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method array<Metadata> patchEntities(iterable $entities, array $data, array $options = [])
 * @method Metadata|false save(EntityInterface $entity, array $options = [])
 * @method Metadata saveOrFail(EntityInterface $entity, array $options = [])
 * @method iterable<Metadata>|ResultSetInterface<Metadata>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<Metadata>|ResultSetInterface<Metadata> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<Metadata>|ResultSetInterface<Metadata>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<Metadata>|ResultSetInterface<Metadata> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin TimestampBehavior
 */
class MetadataTable extends Table
{
    /**
     * Initializes the object with the given configuration.
     *
     * @param array $config The configuration to initialize the object with.
     *
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->setTable('metadata');
        $this->setDisplayField('entity');
        $this->setPrimaryKey('uuid');

        $this->addBehavior('Timestamp');
    }

    /**
     * Validates the default values for an entity.
     *
     * @param Validator $validator The validator object to apply validation rules to.
     *
     * @return Validator The validator object with the applied validation rules.
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('entity')
            ->maxLength('entity', 50)
            ->requirePresence('entity', 'create')
            ->notEmptyString('entity');

        $validator
            ->scalar('meta')
            ->maxLength('meta', 50)
            ->requirePresence('meta', 'create')
            ->notEmptyString('meta');

        $validator
            ->scalar('value')
            ->maxLength('value', 100)
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        $validator
            ->boolean('is_public')
            ->notEmptyString('is_public');

        return $validator;
    }
}
