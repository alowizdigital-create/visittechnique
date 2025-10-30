<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CashMovements Model
 *
 * @property \App\Model\Table\CashBoxesTable&\Cake\ORM\Association\BelongsTo $CashBoxes
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\CashMovement newEmptyEntity()
 * @method \App\Model\Entity\CashMovement newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CashMovement> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CashMovement get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CashMovement findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CashMovement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CashMovement> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CashMovement|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CashMovement saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CashMovement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashMovement>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CashMovement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashMovement> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CashMovement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashMovement>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CashMovement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashMovement> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CashMovementsTable extends Table
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

        $this->setTable('cash_movements');
        $this->setDisplayField('uuid');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CashBoxes', [
            'foreignKey' => 'cash_box_id',
            'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('Accounts', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
          $this->belongsTo('Inspections', [
            'foreignKey' => 'inspection_id',
            'joinType' => 'INNER',
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
            ->integer('cash_box_id')
            ->notEmptyString('cash_box_id');

        $validator
            ->scalar('type')
            ->maxLength('type', 155)
            ->allowEmptyString('type');

        $validator
            ->decimal('montant')
            ->requirePresence('montant', 'create')
            ->notEmptyString('montant');

        $validator
            ->scalar('motif')
            ->requirePresence('motif', 'create')
            ->notEmptyString('motif');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('justificatif')
            ->maxLength('justificatif', 255)
            ->allowEmptyString('justificatif');

        $validator
            ->integer('create_uid')
            ->requirePresence('create_uid', 'create')
            ->notEmptyString('create_uid');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 50)
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
        $rules->add($rules->existsIn(['cash_box_id'], 'CashBoxes'), ['errorField' => 'cash_box_id']);
        $rules->add($rules->existsIn(['user_id'], 'Accounts'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['inspection_id'], 'Inspections'), ['errorField' => 'inspection_id']);
        return $rules;
    }
}
