<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Shortcuts Model
 *
 * @method \App\Model\Entity\Shortcut newEmptyEntity()
 * @method \App\Model\Entity\Shortcut newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Shortcut> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shortcut get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Shortcut findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Shortcut patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Shortcut> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shortcut|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Shortcut saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Shortcut>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shortcut>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Shortcut>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shortcut> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Shortcut>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shortcut>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Shortcut>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shortcut> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShortcutsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('shortcuts');
        $this->setDisplayField('url');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        // $validator
        //     ->scalar('shorturl')
        //     ->maxLength('shorturl', 100)
        //     ->requirePresence('shorturl', 'create')
        //     ->notEmptyString('shorturl');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 40)
            ->requirePresence('uuid', 'create')
            ->notEmptyString('uuid');

        $validator
            ->integer('create_uid')
            ->requirePresence('create_uid', 'create')
            ->notEmptyString('create_uid');

        $validator
            ->integer('write_uid')
            ->requirePresence('write_uid', 'create')
            ->notEmptyString('write_uid');

        return $validator;
    }
}
