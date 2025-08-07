<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vehicles Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \App\Model\Entity\Vehicle newEmptyEntity()
 * @method \App\Model\Entity\Vehicle newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Vehicle> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vehicle get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Vehicle findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Vehicle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Vehicle> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vehicle|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Vehicle saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Vehicle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vehicle>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Vehicle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vehicle> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Vehicle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vehicle>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Vehicle>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Vehicle> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VehiclesTable extends Table
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

        $this->setTable('vehicles');
        $this->setDisplayField('registration_number');
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
        $this->hasMany('Inspections', [
            'foreignKey' => 'vehicle_id',
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
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->scalar('registration_number')
            ->maxLength('registration_number', 20)
            ->requirePresence('registration_number', 'create')
            ->notEmptyString('registration_number');

        // $validator
        //     ->scalar('brand')
        //     ->maxLength('brand', 50)
        //     ->requirePresence('brand', 'create')
        //     ->notEmptyString('brand');

        // $validator
        //     ->scalar('model')
        //     ->maxLength('model', 50)
        //     ->requirePresence('model', 'create')
        //     ->notEmptyString('model');

        $validator
            ->scalar('gender_id')
            ->maxLength('gender_id', 20)
            ->requirePresence('gender_id', 'create')
            ->notEmptyString('gender_id'); 
            
        // $validator
        //     ->decimal('weight')
        //     ->requirePresence('weight', 'create')
        //     ->notEmptyString('weight');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
}
