<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Closure;
use Psr\SimpleCache\CacheInterface;

/**
 * @method User newEmptyEntity()
 * @method User newEntity(array $data, array $options = [])
 * @method array<User> newEntities(array $data, array $options = [])
 * @method User get(mixed $primaryKey, array|string $finder = 'all', CacheInterface|string|null $cache = null, Closure|string|null $cacheKey = null, mixed ...$args)
 * @method User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method User patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method array<User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method User|false save(EntityInterface $entity, array $options = [])
 * @method User saveOrFail(EntityInterface $entity, array $options = [])
 * @method iterable<User>|ResultSetInterface<User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<User>|ResultSetInterface<User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<User>|ResultSetInterface<User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<User>|ResultSetInterface<User> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initializes the class with the given configuration
     *
     * @param array $config The configuration array
     *
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('uuid');

        $this->addBehavior('Timestamp');
    }

    /**
     * Updates the value of the "password" field with the value of the "new_password" field, if the "new_password" field is not empty.
     *
     * @param EventInterface $event The event object.
     * @param ArrayObject $data The data array object.
     * @param ArrayObject $options The options array object.
     *
     * @return void
     */
    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        if (!empty($data['new_password'])) {
            $data['password'] = $data['new_password'];
        }
    }

    /**
     * Validates the default fields of the entity.
     *
     * @param Validator $validator The validator instance.
     *
     * @return Validator The updated validator instance.
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('role')
            ->maxLength('role', 50)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->boolean('is_public')
            ->notEmptyString('is_public');

        return $validator;
    }

    /**
     * Builds rules for validating uniqueness of username and email fields.
     *
     * @param RulesChecker $rules The rules checker object.
     *
     * @return RulesChecker The updated rules checker object.
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }

    /**
     * Finds public users based on the provided query.
     *
     * @param Query $query The query to filter public users.
     *
     * @return Query The modified query object.
     */
    public function findPublicUser(Query $query): Query
    {
        return $query->where(['is_public' => true]);
    }
}
