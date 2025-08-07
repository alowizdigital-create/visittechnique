<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Genders Model
 *
 * @property \App\Model\Table\DiscountsTable&\Cake\ORM\Association\HasMany $Discounts
 * @property \App\Model\Table\InspectionsTable&\Cake\ORM\Association\HasMany $Inspections
 *
 * @method \App\Model\Entity\Gender newEmptyEntity()
 * @method \App\Model\Entity\Gender newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Gender> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Gender get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Gender findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Gender patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Gender> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Gender|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Gender saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Gender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gender>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Gender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gender> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Gender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gender>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Gender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gender> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GendersTable extends Table
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

        $this->setTable('genders');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Discounts', [
            'foreignKey' => 'gender_id',
        ]);
        $this->hasMany('Inspections', [
            'foreignKey' => 'gender_id',
        ]);
        $this->hasMany('Vehicles', [
            'foreignKey' => 'gender_id',
        ]);
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
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('note')
            ->allowEmptyString('note');

        $validator
            ->integer('create_uid')
            ->requirePresence('create_uid', 'create')
            ->notEmptyString('create_uid');

        $validator
            ->integer('write_uid')
            ->requirePresence('write_uid', 'create')
            ->notEmptyString('write_uid');

        $validator
            ->uuid('uuid')
            ->requirePresence('uuid', 'create')
            ->notEmptyString('uuid');

        return $validator;
    }
}
