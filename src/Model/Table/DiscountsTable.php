<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Discounts Model
 *
 * @property \App\Model\Table\GendersTable&\Cake\ORM\Association\BelongsTo $Genders
 *
 * @method \App\Model\Entity\Discount newEmptyEntity()
 * @method \App\Model\Entity\Discount newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Discount> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Discount get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Discount findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Discount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Discount> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Discount|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Discount saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Discount>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Discount>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Discount>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Discount> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Discount>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Discount>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Discount>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Discount> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiscountsTable extends Table
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

        $this->setTable('discounts');
        $this->setDisplayField('amount');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // $this->belongsTo('Genders', [
        //     'foreignKey' => 'gender_id',
        //     'joinType' => 'INNER',
        // ]);
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
            ->scalar('amount')
            ->maxLength('amount', 50)
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // $rules->add($rules->existsIn(['gender_id'], 'Genders'), ['errorField' => 'gender_id']);

        return $rules;
    }
}
