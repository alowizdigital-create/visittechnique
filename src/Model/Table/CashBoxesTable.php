<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CashBoxes Model
 *
 * @property \App\Model\Table\CashMovementsTable&\Cake\ORM\Association\HasMany $CashMovements
 *
 * @method \App\Model\Entity\CashBox newEmptyEntity()
 * @method \App\Model\Entity\CashBox newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CashBox> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CashBox get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CashBox findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CashBox patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CashBox> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CashBox|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CashBox saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CashBox>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashBox>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CashBox>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashBox> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CashBox>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashBox>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CashBox>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CashBox> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CashBoxesTable extends Table
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

        $this->setTable('cash_boxes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CashMovements', [
            'foreignKey' => 'cash_box_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'responsable_id',
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->decimal('solde_initial')
            ->notEmptyString('solde_initial');

        $validator
            ->decimal('solde_actuel')
            ->notEmptyString('solde_actuel');

        $validator
            ->decimal('cashinput')
            ->notEmptyString('cashinput');

        $validator
            ->decimal('cashinout')
            ->notEmptyString('cashinout');

        $validator
            ->scalar('statut')
            ->maxLength('statut', 100)
            ->requirePresence('statut', 'create')
            ->notEmptyString('statut');

        $validator
            ->integer('responsable_id')
            ->requirePresence('responsable_id', 'create')
            ->notEmptyString('responsable_id');

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

     public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['responsable_id'], 'Users'), ['errorField' => 'responsable_id']);
        return $rules;
    }
}
