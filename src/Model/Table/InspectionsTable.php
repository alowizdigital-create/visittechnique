<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inspections Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\GendersTable&\Cake\ORM\Association\BelongsTo $Genders
 * @property \App\Model\Table\MessagesTable&\Cake\ORM\Association\HasMany $Messages
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\Inspection newEmptyEntity()
 * @method \App\Model\Entity\Inspection newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Inspection> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inspection get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Inspection findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Inspection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Inspection> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inspection|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Inspection saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InspectionsTable extends Table
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

        $this->setTable('inspections');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('Genders', [
            'foreignKey' => 'gender_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Vehicles', [
            'foreignKey' => 'vehicle_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'inspection_id',
        ]);
        // $this->hasMany('Payments', [
        //     'foreignKey' => 'inspection_id',
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
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->integer('gender_id')
            ->notEmptyString('gender_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmptyDateTime('end_date');

        $validator
            ->integer('create_uid')
            ->requirePresence('create_uid', 'create')
            ->notEmptyString('create_uid');

        $validator
            ->scalar('vehicle_id')
            ->maxLength('vehicle_id', 20)
            ->requirePresence('vehicle_id', 'create')
            ->notEmptyString('vehicle_id'); 

        $validator
            ->integer('write_uid')
            ->requirePresence('write_uid', 'create')
            ->notEmptyString('write_uid');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 36)
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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['gender_id'], 'Genders'), ['errorField' => 'gender_id']);

        return $rules;
    }
}
